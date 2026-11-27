<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // Daftar pesanan pembeli; tetap terisolasi per akun.
    public function myOrders(Request $request)
    {
        $userId = auth()->id();
        $statusTab = $request->query('tab', 'semua');

        $query = Order::with(['items.product', 'items.seller'])
            ->where('user_id', $userId);

        if ($statusTab === 'belum_bayar') {
            $query->whereIn('status', ['belum_bayar', 'pending']);
        } elseif ($statusTab === 'dikemas') {
            $query->whereIn('status', ['dikemas', 'diproses']);
        } elseif ($statusTab === 'dikirim') {
            $query->where('status', 'dikirim');
        } elseif ($statusTab === 'selesai') {
            $query->where('status', 'selesai');
        } elseif ($statusTab === 'dibatalkan') {
            $query->whereIn('status', ['dibatalkan', 'batal']);
        }

        $orders = $query->latest()->get();

        $counts = [
            'semua' => Order::where('user_id', $userId)->count(),
            'belum_bayar' => Order::where('user_id', $userId)
                ->whereIn('status', ['belum_bayar', 'pending'])->count(),
            'dikemas' => Order::where('user_id', $userId)
                ->whereIn('status', ['dikemas', 'diproses'])->count(),
            'dikirim' => Order::where('user_id', $userId)
                ->where('status', 'dikirim')->count(),
            'selesai' => Order::where('user_id', $userId)
                ->where('status', 'selesai')->count(),
            'dibatalkan' => Order::where('user_id', $userId)
                ->whereIn('status', ['dibatalkan', 'batal'])->count(),
        ];

        return view('pesanan.saya', compact('orders', 'statusTab', 'counts'));
    }

    // Simulasi pembayaran (tidak terhubung payment gateway).
    public function pay(Order $order)
    {
        $result = DB::transaction(function () use ($order) {
            $locked = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();

            abort_unless((int) $locked->user_id === (int) auth()->id()
                || auth()->user()->isAdmin(), 403);

            if (!in_array($locked->status, ['belum_bayar', 'pending'], true)) {
                return ['error', 'Pesanan ini tidak berada pada tahap menunggu pembayaran.'];
            }

            $locked->update([
                'status' => 'dikemas',
                'paid_at' => now(),
            ]);

            return ['success', "Pembayaran simulasi {$locked->order_number} tercatat. Menunggu penjual memproses."];
        }, 3);

        return back()->with($result[0], $result[1]);
    }

    // Kompatibilitas dengan route batal lama: satu alur pembatalan saja.
    public function cancel(Request $request, Order $order)
    {
        return app(CancellationController::class)->requestCancel($request, $order);
    }

    // Seller menandai pesanan mulai dikerjakan.
    public function startProcessing(Order $order)
    {
        $result = DB::transaction(function () use ($order) {
            $locked = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();

            $isSeller = $locked->items()
                ->where('seller_id', auth()->id())
                ->exists();

            abort_unless($isSeller, 403);

            if ($locked->status !== 'dikemas' || $locked->shipped_at !== null) {
                return ['error', 'Pesanan tidak dapat mulai diproses pada tahap ini.'];
            }

            $locked->update(['status' => 'diproses']);

            return ['success', 'Pesanan mulai diproses. Pembatalan selanjutnya memerlukan persetujuan penjual.'];
        }, 3);

        return back()->with($result[0], $result[1]);
    }

    public function confirmReceived(Order $order)
    {
        $result = DB::transaction(function () use ($order) {
            $locked = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();

            abort_unless((int) $locked->user_id === (int) auth()->id()
                || auth()->user()->isAdmin(), 403);

            if ($locked->status !== 'dikirim') {
                return ['error', 'Pesanan hanya dapat dikonfirmasi setelah dikirim.'];
            }

            $locked->update([
                'status' => 'selesai',
                'completed_at' => now(),
            ]);

            return ['success', "Pesanan {$locked->order_number} selesai. Terima kasih!"];
        }, 3);

        return back()->with($result[0], $result[1]);
    }

    public function submitReview(Request $request, OrderItem $item)
    {
        $order = $item->order;

        abort_unless((int) $order->user_id === (int) auth()->id()
            || auth()->user()->isAdmin(), 403);

        if ($order->status !== 'selesai') {
            return back()->with('error', 'Penilaian hanya bisa diberikan setelah pesanan selesai.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $item->update([
            'rating' => $validated['rating'],
            'review' => $validated['review'] ?? null,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', "Ulasan untuk {$item->product_name} berhasil dikirim!");
    }

    // Daftar pesanan penjual, hanya item miliknya yang ditampilkan.
    public function sellerOrders(Request $request)
    {
        $sellerId = auth()->id();
        $statusTab = $request->query('tab', 'semua');

        $orderIds = OrderItem::where('seller_id', $sellerId)
            ->pluck('order_id')->unique();

        $query = Order::with(['user', 'items' => function ($q) use ($sellerId) {
            $q->where('seller_id', $sellerId)->with('product');
        }])->whereIn('id', $orderIds);

        if ($statusTab === 'perlu_dikemas') {
            $query->whereIn('status', ['dikemas', 'diproses', 'belum_bayar', 'pending']);
        } elseif ($statusTab === 'dikirim') {
            $query->where('status', 'dikirim');
        } elseif ($statusTab === 'selesai') {
            $query->where('status', 'selesai');
        } elseif ($statusTab === 'dibatalkan') {
            $query->whereIn('status', ['dibatalkan', 'batal']);
        }

        $orders = $query->latest()->get();

        $counts = [
            'semua' => Order::whereIn('id', $orderIds)->count(),
            'perlu_dikemas' => Order::whereIn('id', $orderIds)
                ->whereIn('status', ['dikemas', 'diproses', 'belum_bayar', 'pending'])->count(),
            'dikirim' => Order::whereIn('id', $orderIds)
                ->where('status', 'dikirim')->count(),
            'selesai' => Order::whereIn('id', $orderIds)
                ->where('status', 'selesai')->count(),
        ];

        return view('pesanan.penjual', compact('orders', 'statusTab', 'counts'));
    }

    // Pengiriman hanya setelah seller mulai memproses dan tak ada
    // pengajuan pembatalan yang masih menunggu keputusan.
    public function shipOrder(Request $request, Order $order)
    {
        $validated = $request->validate([
            'shipping_courier' => 'required|string|max:50',
            'tracking_number' => 'nullable|string|max:50',
        ]);

        $result = DB::transaction(function () use ($order, $validated) {
            $locked = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();

            $isSeller = $locked->items()
                ->where('seller_id', auth()->id())
                ->exists();

            abort_unless($isSeller, 403);

            if ($locked->status !== 'diproses' || $locked->shipped_at !== null) {
                return ['error', 'Klik Mulai Proses Pesanan terlebih dahulu.'];
            }

            if ($locked->cancellationApprovals()->where('status', 'pending')->exists()) {
                return ['error', 'Pengiriman ditahan karena ada permintaan pembatalan.'];
            }

            $trackingNumber = $validated['tracking_number']
                ?? ('TMX-' . strtoupper(Str::random(10)));

            $locked->update([
                'status' => 'dikirim',
                'shipping_courier' => $validated['shipping_courier'],
                'tracking_number' => $trackingNumber,
                'shipped_at' => now(),
            ]);

            return ['success', "Pesanan {$locked->order_number} dikirim dengan resi {$trackingNumber}."];
        }, 3);

        return back()->with($result[0], $result[1]);
    }
}
