<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    // Format tetap kompatibel dengan checkout.blade.php milik tim.
    private function formatItem(Product $product, int $quantity): array
    {
        return [
            'id' => $product->id,
            'nama' => $product->name,
            'harga' => (int) $product->price,
            'jumlah' => $quantity,
            'icon' => $product->icon ?? '🌱',
            'satuan' => $product->unit ?? 'pcs',
            'penjual' => $product->user?->name ?? 'TaniMart',
        ];
    }

    // Identitas checkout mengikuti akun, bukan hanya browser/session.
    private function selectionKey(int $userId): string
    {
        return 'checkout_selected_product_ids_' . $userId;
    }

    private function signatureKey(int $userId): string
    {
        return 'checkout_cart_signature_' . $userId;
    }

    // Deteksi jika isi, jumlah, atau harga produk terpilih berubah.
    private function cartSignature(array $keranjang): string
    {
        $lines = [];

        foreach ($keranjang as $id => $item) {
            $lines[] = implode(':', [
                $id,
                $item['jumlah'],
                $item['harga'],
            ]);
        }

        sort($lines, SORT_STRING);

        return hash('sha256', implode('|', $lines));
    }

    // 1. Halaman checkout hanya memuat produk yang dicentang.
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userId = (int) auth()->id();
        $selectionKey = $this->selectionKey($userId);
        $signatureKey = $this->signatureKey($userId);

        // Form "Lanjut Checkout" di keranjang mengirim GET pilihan produk.
        if ($request->query('selection_submitted') === '1') {
            $validated = $request->validate([
                'selected_items' => ['required', 'array', 'min:1', 'max:100'],
                'selected_items.*' => ['required', 'integer', 'min:1', 'distinct'],
            ]);

            $selectedIds = array_map('intval', $validated['selected_items']);
        } else {
            // Refresh halaman checkout tetap memakai pilihan terakhir akun ini.
            $selectedIds = $request->session()->get($selectionKey, []);
        }

        if (!is_array($selectedIds) || empty($selectedIds)) {
            return redirect('/keranjang')
                ->with('error', 'Pilih minimal satu produk untuk checkout.');
        }

        $selectedIds = array_values(array_unique(array_map('intval', $selectedIds)));

        $items = CartItem::with('product.user')
            ->where('user_id', $userId)
            ->whereIn('product_id', $selectedIds)
            ->orderBy('product_id')
            ->get();

        // Tolak ID produk yang bukan milik keranjang pengguna ini.
        if ($items->count() !== count($selectedIds)) {
            $request->session()->forget([$selectionKey, $signatureKey]);

            return redirect('/keranjang')
                ->with('error', 'Pilihan produk berubah. Pilih ulang barang yang ingin dibeli.');
        }

        $keranjang = [];

        foreach ($items as $cart) {
            $product = $cart->product;
            $quantity = (int) $cart->quantity;

            if (!$product || $product->status !== 'tersedia') {
                return redirect('/keranjang')
                    ->with('error', 'Ada produk terpilih yang sudah tidak tersedia.');
            }

            if ($quantity < 1 || $quantity > (int) $product->stock) {
                return redirect('/keranjang')
                    ->with('error', "Stok {$product->name} tidak mencukupi. Periksa keranjang.");
            }

            if ($product->user_id && (int) $product->user_id === $userId) {
                return redirect('/keranjang')
                    ->with('error', 'Kamu tidak dapat membeli produk sendiri.');
            }

            if ((int) $product->price < 0) {
                return redirect('/keranjang')
                    ->with('error', "Harga produk {$product->name} tidak valid.");
            }

            $keranjang[$product->id] = $this->formatItem($product, $quantity);
        }

        if (empty($keranjang)) {
            return redirect('/keranjang')
                ->with('error', 'Tidak ada produk yang bisa di-checkout.');
        }

        $request->session()->put($selectionKey, $selectedIds);
        $request->session()->put($signatureKey, $this->cartSignature($keranjang));

        return view('checkout', compact('keranjang'));
    }

    // 2. Buat pesanan hanya dari pilihan yang sudah diperiksa.
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string', 'max:500'],
            'metode_bayar' => [
                'required',
                Rule::in([
                    'Transfer Bank',
                    'COD (Bayar di Tempat)',
                    'QRIS / E-Wallet',
                ]),
            ],
        ]);

        $userId = (int) auth()->id();
        $selectionKey = $this->selectionKey($userId);
        $signatureKey = $this->signatureKey($userId);
        $selectedIds = $request->session()->get($selectionKey, []);

        if (!is_array($selectedIds) || empty($selectedIds)) {
            return redirect('/keranjang')
                ->with('error', 'Pilih produk yang ingin di-checkout terlebih dahulu.');
        }

        $selectedIds = array_values(array_unique(array_map('intval', $selectedIds)));

        $pesanan = DB::transaction(function () use (
            $userId,
            $data,
            $request,
            $selectedIds,
            $signatureKey
        ) {
            // Kunci hanya baris keranjang yang dipilih.
            $items = CartItem::where('user_id', $userId)
                ->whereIn('product_id', $selectedIds)
                ->orderBy('product_id')
                ->lockForUpdate()
                ->get();

            if ($items->isEmpty() || $items->count() !== count($selectedIds)) {
                throw ValidationException::withMessages([
                    'keranjang' => 'Produk checkout berubah. Kembali ke keranjang dan pilih ulang.',
                ]);
            }

            $keranjang = [];
            $products = [];
            $total = 0;

            foreach ($items as $cart) {
                $product = Product::with('user')
                    ->whereKey($cart->product_id)
                    ->lockForUpdate()
                    ->first();

                if (!$product) {
                    throw ValidationException::withMessages([
                        'produk' => 'Ada produk terpilih yang sudah dihapus.',
                    ]);
                }

                if ($product->status !== 'tersedia') {
                    throw ValidationException::withMessages([
                        'produk' => "Produk {$product->name} tidak tersedia.",
                    ]);
                }

                if ($product->user_id && (int) $product->user_id === $userId) {
                    throw ValidationException::withMessages([
                        'produk' => 'Kamu tidak dapat membeli produk sendiri.',
                    ]);
                }

                $quantity = (int) $cart->quantity;

                if ($quantity < 1 || $quantity > (int) $product->stock) {
                    throw ValidationException::withMessages([
                        'stok' => "Stok {$product->name} tidak mencukupi.",
                    ]);
                }

                if ((int) $product->price < 0) {
                    throw ValidationException::withMessages([
                        'harga' => "Harga {$product->name} tidak valid.",
                    ]);
                }

                $keranjang[$product->id] = $this->formatItem($product, $quantity);
                $products[$product->id] = $product;
                $total += (int) $product->price * $quantity;
            }

            // Validasi ulang terhadap keranjang yang ditampilkan di halaman checkout.
            $expected = $request->session()->get($signatureKey, '');

            if (!$expected || !hash_equals($expected, $this->cartSignature($keranjang))) {
                throw ValidationException::withMessages([
                    'keranjang' => 'Keranjang atau harga berubah. Muat ulang checkout dan periksa total terbaru.',
                ]);
            }

            $orderNumber = 'TM-' . strtoupper(Str::random(12));
            $isCod = $data['metode_bayar'] === 'COD (Bayar di Tempat)';

            // COD dikemas, Transfer/QRIS menunggu pembayaran.
            $order = Order::create([
                'user_id' => $userId,
                'order_number' => $orderNumber,
                'customer_name' => $data['nama'],
                'customer_phone' => $data['telepon'],
                'customer_address' => $data['alamat'],
                'total' => $total,
                'payment_method' => $data['metode_bayar'],
                'shipping_courier' => 'Kurir TaniExpress',
                'status' => $isCod ? 'dikemas' : 'belum_bayar',
                'paid_at' => null,
                'inventory_deducted' => true,
            ]);

            foreach ($items as $cart) {
                $product = $products[$cart->product_id];
                $quantity = (int) $cart->quantity;
                $price = (int) $product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'seller_id' => $product->user_id,
                    'product_name' => $product->name,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $price * $quantity,
                ]);

                $product->decrement('stock', $quantity);
            }

            // PENTING: jangan hapus item lain yang tidak dicentang.
            CartItem::where('user_id', $userId)
                ->whereIn('product_id', $selectedIds)
                ->delete();

            return [
                'nomor' => $orderNumber,
                'penerima' => $data,
                'produk' => $keranjang,
                'total' => $total,
                'metode' => $data['metode_bayar'],
                'tanggal' => now()->format('d-m-Y H:i'),
            ];
        }, 3);

        $request->session()->put('pesanan_terakhir', $pesanan);
        $request->session()->forget([$selectionKey, $signatureKey]);

        return redirect('/pesanan-berhasil')
            ->with('success', 'Pesanan berhasil dibuat!');
    }
}
