<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Menampilkan produk penjual yang belum diarsipkan.
     */
    public function myProducts()
    {
        $products = auth()->user()->products()
            ->notArchived()
            ->withCount(['orderItems', 'cartItems'])
            ->latest()
            ->get();

        return view('products.my-products', compact('products'));
    }

    /**
     * Form untuk menambahkan produk baru.
     */
    public function create()
    {
        $categories = [
            'Bibit Tanaman',
            'Media Tanam',
            'Pupuk & Nutrisi',
            'Pot & Perlengkapan',
            'Hasil Panen & Sayuran',
            'Alat Pertanian',
        ];

        $suggestedIcons = [
            '🌱', '🌶️', '🍅', '🪴', '🌿', '🌽',
            '🥕', '🥦', '🥬', '🌾', '🍓', '🍎',
        ];

        return view('products.create', compact('categories', 'suggestedIcons'));
    }

    /**
     * Simpan produk baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'required|string|max:50',
            'price' => 'required|numeric|min:500',
            'stock' => 'required|integer|min:1',
            'unit' => 'required|string|max:20',
            'location' => 'required|string|max:100',
            'description' => 'nullable|string|max:2000',
            'icon' => 'nullable|string|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'category.required' => 'Kategori produk wajib dipilih.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.min' => 'Harga minimal adalah Rp500.',
            'stock.required' => 'Stok produk wajib diisi.',
            'stock.min' => 'Stok minimal adalah 1.',
            'unit.required' => 'Satuan produk wajib diisi (contoh: kg, ikat, pack).',
            'location.required' => 'Kota / Lokasi Anda wajib diisi.',
            'image.image' => 'Berkas harus berupa gambar (jpg, png, webp).',
            'image.max' => 'Ukuran gambar maksimal adalah 3MB.',
        ]);

        $imagePath = $request->hasFile('image')
            ? $this->saveProductImage($request)
            : null;

        $slugBase = Str::slug($validated['name']) ?: 'produk';
        $slug = $slugBase;
        $number = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $number;
            $number++;
        }

        $product = Product::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'slug' => $slug,
            'category' => $validated['category'],
            'price' => (int) $validated['price'],
            'stock' => (int) $validated['stock'],
            'unit' => $validated['unit'],
            'location' => $validated['location'],
            'description' => $validated['description'] ?? null,
            'icon' => $validated['icon'] ?? '🌱',
            'image' => $imagePath,
            'status' => 'tersedia',
        ]);

        return redirect()->route('products.my')
            ->with('success', "Produk '{$product->name}' berhasil dipasang untuk dijual!");
    }

    /**
     * Form edit produk.
     */
    public function edit(Product $product)
    {
        $this->ensureCanManage($product);

        $categories = [
            'Bibit Tanaman',
            'Media Tanam',
            'Pupuk & Nutrisi',
            'Pot & Perlengkapan',
            'Hasil Panen & Sayuran',
            'Alat Pertanian',
        ];

        $suggestedIcons = [
            '🌱', '🌶️', '🍅', '🪴', '🌿', '🌽',
            '🥕', '🥦', '🥬', '🌾', '🍓', '🍎',
        ];

        return view('products.edit', compact('product', 'categories', 'suggestedIcons'));
    }

    /**
     * Perbarui informasi produk dan stok.
     *
     * stock_mode:
     * keep = stok tidak berubah
     * add  = tambah stok terbaru dari database
     * set  = tetapkan jumlah stok akhir
     */
    public function update(Request $request, Product $product)
    {
        $this->ensureCanManage($product);

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'required|string|max:50',
            'price' => 'required|numeric|min:500',
            'unit' => 'required|string|max:20',
            'location' => 'required|string|max:100',
            'description' => 'nullable|string|max:2000',
            'icon' => 'nullable|string|max:10',
            'status' => 'required|in:tersedia,habis',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',

            // Pengaturan stok baru.
            'stock_mode' => 'nullable|in:keep,add,set',
            'stock_add' => 'required_if:stock_mode,add|nullable|integer|min:1|max:1000000',
            'stock' => 'required_if:stock_mode,set|nullable|integer|min:0|max:2147483647',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'category.required' => 'Kategori produk wajib dipilih.',
            'price.required' => 'Harga wajib diisi.',
            'price.min' => 'Harga minimal Rp500.',
            'unit.required' => 'Satuan produk wajib dipilih.',
            'location.required' => 'Lokasi produk wajib diisi.',
            'status.required' => 'Status produk wajib dipilih.',

            'stock_mode.in' => 'Pilihan pengaturan stok tidak valid.',
            'stock_add.required_if' => 'Isi jumlah stok yang ingin ditambahkan.',
            'stock_add.min' => 'Restock minimal 1 unit.',
            'stock_add.max' => 'Maksimal restock 1.000.000 unit sekaligus.',
            'stock.required_if' => 'Isi jumlah stok akhir untuk koreksi stok.',
            'stock.min' => 'Stok akhir tidak boleh negatif.',

            'image.image' => 'File foto harus berupa gambar.',
            'image.max' => 'Ukuran foto maksimal 3MB.',
        ]);

        $mode = $validated['stock_mode'] ?? 'keep';
        $quantityToAdd = (int) ($validated['stock_add'] ?? 0);
        $targetStock = (int) ($validated['stock'] ?? 0);

        // Foto lama tetap dipakai jika tidak ada upload baru.
        if ($request->hasFile('image')) {
            $validated['image'] = $this->saveProductImage($request);
        } else {
            unset($validated['image']);
        }

        // Parameter stok tidak langsung di-fill ke model.
        unset(
            $validated['stock_mode'],
            $validated['stock_add'],
            $validated['stock']
        );

        $validated['price'] = (int) $validated['price'];

        [$name, $stockAfter] = DB::transaction(function () use (
            $product,
            $validated,
            $mode,
            $quantityToAdd,
            $targetStock
        ) {
            /*
             * Ambil stok TERBARU dari database.
             *
             * Lock ini penting supaya operasi restock
             * tidak menimpa pengurangan stok checkout.
             */
            $locked = Product::whereKey($product->id)
                ->lockForUpdate()
                ->firstOrFail();

            $this->ensureCanManage($locked);

            $locked->fill($validated);

            if ($mode === 'add') {
                /*
                 * Contoh:
                 * Stok database sekarang = 5
                 * Seller menambah          = 20
                 * Stok akhir              = 25
                 */
                $newStock = (int) $locked->stock + $quantityToAdd;

                if ($newStock > 2147483647) {
                    abort(
                        422,
                        'Jumlah stok melebihi batas penyimpanan database.'
                    );
                }

                $locked->stock = $newStock;

            } elseif ($mode === 'set') {
                /*
                 * Untuk koreksi stok opname.
                 * Nilai ini menjadi jumlah stok akhir,
                 * bukan ditambahkan ke stok sebelumnya.
                 */
                $locked->stock = $targetStock;
            }

            /*
             * mode = keep:
             * $locked->stock tidak diubah.
             */

            $locked->save();

            return [
                $locked->name,
                (int) $locked->stock
            ];

        }, 3);

        return redirect()->route('products.my')
            ->with(
                'success',
                "Produk '{$name}' berhasil diperbarui. Stok sekarang: {$stockAfter}."
            );
    }

    /**
     * Hapus produk dari kios dan keranjang pembeli.
     * Produk tetap diarsipkan untuk menjaga
     * riwayat transaksi dan pesanan lama.
     */
    public function destroy(Product $product)
    {
        $this->ensureCanManage($product);

        $removedFromCart = DB::transaction(function () use ($product) {

            $locked = Product::whereKey($product->id)
                ->lockForUpdate()
                ->firstOrFail();

            $this->ensureCanManage($locked);

            $deletedCartRows = $locked->cartItems()->delete();

            $locked->forceFill([
                'is_archived' => true,
                'status' => 'habis',
            ])->save();

            return $deletedCartRows;

        }, 3);

        return redirect()->route('products.my')
            ->with(
                'success',
                "Produk '{$product->name}' dihapus dari kios. "
                . "{$removedFromCart} baris keranjang dibersihkan; "
                . "riwayat pesanan tetap tersimpan."
            );
    }

    /**
     * Aktif / Nonaktifkan produk.
     *
     * Status tersedia = tampil di marketplace.
     * Status habis = disembunyikan dari marketplace.
     *
     * Stok 0 bukan alasan otomatis untuk menonaktifkan.
     */
    public function toggleStatus(Product $product)
    {
        $this->ensureCanManage($product);

        [$name, $status] = DB::transaction(function () use ($product) {

            $locked = Product::whereKey($product->id)
                ->lockForUpdate()
                ->firstOrFail();

            $this->ensureCanManage($locked);

            $locked->status = $locked->status === 'tersedia'
                ? 'habis'
                : 'tersedia';

            $locked->save();

            return [
                $locked->name,
                $locked->status
            ];

        }, 3);

        $label = $status === 'tersedia'
            ? 'diaktifkan dan ditampilkan di Pasar'
            : 'dinonaktifkan dan disembunyikan dari Pasar';

        return back()->with(
            'success',
            "Produk '{$name}' berhasil {$label}."
        );
    }

    /**
     * Hanya pemilik produk atau admin
     * yang boleh mengelola produk.
     */
    private function ensureCanManage(Product $product): void
    {
        if ($product->is_archived) {
            abort(404, 'Produk ini sudah dihapus dari kios.');
        }

        if (
            (int) $product->user_id !== (int) auth()->id() &&
            !auth()->user()->isAdmin()
        ) {
            abort(
                403,
                'Anda tidak memiliki hak untuk mengelola produk ini.'
            );
        }
    }

    /**
     * Simpan foto produk dengan nama unik.
     */
    private function saveProductImage(Request $request): string
    {
        $file = $request->file('image');

        $filename = now()->format('YmdHis')
            . '_' . Str::random(8)
            . '_' . (Str::slug($request->input('name')) ?: 'produk')
            . '.' . $file->extension();

        $file->move(
            public_path('uploads/products'),
            $filename
        );

        return 'uploads/products/' . $filename;
    }
}
