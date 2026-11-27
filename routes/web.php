<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\CancellationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes - TaniMart
|--------------------------------------------------------------------------
*/

// ===================================
// AUTENTIKASI
// ===================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [
        AuthController::class, 'showLoginForm'
    ])->name('login');

    Route::post('/login', [
        AuthController::class, 'login'
    ])->name('login.post');

    Route::get('/register', [
        AuthController::class, 'showRegisterForm'
    ])->name('register');

    Route::post('/register', [
        AuthController::class, 'register'
    ])->name('register.post');

});

Route::post('/logout', [
    AuthController::class, 'logout'
])->name('logout')->middleware('auth');

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

Route::get('/admin',
    fn() => redirect()->route('admin.dashboard')
);

Route::get('/home', fn() => redirect('/'));

Route::get('/jual',
    fn() => redirect()->route('products.create')
);

Route::get('/kategori', fn() => redirect('/#kategori'));
Route::get('/produk', fn() => redirect('/#produk'));
Route::get('/products', fn() => redirect('/#produk'));

Route::get('/ai',
    fn() => redirect()->route('konsultasi')
);

Route::get('/chat',
    fn() => redirect()->route('chat.index')
);

Route::get('/inbox',
    fn() => redirect()->route('chat.index')
);

Route::get('/pesanan',
    fn() => redirect()->route('pesanan.saya')
);

// ===================================
// HALAMAN ADMIN
// ===================================

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::get('/dashboard', [
            AdminController::class, 'dashboard'
        ])->name('dashboard');

        Route::post('/users/{user}/toggle-role', [
            AdminController::class, 'toggleRole'
        ])->name('users.toggle-role');

        Route::delete('/users/{user}', [
            AdminController::class, 'deleteUser'
        ])->name('users.delete');

    });

// ===================================
// FITUR PENGGUNA LOGIN
// ===================================

Route::middleware('auth')->group(function () {

    // KELOLA PRODUK

    Route::get('/jual-produk', [
        ProductController::class, 'create'
    ])->name('products.create');

    Route::post('/jual-produk', [
        ProductController::class, 'store'
    ])->name('products.store');

    Route::get('/produk-saya', [
        ProductController::class, 'myProducts'
    ])->name('products.my');

    Route::get('/produk-saya/{product}/edit', [
        ProductController::class, 'edit'
    ])->name('products.edit');

    Route::put('/produk-saya/{product}', [
        ProductController::class, 'update'
    ])->name('products.update');

    Route::delete('/produk-saya/{product}', [
        ProductController::class, 'destroy'
    ])->name('products.destroy');

    Route::post('/produk-saya/{product}/toggle-status', [
        ProductController::class, 'toggleStatus'
    ])->name('products.toggle-status');

    // CHAT

    Route::get('/pesan', [
        ChatController::class, 'index'
    ])->name('chat.index');

    Route::post('/pesan/{user}', [
        ChatController::class, 'store'
    ])->name('chat.store');

    // PROFIL

    Route::get('/profil', function () {

        return view('auth.profil', [
            'user' => auth()->user()
        ]);

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

        return back()->with(
            'success',
            'Profil Anda berhasil diperbarui!'
        );

    })->name('profil.update');

    // PESANAN PEMBELI

    Route::get('/pesanan-saya', [
        OrderController::class, 'myOrders'
    ])->name('pesanan.saya');

    Route::get('/riwayat-pesanan',
        fn() => redirect()->route('pesanan.saya')
    )->name('pesanan.riwayat');

    // AKSI PEMBELI

    Route::post('/pesanan/{order}/bayar', [
        OrderController::class, 'pay'
    ])->name('pesanan.pay');

    Route::post('/pesanan/{order}/batal', [
        CancellationController::class, 'requestCancel'
    ])->name('pesanan.cancel');

    Route::post('/pesanan/{order}/batal/keputusan', [
        CancellationController::class, 'review'
    ])->name('pesanan.cancel.review');

    Route::post('/pesanan/{order}/terima', [
        OrderController::class, 'confirmReceived'
    ])->name('pesanan.confirm');

    Route::post('/pesanan/item/{item}/nilai', [
        OrderController::class, 'submitReview'
    ])->name('pesanan.review');

    // AKSI PENJUAL

    Route::get('/pesanan-masuk', [
        OrderController::class, 'sellerOrders'
    ])->name('pesanan.penjual');

    Route::post('/pesanan/{order}/mulai-proses', [
        OrderController::class, 'startProcessing'
    ])->name('orders.start-processing');

    Route::post('/pesanan/{order}/kirim', [
        OrderController::class, 'shipOrder'
    ])->name('pesanan.ship');

    // CHECKOUT DATABASE

    Route::get('/checkout', [
        CheckoutController::class, 'index'
    ])->name('checkout');

    Route::post('/checkout', [
        CheckoutController::class, 'store'
    ])->name('checkout.store');

});

// ===================================
// FITUR BARU: AUTOCOMPLETE PRODUK
// ===================================

Route::get('/pencarian/saran', function (Request $request) {

    $input = $request->query('q', '');

    $keyword = is_string($input)
        ? trim($input)
        : '';

    $keyword = \Illuminate\Support\Str::limit(
        $keyword,
        60,
        ''
    );

    // Tidak melakukan query jika kurang dari 2 karakter.
    if (mb_strlen($keyword) < 2) {
        return response()->json([
            'suggestions' => []
        ]);
    }

    // Filter dari beranda yang masih aktif.
    $categoryInput = $request->query('kategori', '');

    $category = is_string($categoryInput)
        ? trim($categoryInput)
        : '';

    $stockInput = $request->query('stok', '');

    $stock = is_string($stockInput) &&
        in_array($stockInput, ['tersedia', 'habis'], true)
            ? $stockInput
            : '';

    // Hanya produk dengan status aktif.
    $query = Product::query()
        ->select([
            'id',
            'name',
            'slug',
            'category',
            'price',
            'stock',
            'image',
            'icon'
        ])
        ->where('status', 'tersedia')
        ->where(function ($sub) use ($keyword) {

            $sub->where('name', 'like', "%{$keyword}%")
                ->orWhere('category', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%")
                ->orWhere('location', 'like', "%{$keyword}%");

        });

    if ($category !== '') {
        $query->where('category', $category);
    }

    if ($stock === 'tersedia') {
        $query->where('stock', '>', 0);

    } elseif ($stock === 'habis') {
        $query->where('stock', '<=', 0);
    }

    /*
     * Prioritaskan:
     * 1. Nama yang diawali kata kunci
     * 2. Produk dengan stok tersedia
     * 3. Urutan nama
     */

    $products = $query
        ->orderByRaw(
            'CASE WHEN name LIKE ? THEN 0 ELSE 1 END',
            [$keyword . '%']
        )
        ->orderByRaw(
            'CASE WHEN stock > 0 THEN 0 ELSE 1 END'
        )
        ->orderBy('name')
        ->limit(6)
        ->get();

    // Kirim data ringkas untuk dropdown navbar.
    return response()->json([
        'suggestions' => $products
            ->map(function (Product $product) {

                return [
                    'name' => $product->name,
                    'category' => $product->category,
                    'price' => 'Rp' . number_format(
                        $product->price,
                        0,
                        ',',
                        '.'
                    ),
                    'stock' => (int) $product->stock,
                    'image' => $product->image
                        ? asset($product->image)
                        : null,
                    'icon' => $product->icon ?: '🌱',
                    'url' => route(
                        'products.show',
                        $product->slug
                    ),
                ];

            })
            ->values(),
    ]);

})->middleware('throttle:120,1')
  ->name('products.suggestions');

// ===================================
// BERANDA / PASAR
// ===================================

Route::get('/', function (Request $request) {

    $input = $request->query('q', '');

    $q = is_string($input)
        ? trim($input)
        : '';

    $q = \Illuminate\Support\Str::limit($q, 100, '');

    $catInput = $request->query('kategori', '');

    $kategori = is_string($catInput)
        ? trim($catInput)
        : '';

    $sortInput = $request->query('sort', 'terbaru');

    $sort = is_string($sortInput) &&
        in_array(
            $sortInput,
            ['terbaru', 'termurah', 'termahal'],
            true
        )
        ? $sortInput
        : 'terbaru';

    $stockInput = $request->query('stok', '');

    $stok = is_string($stockInput) &&
        in_array(
            $stockInput,
            ['tersedia', 'habis'],
            true
        )
        ? $stockInput
        : '';

    // Produk aktif tetap tampil meski stoknya nol.
    $query = Product::with('user')
        ->where('status', 'tersedia');

    // FILTER KATEGORI
    if ($kategori !== '') {
        $query->where('category', $kategori);
    }

    // SEARCH
    if ($q !== '') {
        $query->where(function ($sub) use ($q) {

            $sub->where('name', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%")
                ->orWhere('category', 'like', "%{$q}%")
                ->orWhere('location', 'like', "%{$q}%");

        });
    }

    // FILTER STOK
    if ($stok === 'tersedia') {
        $query->where('stock', '>', 0);

    } elseif ($stok === 'habis') {
        $query->where('stock', '<=', 0);
    }

    // SORTING
    if ($sort === 'termurah') {
        $query->orderBy('price', 'asc')
            ->orderBy('id', 'desc');

    } elseif ($sort === 'termahal') {
        $query->orderBy('price', 'desc')
            ->orderBy('id', 'desc');

    } else {
        $query->latest();
    }

    $products = $query->get();

    // KATEGORI DATABASE
    $availableCategories = Product::where(
            'status',
            'tersedia'
        )
        ->whereNotNull('category')
        ->where('category', '!=', '')
        ->distinct()
        ->orderBy('category')
        ->pluck('category');

    // REKOMENDASI SAAT HASIL KOSONG
    $recommended = collect();

    if (
        $products->isEmpty() &&
        ($q !== '' || $kategori !== '' || $stok !== '')
    ) {

        $recommended = Product::with('user')
            ->where('status', 'tersedia')
            ->where('stock', '>', 0)
            ->latest()
            ->take(4)
            ->get();

    }

    return view('welcome', compact(
        'products',
        'kategori',
        'q',
        'sort',
        'stok',
        'recommended',
        'availableCategories'
    ));

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

    return view(
        'products.show',
        compact('product', 'related')
    );

})->name('products.show');

// ===================================
// KERANJANG BELANJA
// ===================================

Route::middleware('auth')->group(function () {

    Route::get('/keranjang', [
        CartController::class, 'index'
    ])->name('cart.index');

    Route::post('/keranjang/tambah/{produk}', [
        CartController::class, 'add'
    ])->name('cart.add');

    Route::post('/keranjang/ubah/{produk}', [
        CartController::class, 'update'
    ])->name('cart.update');

    Route::post('/keranjang/hapus/{produk}', [
        CartController::class, 'remove'
    ])->name('cart.remove');

});

// ===================================
// HALAMAN PESANAN BERHASIL
// ===================================

Route::get('/pesanan-berhasil', function () {

    $pesanan = session()->get('pesanan_terakhir');

    if (!$pesanan) {
        return redirect('/');
    }

    return view(
        'pesanan-berhasil',
        compact('pesanan')
    );

});

// ===================================
// KONSULTASI AI TANIMART
// ===================================

Route::get('/konsultasi', [
    KonsultasiController::class, 'index'
])->name('konsultasi');

Route::post('/konsultasi', [
    KonsultasiController::class, 'tanya'
])->middleware('throttle:10,1')
  ->name('konsultasi.tanya');

Route::post('/konsultasi/reset', [
    KonsultasiController::class, 'reset'
])->name('konsultasi.reset');
