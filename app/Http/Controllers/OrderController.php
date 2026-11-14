<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Halaman "Pesanan Saya" (Sisi Pembeli ala Shopee)
     * TERISOLASI 100% PER AKUN: Hanya pesanan dengan user_id milik akun yang sedang login.
     */
    public function myOrders(Request $request)
    {
        $userId = auth()->id();
        $statusTab = $request->query('tab', 'semua');

        // STRICT ISOLASI AKUN: Hanya ambil pesanan yang dibuat oleh akun saat ini
        $query = Order::with(['items.product', 'items.seller'])
            ->where('user_id', $userId);

        // Filter tab Shopee
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

        // Hitung badge counter per tab HANYA untuk akun ini
        $counts = [
            'semua' => Order::where('user_id', $userId)->count(),
            'belum_bayar' => Order::where('user_id', $userId)->whereIn('status', ['belum_bayar', 'pending'])->count(),
            'dikemas' => Order::where('user_id', $userId)->whereIn('status', ['dikemas', 'diproses'])->count(),
            'dikirim' => Order::where('user_id', $userId)->where('status', 'dikirim')->count(),
            'selesai' => Order::where('user_id', $userId)->where('status', 'selesai')->count(),
            'dibatalkan' => Order::where('user_id', $userId)->whereIn('status', ['dibatalkan', 'batal'])->count(),
        ];

        return view('pesanan.saya', compact('orders', 'statusTab', 'counts'));
    }

    /**
     * Simulasi Bayar Sekarang (Pembeli bayar pesanan)
     */
    public function pay(Order $order)
    {
        // Keamanan: Pastikan hanya pemilik pesanan yang bisa bayar
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki hak untuk mengakses pesanan ini.');
        }

        $order->update([
            'status' => 'dikemas',
            'paid_at' => now(),
        ]);

        return back()->with('success', "Pembayaran untuk pesanan {$order->order_number} berhasil dikonfirmasi! Pesanan sekarang sedang dikemas oleh penjual.");
    }

    /**
     * Batalkan Pesanan (Pembeli)
     */
    public function cancel(Order $order)
    {
        // Keamanan: Pastikan hanya pemilik pesanan yang bisa membatalkan
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki hak untuk membatalkan pesanan ini.');
        }

        if (in_array($order->shopee_status, ['dikirim', 'selesai'])) {
            return back()->with('error', 'Pesanan yang sudah dikirim atau selesai tidak dapat dibatalkan.');
        }

        $order->update([
            'status' => 'dibatalkan',
        ]);

        return back()->with('success', "Pesanan {$order->order_number} berhasil dibatalkan.");
    }

    /**
     * Konfirmasi Pesanan Diterima (Pembeli)
     */
    public function confirmReceived(Order $order)
    {
        // Keamanan: Pastikan hanya pemilik pesanan yang bisa konfirmasi penerimaan
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki hak untuk mengubah status pesanan ini.');
        }

        $order->update([
            'status' => 'selesai',
            'completed_at' => now(),
        ]);

        return back()->with('success', "Terima kasih! Pesanan {$order->order_number} telah selesai. Silakan berikan penilaian untuk toko ini.");
    }

    /**
     * Beri Penilaian / Rating & Review (Pembeli)
     */
    public function submitReview(Request $request, OrderItem $item)
    {
        // Pastikan hanya pembeli pesanan ini yang bisa menilai
        $order = $item->order;
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
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

        return back()->with('success', "Ulasan dan bintang untuk {$item->product_name} berhasil dikirim! Terima kasih atas penilaian Anda.");
    }

    /**
     * Halaman "Pesanan Masuk" Toko (Sisi Penjual)
     * TERISOLASI 100% PER TOKO: Penjual hanya melihat pesanan produk miliknya sendiri.
     */
    public function sellerOrders(Request $request)
    {
        $sellerId = auth()->id();
        $statusTab = $request->query('tab', 'semua');

        // Ambil ID pesanan yang memuat produk milik penjual ini
        $orderIds = OrderItem::where('seller_id', $sellerId)->pluck('order_id')->unique();

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
            'perlu_dikemas' => Order::whereIn('id', $orderIds)->whereIn('status', ['dikemas', 'diproses', 'belum_bayar', 'pending'])->count(),
            'dikirim' => Order::whereIn('id', $orderIds)->where('status', 'dikirim')->count(),
            'selesai' => Order::whereIn('id', $orderIds)->where('status', 'selesai')->count(),
        ];

        return view('pesanan.penjual', compact('orders', 'statusTab', 'counts'));
    }

    /**
     * Penjual Kirim Pesanan (Input Kurir & Resi)
     */
    public function shipOrder(Request $request, Order $order)
    {
        // Pastikan penjual memiliki setidaknya 1 item di pesanan ini
        $hasItem = $order->items()->where('seller_id', auth()->id())->exists();
        if (!$hasItem && !auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'shipping_courier' => 'required|string|max:50',
            'tracking_number' => 'nullable|string|max:50',
        ]);

        $trackingNumber = $validated['tracking_number'] ?? ('TMX-' . strtoupper(Str::random(10)));

        $order->update([
            'status' => 'dikirim',
            'shipping_courier' => $validated['shipping_courier'],
            'tracking_number' => $trackingNumber,
            'shipped_at' => now(),
        ]);

        return back()->with('success', "Pesanan {$order->order_number} berhasil diproses dan dikirim dengan nomor resi {$trackingNumber}!");
    }
}
