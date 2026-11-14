<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OrderController;
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
Route::get('/pesanan', fn() => redirect()->route('pesanan.saya'));

// ===================================
// HALAMAN KHUSUS ADMINISTRATOR
// ===================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/users/{user}/toggle-role', [AdminController::class, 'toggleRole'])->name('users.toggle-role');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
});

// ===================================
// FITUR PENGGUNA TERAUTENTIKASI (User Login)
// ===================================
Route::middleware('auth')->group(function () {
    // Kelola Produk Jualan
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

    // Profil Saya
    Route::get('/profil', function () {
        return view('auth.profil', ['user' => auth()->user()]);
    })->name('profil');

    Route::post('/profil', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = auth()->user();
        $user->name = $validated['name'];
        if (isset($validated['phone'])) {
            $user->phone = $validated['phone'];
        }
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    })->name('profil.update');

    // ==========================================
    // SISTEM PESANAN SHOPEE-STYLE (ISOLASI 100% PER AKUN)
    // ==========================================
    // 1. Sisi Pembeli: Pesanan Saya
    Route::get('/pesanan-saya', [OrderController::class, 'myOrders'])->name('pesanan.saya');
    Route::get('/riwayat-pesanan', fn() => redirect()->route('pesanan.saya'))->name('pesanan.riwayat');

    // Aksi Pembeli
    Route::post('/pesanan/{order}/bayar', [OrderController::class, 'pay'])->name('pesanan.pay');
    Route::post('/pesanan/{order}/batal', [OrderController::class, 'cancel'])->name('pesanan.cancel');
    Route::post('/pesanan/{order}/terima', [OrderController::class, 'confirmReceived'])->name('pesanan.confirm');
    Route::post('/pesanan/item/{item}/nilai', [OrderController::class, 'submitReview'])->name('pesanan.review');

    // 2. Sisi Penjual: Pesanan Masuk Toko
    Route::get('/pesanan-masuk', [OrderController::class, 'sellerOrders'])->name('pesanan.penjual');
    Route::post('/pesanan/{order}/kirim', [OrderController::class, 'shipOrder'])->name('pesanan.ship');

    // ===================================
    // CHECKOUT (WAJIB LOGIN - EKSKLUSIF PER AKUN)
    // ===================================
    Route::get('/checkout', function () {
        $cartKey = 'keranjang_user_' . auth()->id();
        $keranjang = session()->get($cartKey, session()->get('keranjang', []));

        if (empty($keranjang)) {
            return redirect('/keranjang')->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        return view('checkout', compact('keranjang'));
    })->name('checkout');

    Route::post('/checkout', function (Request $request) {
        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'metode_bayar' => 'nullable|string|max:50',
        ]);

        $cartKey = 'keranjang_user_' . auth()->id();
        $keranjang = session()->get($cartKey, session()->get('keranjang', []));

        if (empty($keranjang)) {
            return redirect('/keranjang')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $total = collect($keranjang)->sum(
            fn ($item) => $item['harga'] * $item['jumlah']
        );

        $orderNumber = 'TM-' . strtoupper(Str::random(8));
        $isCod = ($data['metode_bayar'] ?? '') === 'COD (Bayar di Tempat)';

        // SIMPAN KE DATABASE: EKSKLUSIF DENGAN USER_ID AKUN SAAT INI
        $order = Order::create([
            'user_id' => auth()->id(), // STRICT: Pesanan hanya milik akun ini
            'order_number' => $orderNumber,
            'customer_name' => $data['nama'],
            'customer_phone' => $data['telepon'],
            'customer_address' => $data['alamat'],
            'total' => $total,
            'payment_method' => $data['metode_bayar'] ?? 'Transfer Bank',
            'shipping_courier' => 'Kurir TaniExpress',
            'status' => $isCod ? 'dikemas' : 'belum_bayar',
            'paid_at' => $isCod ? now() : null,
        ]);

        foreach ($keranjang as $item) {
            $prod = is_numeric($item['id'] ?? null) ? Product::find($item['id']) : null;
            $sellerId = $prod ? $prod->user_id : null;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $prod ? $prod->id : null,
                'seller_id' => $sellerId, // Terhubung ke penjual produk tersebut
                'product_name' => $item['nama'],
                'quantity' => $item['jumlah'],
                'price' => $item['harga'],
                'subtotal' => $item['harga'] * $item['jumlah'],
            ]);
        }

        $pesanan = [
            'nomor' => $orderNumber,
            'penerima' => $data,
            'produk' => $keranjang,
            'total' => $total,
            'metode' => $data['metode_bayar'] ?? 'Transfer Bank',
            'tanggal' => now()->format('d-m-Y H:i'),
        ];

        session()->put('pesanan_terakhir', $pesanan);

        // Hapus keranjang khusus akun ini
        session()->forget($cartKey);
        session()->forget('keranjang');

        return redirect('/pesanan-berhasil')->with('success', 'Pesanan berhasil dibuat!');
    });
});

// ===================================
// BERANDA / PASAR (Pencarian & Filter)
// ===================================
Route::get('/', function (Request $request) {
    $kategori = $request->query('kategori');
    $q = trim($request->query('q', ''));
    $sort = $request->query('sort', 'terbaru');

    $query = Product::with('user')->where('status', 'tersedia');

    if ($kategori) {
        $query->where('category', 'like', "%{$kategori}%");
    }

    if ($q) {
        $query->where(function($sq) use ($q) {
            $sq->where('name', 'like', "%{$q}%")
               ->orWhere('description', 'like', "%{$q}%")
               ->orWhere('category', 'like', "%{$q}%")
               ->orWhere('location', 'like', "%{$q}%");
        });
    }

    if ($sort === 'termurah') {
        $query->orderBy('price', 'asc');
    } elseif ($sort === 'termahal') {
        $query->orderBy('price', 'desc');
    } else {
        $query->latest();
    }

    $products = $query->get();

    $recommended = collect();
    if ($products->isEmpty() && ($q || $kategori)) {
        $recommended = Product::with('user')->where('status', 'tersedia')->latest()->take(4)->get();
    }

    return view('welcome', compact('products', 'kategori', 'q', 'sort', 'recommended'));
});

// ===================================
// HALAMAN DETAIL PRODUK
// ===================================
Route::get('/produk/{product:slug}', function (Product $product) {
    $related = Product::with('user')
        ->where('category', $product->category)
        ->where('id', '!=', $product->id)
        ->where('status', 'tersedia')
        ->limit(4)
        ->get();

    return view('products.show', compact('product', 'related'));
})->name('products.show');

// ===================================
// KERANJANG BELANJA (TERISOLASI PER AKUN)
// ===================================
Route::get('/keranjang', function () {
    $cartKey = auth()->check() ? 'keranjang_user_' . auth()->id() : 'keranjang_guest';
    $keranjang = session()->get($cartKey, session()->get('keranjang', []));
    return view('keranjang', compact('keranjang'));
});

Route::post('/keranjang/tambah/{produk}', function ($produk) {
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

    $cartKey = auth()->check() ? 'keranjang_user_' . auth()->id() : 'keranjang_guest';
    $keranjang = session()->get($cartKey, session()->get('keranjang', []));

    if (isset($keranjang[$key])) {
        $keranjang[$key]['jumlah']++;
    } else {
        $keranjang[$key] = [
            ...$data,
            'jumlah' => 1,
        ];
    }

    session()->put($cartKey, $keranjang);
    session()->put('keranjang', $keranjang);

    return redirect('/keranjang')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
});

Route::post('/keranjang/ubah/{produk}', function ($produk) {
    $cartKey = auth()->check() ? 'keranjang_user_' . auth()->id() : 'keranjang_guest';
    $keranjang = session()->get($cartKey, session()->get('keranjang', []));

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

    session()->put($cartKey, $keranjang);
    session()->put('keranjang', $keranjang);

    return redirect('/keranjang');
});

Route::post('/keranjang/hapus/{produk}', function ($produk) {
    $cartKey = auth()->check() ? 'keranjang_user_' . auth()->id() : 'keranjang_guest';
    $keranjang = session()->get($cartKey, session()->get('keranjang', []));

    if (isset($keranjang[$produk])) {
        unset($keranjang[$produk]);
        session()->put($cartKey, $keranjang);
        session()->put('keranjang', $keranjang);
    }

    return redirect('/keranjang');
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
