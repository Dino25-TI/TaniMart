
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk Jualan Saya | TaniMart</title>

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <meta name="description" content="Kelola produk, stok, dan status penjualan di kios TaniMart.">
    <meta name="theme-color" content="#34754a">

    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background-color: #f4f6f3;
        }

        .my-products-container {
            max-width: 1100px;
            margin: 2.5rem auto 4rem;
            padding: 0 1.5rem;
        }

        .dashboard-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .dashboard-title h1 {
            font-size: 1.85rem;
            font-weight: 800;
            color: #24583b;
            margin-bottom: .35rem;
        }

        .dashboard-title p {
            color: #758176;
            font-size: .95rem;
        }

        .dashboard-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-add-product,
        .btn-incoming-orders {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: .85rem 1.4rem;
            border-radius: 14px;
            font-weight: 700;
            font-size: .95rem;
            text-decoration: none;
            transition: .2s;
        }

        .btn-add-product {
            background: #34754a;
            color: #fff !important;
            box-shadow: 0 6px 20px rgba(52,117,74,.20);
        }

        .btn-add-product:hover {
            background: #24583b;
            transform: translateY(-2px);
        }

        .btn-incoming-orders {
            background: #e0f2fe;
            color: #0369a1;
            border: 1.5px solid #bae6fd;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(185px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .mini-stat {
            background: #fff;
            border-radius: 18px;
            padding: 1.25rem;
            border: 1px solid #e1e7e0;
            display: flex;
            align-items: center;
            gap: .8rem;
            box-shadow: 0 4px 15px rgba(0,0,0,.03);
        }

        .mini-stat-icon {
            width: 45px;
            height: 45px;
            flex: 0 0 45px;
            border-radius: 12px;
            background: #e7efe4;
            color: #24583b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .mini-stat-icon.warning {
            background: #ffedd5;
            color: #c2410c;
        }

        .mini-stat-icon.off {
            background: #f1f5f9;
            color: #64748b;
        }

        .mini-stat-info h3 {
            font-size: 1.45rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 2px;
        }

        .mini-stat-info p {
            font-size: .78rem;
            color: #64748b;
            font-weight: 600;
            line-height: 1.4;
        }

        .table-card {
            background: #fff;
            border-radius: 20px;
            padding: 1.75rem;
            border: 1px solid #e1e7e0;
            box-shadow: 0 4px 15px rgba(0,0,0,.03);
        }

        .table-card-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1.2rem;
        }

        .table-card-heading h2 {
            color: #24583b;
            font-size: 1.13rem;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .table-card-heading p {
            color: #64748b;
            font-size: .85rem;
            line-height: 1.55;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .seller-products-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .seller-products-table th {
            background: #f8fafc;
            color: #475569;
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding: .85rem 1rem;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .seller-products-table td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: .88rem;
            vertical-align: middle;
        }

        .seller-products-table tbody tr:hover td {
            background: #fbfcfb;
        }

        .product-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 180px;
        }

        .product-avatar {
            width: 46px;
            height: 46px;
            flex: 0 0 46px;
            border-radius: 12px;
            background: #e7efe4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            overflow: hidden;
            border: 1px solid #dce4db;
        }

        .product-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-tersedia {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .status-habis {
            background: #ffedd5;
            color: #c2410c;
            border: 1px solid #fed7aa;
        }

        .status-nonaktif {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #cbd5e1;
        }

        .stock-warning {
            color: #b45309;
            font-weight: 700;
        }

        .stock-empty {
            color: #b91c1c;
            font-weight: 700;
        }

        .action-btns {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            justify-content: flex-end;
            min-width: 240px;
        }

        .action-btns form {
            margin: 0;
        }

        .btn-act {
            padding: 7px 10px;
            border-radius: 8px;
            font-size: .8rem;
            font-weight: 600;
            border: 1px solid #cbd5e1;
            background: #fff;
            color: #334155;
            cursor: pointer;
            transition: .2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-act:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .btn-act-danger {
            color: #b91c1c;
            border-color: #fecaca;
            background: #fef2f2;
        }

        .btn-act-danger:hover {
            background: #b91c1c;
            color: #fff;
        }

        .product-hint {
            display: block;
            margin-top: 6px;
            font-size: .72rem;
            line-height: 1.45;
            color: #64748b;
        }

        .alert-box {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 1rem 1.25rem;
            border-radius: 14px;
            margin-bottom: 1.5rem;
            font-size: .9rem;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .empty-state {
            text-align: center;
            padding: 3.5rem 1rem;
            color: #758176;
        }

        .empty-state i {
            font-size: 3.5rem;
            color: #a4cbb0;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #26392d;
            margin-bottom: .4rem;
        }

        @media (max-width: 700px) {
            .my-products-container {
                padding: 0 1rem;
            }

            .table-card {
                padding: 1rem;
            }

            .dashboard-title h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    @include('partials.navbar')

    <main class="my-products-container">

        @if(session('success'))
            <div class="alert-box alert-success" role="status">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-box alert-error" role="alert">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert-box alert-error" role="alert">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        {{-- HEADER DASHBOARD --}}
        <div class="dashboard-top">

            <div class="dashboard-title">
                <h1>Kios Jualan Saya 🌿</h1>

                <p>
                    Kelola semua barang pertanian dan hasil kebun
                    yang Anda pasarkan di TaniMart
                </p>
            </div>

            <div class="dashboard-actions">

                <a
                    href="{{ route('pesanan.penjual') }}"
                    class="btn-incoming-orders"
                >
                    <i class="fa-solid fa-store"></i>
                    <span>Pesanan Masuk Toko</span>
                </a>

                <a
                    href="{{ route('products.create') }}"
                    class="btn-add-product"
                >
                    <i class="fa-solid fa-plus"></i>
                    <span>Pasang Produk Baru</span>
                </a>

            </div>
        </div>

        {{-- HITUNG STATISTIK SELLER --}}
        @php
            $readyCount = $products->filter(
                fn ($p) =>
                    $p->status === 'tersedia' &&
                    (int) $p->stock > 0
            )->count();

            $outOfStockCount = $products->filter(
                fn ($p) =>
                    $p->status === 'tersedia' &&
                    (int) $p->stock <= 0
            )->count();

            $inactiveCount = $products->filter(
                fn ($p) => $p->status !== 'tersedia'
            )->count();
        @endphp

        {{-- STATISTIK PRODUK --}}
        <div class="stats-row">

            <div class="mini-stat">
                <div class="mini-stat-icon">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <div class="mini-stat-info">
                    <h3>{{ $products->count() }}</h3>
                    <p>Total Produk Saya</p>
                </div>
            </div>

            <div class="mini-stat">
                <div class="mini-stat-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="mini-stat-info">
                    <h3>{{ $readyCount }}</h3>
                    <p>Produk Siap Jual</p>
                </div>
            </div>

            <div class="mini-stat">
                <div class="mini-stat-icon warning">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <div class="mini-stat-info">
                    <h3>{{ $outOfStockCount }}</h3>
                    <p>Produk Stok Habis</p>
                </div>
            </div>

            <div class="mini-stat">
                <div class="mini-stat-icon off">
                    <i class="fa-solid fa-eye-slash"></i>
                </div>
                <div class="mini-stat-info">
                    <h3>{{ $inactiveCount }}</h3>
                    <p>Produk Nonaktif</p>
                </div>
            </div>

            <div class="mini-stat">
                <div class="mini-stat-icon">
                    <i class="fa-solid fa-warehouse"></i>
                </div>
                <div class="mini-stat-info">
                    <h3>
                        {{
                            number_format(
                                $products->sum('stock'),
                                0,
                                ',',
                                '.'
                            )
                        }}
                    </h3>

                    <p>Akumulasi Stok (Unit)</p>
                </div>
            </div>

        </div>

        {{-- TABEL PRODUK --}}
        <div class="table-card">

            <div class="table-card-heading">
                <div>
                    <h2>
                        <i class="fa-solid fa-seedling"></i>
                        Daftar Produk Toko
                    </h2>

                    <p>
                        Status Aktif menentukan apakah produk tampil
                        di Pasar. Stok menentukan apakah produk
                        bisa dibeli. Produk yang dihapus otomatis
                        keluar dari keranjang pembeli, tetapi
                        riwayat pesanan tetap disimpan.
                    </p>
                </div>
            </div>

            @if($products->isNotEmpty())

                <div class="table-responsive">

                    <table class="seller-products-table">

                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Sisa Stok</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th style="text-align:right;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($products as $p)

                                @php
                                    $isActive = $p->status === 'tersedia';

                                    $stockQty = max(
                                        0,
                                        (int) $p->stock
                                    );

                                    $cartCount = (int) (
                                        $p->cart_items_count ?? 0
                                    );

                                    $orderCount = (int) (
                                        $p->order_items_count ?? 0
                                    );
                                @endphp

                                <tr>

                                    {{-- PRODUK --}}
                                    <td>
                                        <div class="product-meta">

                                            <div class="product-avatar">
                                                @if($p->image)
                                                    <img
                                                        src="{{ asset($p->image) }}"
                                                        alt="{{ $p->name }}"
                                                    >
                                                @else
                                                    <span>
                                                        {{ $p->icon ?? '🌱' }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div>
                                                <strong>{{ $p->name }}</strong>
                                                <br>

                                                <small style="color:#64748b;">
                                                    Dibuat:
                                                    {{ $p->created_at->format('d M Y') }}
                                                </small>

                                                @if($orderCount > 0)
                                                    <span class="product-hint">
                                                        <i class="fa-solid fa-receipt"></i>
                                                        Memiliki riwayat transaksi
                                                        (tetap aman jika dihapus)
                                                    </span>
                                                @endif

                                                @if($cartCount > 0)
                                                    <span class="product-hint">
                                                        <i class="fa-solid fa-cart-shopping"></i>
                                                        Ada di {{ $cartCount }} keranjang
                                                        (akan dibersihkan jika dihapus)
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    {{-- KATEGORI --}}
                                    <td>
                                        {{ $p->category }}
                                    </td>

                                    {{-- HARGA --}}
                                    <td>
                                        <strong style="color:#24583b;">
                                            Rp
                                            {{
                                                number_format(
                                                    $p->price,
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}
                                        </strong>

                                        <small style="color:#64748b;">
                                            / {{ $p->unit }}
                                        </small>
                                    </td>

                                    {{-- STOK --}}
                                    <td>
                                        <span class="{{
                                            $stockQty === 0
                                                ? 'stock-empty'
                                                : (
                                                    $stockQty <= 10
                                                        ? 'stock-warning'
                                                        : ''
                                                )
                                        }}">
                                            {{ $stockQty }}
                                            {{ $p->unit }}
                                        </span>
                                    </td>

                                    {{-- LOKASI --}}
                                    <td>
                                        <small>
                                            <i
                                                class="fa-solid fa-location-dot"
                                                style="color:#ef4444;"
                                            ></i>
                                            {{ $p->location }}
                                        </small>
                                    </td>

                                    {{-- STATUS --}}
                                    <td>
                                        @if(!$isActive)

                                            <span class="status-badge status-nonaktif">
                                                <i class="fa-solid fa-eye-slash"></i>
                                                Nonaktif
                                            </span>

                                        @elseif($stockQty === 0)

                                            <span class="status-badge status-habis">
                                                <i class="fa-solid fa-box-open"></i>
                                                Stok Habis
                                            </span>

                                        @else

                                            <span class="status-badge status-tersedia">
                                                <i class="fa-solid fa-circle-check"></i>
                                                Aktif
                                            </span>

                                        @endif
                                    </td>

                                    {{-- AKSI SELLER --}}
                                    <td>
                                        <div class="action-btns">

                                            {{-- AKTIF / NONAKTIF --}}
                                            <form
                                                action="{{ route('products.toggle-status', $p->id) }}"
                                                method="POST"
                                            >
                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="btn-act"
                                                    title="{{ $isActive ? 'Sembunyikan produk dari pasar' : 'Tampilkan produk di pasar' }}"
                                                >
                                                    <i class="fa-solid {{
                                                        $isActive
                                                            ? 'fa-eye-slash'
                                                            : 'fa-eye'
                                                    }}"></i>

                                                    {{
                                                        $isActive
                                                            ? 'Nonaktifkan'
                                                            : 'Aktifkan'
                                                    }}
                                                </button>
                                            </form>

                                            {{-- EDIT PRODUK --}}
                                            <a
                                                href="{{ route('products.edit', $p->id) }}"
                                                class="btn-act"
                                                title="Edit produk"
                                            >
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                Edit
                                            </a>

                                            {{-- HAPUS PRODUK --}}
                                            {{--
                                                Tombol ini TIDAK dikunci
                                                walaupun produk ada di
                                                keranjang atau punya order.
                                            --}}
                                            <form
                                                action="{{ route('products.destroy', $p->id) }}"
                                                method="POST"
                                                data-product-name="{{ $p->name }}"
                                                onsubmit="return confirm('Hapus produk ' + this.dataset.productName + ' dari kios? Produk akan hilang dari katalog dan semua keranjang pembeli. Riwayat pesanan tetap aman.');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn-act btn-act-danger"
                                                    title="Hapus produk dari katalog dan keranjang"
                                                >
                                                    <i class="fa-solid fa-trash-can"></i>
                                                    Hapus
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else

                <div class="empty-state">
                    <i class="fa-solid fa-seedling"></i>

                    <h3>
                        Anda belum memasang produk untuk dijual
                    </h3>

                    <p>
                        Mulai tawarkan bibit, hasil panen sayuran,
                        pot, atau perlengkapan kebun Anda sekarang juga!
                    </p>

                    <br>

                    <a
                        href="{{ route('products.create') }}"
                        class="btn-add-product"
                    >
                        <i class="fa-solid fa-plus"></i>
                        Pasang Produk Pertama Anda
                    </a>
                </div>

            @endif

        </div>
    </main>

    @include('partials.footer')
</body>
</html>
