<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Tampilkan produk yang dijual oleh user saat ini
     */
    public function myProducts()
    {
        $products = auth()->user()->products()->latest()->get();
        return view('products.my-products', compact('products'));
    }

    /**
     * Formulir pasang produk untuk dijual
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
            '🌱', '🌶️', '🍅', '🪴', '🌿', '🌽', '🥕', '🥦', '🥬', '🌾', '🍓', '🍎'
        ];

        return view('products.create', compact('categories', 'suggestedIcons'));
    }

    /**
     * Simpan produk jualan baru ke database
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

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $fileName);
            $imagePath = 'uploads/products/' . $fileName;
        }

        $slugBase = Str::slug($validated['name']);
        $slug = $slugBase;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$slugBase}-{$count}";
            $count++;
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
     * Formulir edit produk
     */
    public function edit(Product $product)
    {
        // Pastikan hanya pemilik produk atau admin yang bisa edit
        if ($product->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki hak untuk mengubah produk ini.');
        }

        $categories = [
            'Bibit Tanaman',
            'Media Tanam',
            'Pupuk & Nutrisi',
            'Pot & Perlengkapan',
            'Hasil Panen & Sayuran',
            'Alat Pertanian',
        ];

        $suggestedIcons = [
            '🌱', '🌶️', '🍅', '🪴', '🌿', '🌽', '🥕', '🥦', '🥬', '🌾', '🍓', '🍎'
        ];

        return view('products.edit', compact('product', 'categories', 'suggestedIcons'));
    }

    /**
     * Simpan perubahan produk
     */
    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'required|string|max:50',
            'price' => 'required|numeric|min:500',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:20',
            'location' => 'required|string|max:100',
            'description' => 'nullable|string|max:2000',
            'icon' => 'nullable|string|max:10',
            'status' => 'required|in:tersedia,habis',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $fileName);
            $validated['image'] = 'uploads/products/' . $fileName;
        }

        $product->update($validated);

        return redirect()->route('products.my')
            ->with('success', "Informasi produk '{$product->name}' berhasil diperbarui.");
    }

    /**
     * Hapus produk jualan
     */
    public function destroy(Product $product)
    {
        if ($product->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $name = $product->name;
        $product->delete();

        return redirect()->route('products.my')
            ->with('success', "Produk '{$name}' telah dihapus dari toko Anda.");
    }

    /**
     * Ubah status produk (Tersedia / Habis)
     */
    public function toggleStatus(Product $product)
    {
        if ($product->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $product->status = $product->status === 'tersedia' ? 'habis' : 'tersedia';
        $product->save();

        return back()->with('success', "Status produk '{$product->name}' diubah menjadi {$product->status}.");
    }
}

