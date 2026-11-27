<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // 1. Tampilkan keranjang pengguna
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $items = CartItem::with('product.user')
            ->where('user_id', auth()->id())
            ->get();

        $keranjang = [];

        foreach ($items as $item) {
            $product = $item->product;

            if (!$product) {
                continue;
            }

            $keranjang[$product->id] = [
                'id' => $product->id,
                'nama' => $product->name,
                'harga' => $product->price,
                'icon' => $product->icon ?? '🌱',
                'satuan' => $product->unit ?? 'pcs',
                'penjual' => $product->user->name ?? 'TaniMart',
                'jumlah' => $item->quantity,
                'stok' => (int) $product->stock,
                'bisa_dibeli' => (
                    $product->status === 'tersedia'
                    && (int) $product->stock > 0
                ),
            ];
        }

        return view('keranjang', compact('keranjang'));
    }

    // 2. Tambahkan produk ke keranjang
    public function add(string $produk)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $error = DB::transaction(function () use ($produk) {
            $product = ctype_digit($produk)
                ? Product::whereKey($produk)
                    ->lockForUpdate()
                    ->firstOrFail()
                : Product::where('slug', $produk)
                    ->lockForUpdate()
                    ->firstOrFail();

            if ($product->status !== 'tersedia') {
                return 'Produk sedang tidak tersedia.';
            }

            if ((int) $product->stock <= 0) {
                return 'Stok produk habis. Silakan pilih produk lain.';
            }

            if (
                $product->user_id &&
                (int) $product->user_id === (int) auth()->id()
            ) {
                return 'Kamu tidak dapat membeli produk sendiri.';
            }

            $cart = CartItem::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->lockForUpdate()
                ->first();

            $jumlahBaru = ($cart ? (int) $cart->quantity : 0) + 1;

            if ($jumlahBaru > (int) $product->stock) {
                return 'Jumlah produk melebihi stok tersedia.';
            }

            if ($cart) {
                $cart->update([
                    'quantity' => $jumlahBaru,
                ]);
            } else {
                CartItem::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                    'quantity' => 1,
                ]);
            }

            return null;
        }, 3);

        if ($error) {
            return back()->with('error', $error);
        }

        return redirect('/keranjang')
            ->with('success', 'Produk berhasil masuk keranjang!');
    }

    // 3. Tambah atau kurangi jumlah produk di keranjang
    public function update(Request $request, int $produk)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $data = $request->validate([
            'aksi' => 'required|in:tambah,kurang',
        ]);

        $error = DB::transaction(function () use ($produk, $data) {
            $cart = CartItem::where('user_id', auth()->id())
                ->where('product_id', $produk)
                ->lockForUpdate()
                ->firstOrFail();

            // Kurangi jumlah; jika tinggal satu, hapus item
            if ($data['aksi'] === 'kurang') {
                if ((int) $cart->quantity <= 1) {
                    $cart->delete();
                } else {
                    $cart->decrement('quantity');
                }

                return null;
            }

            // Tambah jumlah: periksa stok terbaru dari database
            $product = Product::whereKey($cart->product_id)
                ->lockForUpdate()
                ->first();

            if (!$product || $product->status !== 'tersedia') {
                return 'Produk sudah tidak tersedia.';
            }

            if ((int) $product->stock <= 0) {
                return 'Stok produk habis.';
            }

            if ((int) $cart->quantity >= (int) $product->stock) {
                return 'Jumlah produk melebihi stok tersedia.';
            }

            $cart->increment('quantity');

            return null;
        }, 3);

        if ($error) {
            return back()->with('error', $error);
        }

        return redirect('/keranjang');
    }

    // 4. Hapus produk dari keranjang
    public function remove(int $produk)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        CartItem::where('user_id', auth()->id())
            ->where('product_id', $produk)
            ->delete();

        return redirect('/keranjang')
            ->with('success', 'Produk dihapus dari keranjang.');
    }
}
