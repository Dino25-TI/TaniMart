<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\ChatController;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes - TaniMart
|--------------------------------------------------------------------------
*/

// ===================================
// AUTENTIKASI (Tamu / Guest)
// ===================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Logout (Harus Login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ===================================
// SHORTCUT RUTE PINTAS
// ===================================
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    return auth()->user()->isAdmin() 
        ? redirect()->route('admin.dashboard') 
        : redirect()->route('products.my');
})->name('dashboard');

Route::get('/admin', fn() => redirect()->route('admin.dashboard'));
Route::get('/home', fn() => redirect('/'));
Route::get('/jual', fn() => redirect()->route('products.create'));
Route::get('/kategori', fn() => redirect('/#kategori'));
Route::get('/produk', fn() => redirect('/#produk'));
Route::get('/products', fn() => redirect('/#produk'));
Route::get('/ai', fn() => redirect()->route('konsultasi'));
Route::get('/chat', fn() => redirect()->route('chat.index'));
Route::get('/inbox', fn() => redirect()->route('chat.index'));

// ===================================
// HALAMAN KHUSUS ADMINISTRATOR
// ===================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/users/{user}/toggle-role', [AdminController::class, 'toggleRole'])->name('users.toggle-role');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
});

// ===================================
// FITUR JUAL PRODUK & PRODUK SAYA (User Login)
// ===================================
Route::middleware('auth')->group(function () {
    Route::get('/jual-produk', [ProductController::class, 'create'])->name('products.create');
    Route::post('/jual-produk', [ProductController::class, 'store'])->name('products.store');
    Route::get('/produk-saya', [ProductController::class, 'myProducts'])->name('products.my');
    Route::get('/produk-saya/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/produk-saya/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/produk-saya/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/produk-saya/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');

    // Fitur Chat Pembeli & Penjual (Gaya Shopee)
    Route::get('/pesan', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/pesan/{user}', [ChatController::class, 'store'])->name('chat.store');
});

// ===================================
// BERANDA / PASAR
// ===================================
Route::get('/', function (Request $request) {
    $kategori = $request->query('kategori');

    $query = Product::with('user');

    if ($kategori) {
        $query->where('category', 'like', "%{$kategori}%")
              ->orWhere('slug', 'like', "%{$kategori}%");
    }

    $products = $query->where('status', 'tersedia')->latest()->get();

    return view('welcome', compact('products', 'kategori'));
});

// ===================================
// KERANJANG BELANJA
// ===================================
Route::get('/keranjang', function () {
    return view('keranjang');
});

Route::post('/keranjang/tambah/{produk}', function ($produk) {
    // Cari produk di DB via ID atau slug
    $item = Product::with('user')->where('id', $produk)->orWhere('slug', $produk)->first();

    if ($item) {
        $key = (string) $item->id;
        $data = [
            'id' => $item->id,
            'nama' => $item->name,
            'harga' => $item->price,
            'icon' => $item->icon ?? '🌱',
            'satuan' => $item->unit ?? 'pcs',
            'penjual' => $item->user->name ?? 'TaniMart',
        ];
    } else {
        $daftarProduk = [
            'cabai' => ['nama' => 'Benih Cabai Merah', 'harga' => 15000, 'icon' => '🌶️', 'satuan' => 'pack', 'penjual' => 'TaniMart'],
            'media-tanam' => ['nama' => 'Media Tanam Organik', 'harga' => 25000, 'icon' => '🌱', 'satuan' => 'karung', 'penjual' => 'TaniMart'],
            'pot' => ['nama' => 'Pot Tanaman Minimalis', 'harga' => 20000, 'icon' => '🪴', 'satuan' => 'pcs', 'penjual' => 'TaniMart'],
        ];

        if (!isset($daftarProduk[$produk])) {
            abort(404);
        }

        $key = $produk;
        $data = $daftarProduk[$produk];
    }

    $keranjang = session()->get('keranjang', []);

    if (isset($keranjang[$key])) {
        $keranjang[$key]['jumlah']++;
    } else {
        $keranjang[$key] = [
            ...$data,
            'jumlah' => 1,
        ];
    }

    session()->put('keranjang', $keranjang);

    return redirect('/keranjang')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
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

// ===================================
// CHECKOUT & PESANAN
// ===================================
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

    $total = collect($keranjang)->sum(
        fn ($item) => $item['harga'] * $item['jumlah']
    );

    $orderNumber = 'TM-' . strtoupper(Str::random(8));

    // Simpan ke database jika tabel orders tersedia
    try {
        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $data['nama'],
            'customer_phone' => $data['telepon'],
            'customer_address' => $data['alamat'],
            'total' => $total,
            'status' => 'pending',
        ]);

        foreach ($keranjang as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => is_numeric($item['id'] ?? null) ? $item['id'] : null,
                'product_name' => $item['nama'],
                'quantity' => $item['jumlah'],
                'price' => $item['harga'],
                'subtotal' => $item['harga'] * $item['jumlah'],
            ]);
        }
    } catch (\Exception $e) {
        // Fallback jika tidak menggunakan database orders
    }

    $pesanan = [
        'nomor' => $orderNumber,
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

// ===================================
// ROUTE KONSULTASI AI TANIMART
// ===================================
Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi');
Route::post('/konsultasi', [KonsultasiController::class, 'tanya'])->middleware('throttle:10,1')->name('konsultasi.tanya');
Route::post('/konsultasi/reset', [KonsultasiController::class, 'reset'])->name('konsultasi.reset');
