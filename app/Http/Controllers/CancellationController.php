<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderCancellationApproval;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CancellationController extends Controller
{
    private const MAX_ATTEMPTS = 3;

    /*
    |--------------------------------------------------------------------------
    | PEMBELI MENGAJUKAN PEMBATALAN
    |--------------------------------------------------------------------------
    |
    | dikemas  = belum diproses, bisa batal langsung.
    | diproses = sedang dikemas, perlu persetujuan seller.
    | Maksimal tiga pengajuan dengan persetujuan seller.
    |
    */

    public function requestCancel(Request $request, Order $order)
    {
        $data = $request->validate([
            'reason' => ['required', 'string', 'max:255'],
        ]);

        $result = DB::transaction(function () use ($order, $data) {
            $locked = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless(
                (int) $locked->user_id === (int) auth()->id(),
                403
            );

            // Tidak bisa membatalkan pesanan yang sudah dikirim,
            // selesai, atau dibatalkan.
            if (
                $locked->shipped_at !== null ||
                in_array($locked->status, [
                    'dikirim',
                    'selesai',
                    'dibatalkan',
                    'batal',
                ], true)
            ) {
                return [
                    'error',
                    'Pesanan sudah tidak bisa dibatalkan.',
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | PEMBATALAN LANGSUNG
            |--------------------------------------------------------------------------
            |
            | Berlaku sebelum seller menekan Mulai Proses Pesanan.
            |
            */

            if (in_array($locked->status, [
                'belum_bayar',
                'pending',
                'dikemas',
            ], true)) {

                $this->restoreStockIfNeeded($locked);

                $locked->update([
                    'status' => 'dibatalkan',
                    'cancellation_reason' => $data['reason'],
                    'inventory_deducted' => false,
                    'refund_status' => $locked->paid_at
                        ? 'pending'
                        : null,
                ]);

                return [
                    'success',
                    $locked->paid_at
                        ? 'Pesanan dibatalkan. Pengembalian dana perlu diproses.'
                        : 'Pesanan berhasil dibatalkan tanpa persetujuan penjual.',
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | PENGAJUAN PEMBATALAN KEPADA SELLER
            |--------------------------------------------------------------------------
            */

            if ($locked->status !== 'diproses') {
                return [
                    'error',
                    'Status pesanan tidak mendukung pembatalan.',
                ];
            }

            $approvals = $locked->cancellationApprovals()->get();

            $isRejected = $approvals->contains(
                'status',
                'rejected'
            );

            $isPending = $approvals->contains(
                'status',
                'pending'
            );

            // Jangan membuat pengajuan ganda.
            if ($isPending && !$isRejected) {
                return [
                    'error',
                    'Permintaan sebelumnya masih menunggu keputusan penjual.',
                ];
            }

            // Hitung jumlah pengajuan.
            $attempts = (int) $locked->cancellation_attempts;

            if ($attempts >= self::MAX_ATTEMPTS) {
                return [
                    'error',
                    'Batas maksimal 3 kali pengajuan pembatalan telah tercapai.',
                ];
            }

            // Temukan seluruh penjual dalam pesanan.
            $sellerIds = $locked->items()
                ->pluck('seller_id');

            if (
                $sellerIds->isEmpty() ||
                $sellerIds->contains(null)
            ) {
                return [
                    'error',
                    'Penjual pesanan belum teridentifikasi. Hubungi admin.',
                ];
            }

            /*
            | Pengajuan baru:
            | Hapus keputusan lama untuk pengajuan aktif.
            | Histori jumlah pengajuan tetap disimpan di orders.
            */
            $locked->cancellationApprovals()->delete();

            foreach ($sellerIds->unique() as $sellerId) {
                OrderCancellationApproval::create([
                    'order_id' => $locked->id,
                    'seller_id' => $sellerId,
                    'status' => 'pending',
                ]);
            }

            // Naikkan jumlah pengajuan secara permanen.
            DB::table('orders')
                ->where('id', $locked->id)
                ->update([
                    'cancellation_attempts' => $attempts + 1,
                ]);

            $locked->update([
                'cancellation_reason' => $data['reason'],
            ]);

            return [
                'success',
                'Pengajuan pembatalan ke-' . ($attempts + 1) .
                    ' dari 3 terkirim. Menunggu persetujuan penjual.',
            ];
        }, 3);

        return back()->with($result[0], $result[1]);
    }

    /*
    |--------------------------------------------------------------------------
    | KEPUTUSAN PENJUAL
    |--------------------------------------------------------------------------
    |
    | Approve = menyetujui pembatalan.
    | Reject  = menolak pengajuan saat ini.
    | Setelah reject, pembeli boleh mencoba lagi hingga 3 kali.
    |
    */

    public function review(Request $request, Order $order)
    {
        $data = $request->validate([
            'decision' => ['required', 'in:approve,reject'],
        ]);

        $result = DB::transaction(function () use ($order, $data) {

            $locked = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            $approval = OrderCancellationApproval::where(
                'order_id',
                $locked->id
            )
                ->where('seller_id', auth()->id())
                ->lockForUpdate()
                ->first();

            // Hanya penjual terkait yang boleh memutuskan.
            abort_unless($approval !== null, 403);

            if (
                $locked->status !== 'diproses' ||
                $locked->shipped_at !== null
            ) {
                return [
                    'error',
                    'Pesanan sudah tidak bisa dibatalkan.',
                ];
            }

            // Pengajuan dengan keputusan penolakan sudah ditutup.
            if (
                $locked->cancellationApprovals()
                    ->where('status', 'rejected')
                    ->exists()
            ) {
                return [
                    'error',
                    'Pengajuan ini sudah ditolak.',
                ];
            }

            if ($approval->status !== 'pending') {
                return [
                    'error',
                    'Keputusan sudah tercatat.',
                ];
            }

            /*
            | SELLER MENOLAK
            */
            if ($data['decision'] === 'reject') {

                $approval->update([
                    'status' => 'rejected',
                ]);

                return [
                    'success',
                    'Permintaan ditolak. Pembeli masih dapat mengajukan lagi '
                        . 'jika belum mencapai 3 kali.',
                ];
            }

            /*
            | SELLER MENYETUJUI
            */
            $approval->update([
                'status' => 'approved',
            ]);

            // Jika ada beberapa seller, tunggu semuanya setuju.
            $waiting = $locked->cancellationApprovals()
                ->where('status', '!=', 'approved')
                ->exists();

            if ($waiting) {
                return [
                    'success',
                    'Persetujuan tercatat. Menunggu penjual lain.',
                ];
            }

            // Seluruh seller sudah setuju.
            $this->restoreStockIfNeeded($locked);

            $locked->update([
                'status' => 'dibatalkan',
                'inventory_deducted' => false,
                'refund_status' => $locked->paid_at
                    ? 'pending'
                    : null,
            ]);

            return [
                'success',
                $locked->paid_at
                    ? 'Pembatalan disetujui. Refund harus diproses terpisah.'
                    : 'Pembatalan disetujui dan stok telah dikembalikan.',
            ];

        }, 3);

        return back()->with($result[0], $result[1]);
    }

    /*
    |--------------------------------------------------------------------------
    | PENGEMBALIAN STOK
    |--------------------------------------------------------------------------
    |
    | Stok hanya dipulihkan bila memang telah dikurangi.
    | Perubahan stok berjalan dalam transaksi database.
    |
    */

    private function restoreStockIfNeeded(Order $order): void
    {
        if (!$order->inventory_deducted) {
            return;
        }

        $items = $order->items()
            ->orderBy('product_id')
            ->get();

        foreach ($items as $item) {

            if (!$item->product_id) {
                throw ValidationException::withMessages([
                    'pesanan' =>
                        'Produk pesanan tidak memiliki ID. Hubungi admin.',
                ]);
            }

            $product = Product::whereKey($item->product_id)
                ->lockForUpdate()
                ->first();

            if (!$product) {
                throw ValidationException::withMessages([
                    'pesanan' =>
                        'Produk pesanan tidak ditemukan. Hubungi admin.',
                ]);
            }

            $product->increment(
                'stock',
                (int) $item->quantity
            );
        }
    }
}
