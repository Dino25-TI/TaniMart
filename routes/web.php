<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/keranjang', function () {
    return view('keranjang');
});

Route::post('/keranjang/tambah/{produk}', function ($produk) {
    $daftarProduk = [
        'cabai' => [
            'nama' => 'Benih Cabai Merah',
            'harga' => 15000,
        ],
        'media-tanam' => [
            'nama' => 'Media Tanam Organik',
            'harga' => 25000,
        ],
        'pot' => [
            'nama' => 'Pot Tanaman Minimalis',
            'harga' => 20000,
        ],
    ];

    if (!isset($daftarProduk[$produk])) {
        abort(404);
    }

    $keranjang = session()->get('keranjang', []);

    if (isset($keranjang[$produk])) {
        $keranjang[$produk]['jumlah']++;
    } else {
        $keranjang[$produk] = [
            ...$daftarProduk[$produk],
            'jumlah' => 1,
        ];
    }

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
        $keranjang[$produk]['jumlah']++;
    } elseif ($aksi === 'kurang') {
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
    $keranjang = session()->get('keranjang', []);

if (empty($keranjang)) {
    return redirect('/keranjang');
}
});

Route::post('/checkout', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'nama' => 'required|string|max:100',
        'telepon' => 'required|string|max:20',
        'alamat' => 'required|string|max:500',
    ]);

    $keranjang = session()->get('keranjang', []);

    if (empty($keranjang)) {
        return redirect('/keranjang');
    }

    $total = collect($keranjang)->sum(
        fn ($item) => $item['harga'] * $item['jumlah']
    );

    $pesanan = [
        'nomor' => 'TM-' . strtoupper(uniqid()),
        'penerima' => $data,
        'produk' => $keranjang,
        'total' => $total,
        'tanggal' => now()->format('d-m-Y H:i'),
    ];

    session()->put('pesanan_terakhir', $pesanan);
    session()->forget('keranjang');

    return redirect('/pesanan-berhasil');
});

Route::get('/pesanan-berhasil', function () {
    $pesanan = session()->get('pesanan_terakhir');

    if (!$pesanan) {
        return redirect('/');
    }

    return view('pesanan-berhasil', compact('pesanan'));
});

