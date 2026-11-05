<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\KonsultasiController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {

    // Membaca kategori dari URL
    $kategori = $request->query('kategori');

    // Menyiapkan query produk beserta kategorinya
    $query = Product::with('category');

    // Jika pengguna memilih kategori
    if (is_string($kategori) && $kategori !== '') {

        $query->whereHas('category', function ($q) use ($kategori) {
            $q->where('slug', $kategori);
        });

    } else {
        $kategori = null;
    }

    // Mengambil hasil dari MySQL
    $products = $query->orderBy('id')->get();

    return view('welcome', compact('products', 'kategori'));
});
Route::get('/keranjang', function () {
    return view('keranjang');
});

Route::post('/keranjang/tambah/{produk}', function ($produk) {

    $product = Product::where('slug', $produk)
        ->firstOrFail();

    $keranjang = session()->get('keranjang', []);

    $jumlahSaatIni = $keranjang[$produk]['jumlah'] ?? 0;

    if ($jumlahSaatIni >= $product->stock) {
        return redirect('/keranjang')
            ->with('error', 'Stok tidak mencukupi.');
    }

    $keranjang[$produk] = [
        'nama' => $product->name,
        'harga' => $product->price,
        'jumlah' => $jumlahSaatIni + 1,
    ];

    session()->put('keranjang', $keranjang);

    return redirect('/keranjang');
});

Route::post('/keranjang/ubah/{produk}', function ($produk) {
    $keranjang = session()->get('keranjang', []);

    if (!isset($keranjang[$produk])) {
        return redirect('/keranjang');
    }

    $aksi = request('aksi');

if ($aksi === 'tambah') {

    $product = Product::where('slug', $produk)
        ->firstOrFail();

    if ($keranjang[$produk]['jumlah'] >= $product->stock) {
        return redirect('/keranjang')
            ->with('error', 'Stok tidak mencukupi.');
    }

    $keranjang[$produk]['jumlah']++;
}
    
    elseif ($aksi === 'kurang') {
        $keranjang[$produk]['jumlah']--;

        if ($keranjang[$produk]['jumlah'] <= 0) {
            unset($keranjang[$produk]);
        }
    }

    session()->put('keranjang', $keranjang);

    return redirect('/keranjang');
});

Route::post('/keranjang/hapus/{produk}', function ($produk) {
    $keranjang = session()->get('keranjang', []);

    if (isset($keranjang[$produk])) {
        unset($keranjang[$produk]);
        session()->put('keranjang', $keranjang);
    }

    return redirect('/keranjang');
});

Route::get('/checkout', function () {

    $keranjang = session()->get('keranjang', []);

    if (empty($keranjang)) {
        return redirect('/keranjang');
    }

    return view('checkout', compact('keranjang'));
});

Route::post('/checkout', function (Request $request) {

    $data = $request->validate([
        'nama' => 'required|string|max:100',
        'telepon' => 'required|string|max:20',
        'alamat' => 'required|string|max:500',
    ]);

    $keranjang = session()->get('keranjang', []);

    if (empty($keranjang)) {
        return redirect('/keranjang');
    }

    $order = DB::transaction(function () use ($data, $keranjang) {

        $order = Order::create([
            'order_number' => 'TM-' . Str::ulid(),
            'customer_name' => $data['nama'],
            'customer_phone' => $data['telepon'],
            'customer_address' => $data['alamat'],
            'total' => 0,
            'status' => 'pending',
        ]);

        $total = 0;

        foreach ($keranjang as $slug => $item) {

            $product = Product::where('slug', $slug)
                ->lockForUpdate()
                ->first();

            if (!$product) {
                throw ValidationException::withMessages([
                    'keranjang' => 'Ada produk yang sudah tidak tersedia.',
                ]);
            }

            $jumlah = (int) ($item['jumlah'] ?? 0);

            if ($jumlah < 1 || $jumlah > $product->stock) {
                throw ValidationException::withMessages([
                    'keranjang' => "Stok {$product->name} tidak mencukupi.",
                ]);
            }

            $harga = (int) $product->price;
            $subtotal = $harga * $jumlah;

            $order->items()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $jumlah,
                'price' => $harga,
                'subtotal' => $subtotal,
            ]);

            $product->decrement('stock', $jumlah);

            $total += $subtotal;
        }

        $order->update(['total' => $total]);

        return $order;
    });

    session()->forget('keranjang');
    session()->forget('pesanan_terakhir');
    session()->put('pesanan_terakhir_id', $order->id);

    return redirect('/pesanan-berhasil');
});
Route::get('/pesanan-berhasil', function () {

    $orderId = session('pesanan_terakhir_id');

    if (!$orderId) {
        return redirect('/');
    }

    $order = Order::with('items')->findOrFail($orderId);

    $pesanan = [
        'nomor' => $order->order_number,

        'penerima' => [
            'nama' => $order->customer_name,
            'telepon' => $order->customer_phone,
            'alamat' => $order->customer_address,
        ],

        'produk' => $order->items->map(function ($item) {
            return [
                'nama' => $item->product_name,
                'harga' => $item->price,
                'jumlah' => $item->quantity,
            ];
        })->all(),

        'total' => $order->total,
        'tanggal' => $order->created_at->format('d-m-Y H:i'),
    ];

       return view('pesanan-berhasil', compact('pesanan'));
});

// ===================================
// ROUTE KONSULTASI AI TANIMART
// ===================================

// Menampilkan halaman konsultasi
Route::get('/konsultasi', [
    KonsultasiController::class, 'index'
])->name('konsultasi');

// Mengirim pertanyaan ke Gemini
Route::post('/konsultasi', [
    KonsultasiController::class, 'tanya'
])->middleware('throttle:10,1')
  ->name('konsultasi.tanya');

  Route::post('/konsultasi/reset', [
    KonsultasiController::class, 'reset'
])->name('konsultasi.reset');