
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Keranjang Belanja | TaniMart</title>
    <meta name="theme-color" content="#04442c">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* =============================================
           TANIMART - STITCH CART REDESIGN
           CSS khusus halaman Keranjang Belanja
           ============================================= */

        body.tm-cart-redesign {
            --cart-primary: #04442c;
            --cart-green: #245c42;
            --cart-soft: #e9f7ec;
            --cart-bg: #effdf1;
            --cart-border: #e2ede4;
            --cart-text: #26392c;
            --cart-muted: #718377;

            margin: 0;
            background: var(--cart-bg);
            color: var(--cart-text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        .tm-cart-redesign *,
        .tm-cart-redesign *::before,
        .tm-cart-redesign *::after {
            box-sizing: border-box;
        }

        .tm-cart-redesign [hidden] {
            display: none !important;
        }

        .tm-cart-redesign button,
        .tm-cart-redesign input {
            font-family: inherit;
        }

        .tm-cart-redesign .tm-navbar-wrapper {
            background: #effdf1 !important;
        }

        /* LAYOUT UTAMA */

        .sc-container {
            width: min(94%, 1370px);
            margin: auto;
            padding: 29px 0 100px;
        }

        .sc-breadcrumb {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 21px;
            color: #7b8c80;
            font-size: 11px;
        }

        .sc-breadcrumb a {
            color: #516d5c;
            text-decoration: none;
        }

        .sc-breadcrumb a:hover {
            color: var(--cart-primary);
        }

        .sc-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 27px;
        }

        .sc-heading-title {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 7px;
        }

        .sc-heading-title > span {
            width: 45px;
            height: 45px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: var(--cart-green);
            color: #fff;
            font-size: 20px;
        }

        .sc-heading h1 {
            font-size: clamp(27px, 3vw, 36px);
            font-weight: 800;
            letter-spacing: -.9px;
            margin: 0;
            color: #1d3225;
        }

        .sc-heading p {
            margin: 0;
            font-size: 12px;
            color: var(--cart-muted);
            line-height: 1.7;
        }

        /* STATISTIK KECIL */

        .sc-mini-stats {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 999px;
            background: #e7f4ea;
            color: #556f5b;
            font-size: 11px;
        }

        .sc-mini-stats strong {
            color: #203d2c;
            font-weight: 800;
        }

        .sc-stat-dot {
            display: inline-block;
            width: 7px;
            height: 7px;
            margin-right: 5px;
            border-radius: 50%;
            background: var(--cart-green);
        }

        .sc-stat-divider {
            height: 13px;
            width: 2px;
            background: #b6cbbd;
        }

        /* GRID 2 KOLOM */

        .sc-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.9fr) minmax(290px, .93fr);
            align-items: start;
            gap: 23px;
        }

        .sc-left,
        .sc-right {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .sc-right {
            position: sticky;
            top: 90px;
        }

        /* KARTU */

        .sc-card {
            border: 1px solid #e6eee7;
            border-radius: 19px;
            background: #fff;
            box-shadow: 0 5px 18px rgba(0, 51, 33, .035);
        }

        /* TOOLBAR PILIH SEMUA */

        .sc-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
            padding: 19px 22px;
        }

        .sc-toolbar-left,
        .sc-toolbar-right {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 11px;
        }

        .sc-toolbar-title {
            font-size: 12px;
            font-weight: 700;
            color: #2a4131;
            cursor: pointer;
        }

        .sc-guarantee {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 11px;
            background: #e1f2dd;
            color: #53754d;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
        }

        .sc-delete-selected {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px;
            border: 0;
            background: transparent;
            color: #536358;
            font-size: 11px;
            cursor: pointer;
        }

        .sc-delete-selected:hover {
            color: #be3939;
        }

        .sc-delete-selected:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        /* CHECKBOX */

        .sc-checkbox {
            appearance: none;
            -webkit-appearance: none;
            display: inline-grid;
            place-content: center;
            flex: 0 0 20px;
            width: 20px;
            height: 20px;
            margin: 0;
            border-radius: 6px;
            border: 1.5px solid #8dad96;
            background: #fff;
            cursor: pointer;
        }

        .sc-checkbox:checked {
            background: var(--cart-green);
            border-color: var(--cart-green);
        }

        .sc-checkbox:checked::after {
            content: '✓';
            color: #fff;
            font-size: 13px;
            font-weight: 800;
            line-height: 1;
        }

        .sc-checkbox:disabled {
            background: #f0f3f0;
            border-color: #c9d3cc;
            cursor: not-allowed;
        }

        .sc-checkbox:focus-visible {
            outline: 3px solid #9bd4ad;
            outline-offset: 3px;
        }

        /* SELLER GROUP */

        .sc-seller-card {
            padding: 20px 22px;
        }

        .sc-seller-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            padding-bottom: 12px;
        }

        .sc-seller-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .sc-seller-avatar {
            width: 37px;
            height: 37px;
            display: grid;
            place-items: center;
            flex: 0 0 37px;
            border-radius: 50%;
            background: #dcefdc;
            color: #326b49;
            font-size: 17px;
        }

        .sc-seller-name {
            font-size: 12px;
            color: #283d2d;
            font-weight: 800;
            line-height: 1.6;
        }

        .sc-seller-location {
            margin-top: 3px;
            font-size: 10px;
            color: #89988b;
            line-height: 1.6;
        }

        .sc-chat-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            min-height: 34px;
            padding: 8px 13px;
            border-radius: 999px;
            background: #e4f2e8;
            color: #34664b;
            font-size: 10px;
            font-weight: 800;
            text-decoration: none;
        }

        .sc-chat-btn:hover {
            background: #d2e9d8;
            color: #24553b;
        }

        /* PRODUK */

        .sc-product {
            display: flex;
            align-items: center;
            gap: 13px;
            min-width: 0;
            padding: 18px 0;
            border-top: 1px solid #eef3ef;
        }

        .sc-product-main {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1 1 auto;
            min-width: 0;
        }

        .sc-product-photo {
            display: grid;
            place-items: center;
            flex: 0 0 84px;
            width: 84px;
            height: 84px;
            border-radius: 12px;
            overflow: hidden;
            background: #e4f3e8;
            font-size: 35px;
        }

        .sc-product-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sc-product-info {
            min-width: 0;
        }

        .sc-product-name {
            display: block;
            color: #293d2e;
            font-size: 12px;
            line-height: 1.6;
            font-weight: 800;
            text-decoration: none;
            overflow-wrap: anywhere;
        }

        a.sc-product-name:hover {
            color: #0e7249;
        }

        .sc-product-category {
            margin-top: 4px;
            color: #7c8e80;
            font-size: 10px;
            line-height: 1.6;
        }

        .sc-product-price {
            margin-top: 5px;
            color: #315a40;
            font-size: 11px;
            font-weight: 800;
        }

        .sc-product-price small {
            font-size: 10px;
            font-weight: 500;
        }

        .sc-stock-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 9px;
            padding: 5px 9px;
            border-radius: 999px;
            background: #e9f7ec;
            color: #5f8467;
            font-size: 9px;
            font-weight: 700;
        }

        .sc-stock-label.problem {
            background: #fff0e8;
            color: #b35a33;
        }

        .sc-product.unavailable {
            opacity: .85;
        }

        /* QUANTITY */

        .sc-product-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 13px;
            flex: 0 0 auto;
        }

        .sc-quantity {
            display: flex;
            align-items: center;
            overflow: hidden;
            border-radius: 999px;
            background: #e4f2e8;
        }

        .sc-quantity form {
            display: flex;
            margin: 0;
        }

        .sc-qty-btn {
            width: 31px;
            height: 34px;
            border: 0;
            background: transparent;
            color: #2a593e;
            font-size: 12px;
            cursor: pointer;
        }

        .sc-qty-btn:hover {
            background: #d1e6d6;
        }

        .sc-qty-btn:disabled {
            opacity: .35;
            cursor: not-allowed;
        }

        .sc-qty-number {
            width: 29px;
            text-align: center;
            font-size: 12px;
            font-weight: 800;
            color: #233d2d;
        }

        .sc-item-total {
            min-width: 110px;
            text-align: right;
        }

        .sc-item-total small {
            display: block;
            color: #89998b;
            font-size: 9px;
            margin-bottom: 6px;
        }

        .sc-item-total strong {
            display: block;
            font-size: 17px;
            color: #18563a;
            white-space: nowrap;
        }

        .sc-remove-form {
            margin: 0;
        }

        .sc-remove {
            display: grid;
            place-items: center;
            width: 31px;
            height: 34px;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: #86958b;
            cursor: pointer;
        }

        .sc-remove:hover {
            background: #fee9e8;
            color: #c33b37;
        }

        /* SUMMARY */

        .sc-summary {
            padding: 23px;
        }

        .sc-summary-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 22px;
        }

        .sc-summary-head h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            color: #27372b;
        }

        .sc-summary-badge {
            padding: 6px 10px;
            border-radius: 999px;
            background: #245c42;
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .sc-summary-line {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 17px;
            font-size: 12px;
            line-height: 1.6;
            color: #687a6c;
        }

        .sc-summary-line strong {
            color: #263e2d;
            font-weight: 800;
            text-align: right;
        }

        .sc-summary-divider {
            height: 1px;
            background: #e5eee7;
            margin: 22px 0;
        }

        .sc-summary-total {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .sc-summary-total > span {
            font-size: 12px;
            color: #283d2e;
            font-weight: 800;
        }

        .sc-summary-total strong {
            font-size: clamp(23px, 2.3vw, 31px);
            line-height: 1.2;
            letter-spacing: -.7px;
            color: #245c42;
        }

        .sc-summary-caption {
            text-align: right;
            color: #879688;
            font-size: 10px;
            line-height: 1.7;
            margin: 8px 0 20px;
        }

        /* BUTTONS */

        .sc-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            min-height: 44px;
            padding: 12px 16px;
            border: 0;
            border-radius: 999px;
            text-decoration: none;
            font-size: 11px;
            font-weight: 800;
            transition: .2s;
        }

        .sc-btn-primary {
            background: #245c42;
            color: #fff;
            box-shadow: 0 5px 14px rgba(4,68,44,.14);
        }

        .sc-btn-primary:hover {
            background: #04442c;
            color: #fff;
            transform: translateY(-1px);
        }

        .sc-btn-secondary {
            background: #e8f5eb;
            color: #395d45;
        }

        .sc-btn-secondary:hover {
            background: #d7ebdc;
            color: #244c35;
        }

        .sc-btn-disabled {
            opacity: .45;
            cursor: not-allowed;
        }

        .sc-summary-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* INFO PEMBELIAN */

        .sc-info-card {
            padding: 22px;
            background: #e9f6ec;
        }

        .sc-info-card h3 {
            margin: 0 0 18px;
            font-size: 13px;
            font-weight: 800;
            color: #2b6544;
        }

        .sc-info-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .sc-info-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .sc-info-row > i {
            color: #3d7651;
            font-size: 15px;
            margin-top: 2px;
        }

        .sc-info-row p {
            font-size: 11px;
            line-height: 1.7;
            margin: 0;
            color: #667969;
        }

        .sc-info-row strong {
            color: #365641;
        }

        /* NOTICE AND EMPTY */

        .sc-notice {
            padding: 14px 17px;
            border-radius: 13px;
            background: #e9f3fc;
            border: 1px solid #d1e5f7;
            color: #366582;
            font-size: 12px;
            line-height: 1.7;
        }

        .sc-notice.error {
            background: #fff0ee;
            border-color: #f1d0ca;
            color: #a13e32;
        }

        .sc-notice.warning {
            background: #fff7e4;
            border-color: #f0dfb8;
            color: #866326;
        }

        .sc-empty {
            padding: 65px 22px;
            border-radius: 20px;
            border: 1px solid #e0ebe2;
            background: #fff;
            text-align: center;
        }

        .sc-empty-icon {
            display: grid;
            place-items: center;
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #e4f2e8;
            color: #2e7650;
            font-size: 33px;
        }

        .sc-empty h2 {
            font-size: 23px;
            color: #24543a;
            margin: 0 0 10px;
        }

        .sc-empty p {
            color: #839486;
            font-size: 12px;
            line-height: 1.8;
            margin-bottom: 22px;
        }

        /* RESPONSIVE */

        @media (max-width: 1120px) {
            .sc-layout {
                grid-template-columns: minmax(0, 1.5fr) minmax(270px, .85fr);
                gap: 16px;
            }

            .sc-seller-card {
                padding: 17px;
            }

            .sc-product {
                flex-wrap: wrap;
            }

            .sc-product-actions {
                flex: 1 1 100%;
                padding-left: 32px;
            }
        }

        @media (max-width: 870px) {
            .sc-layout {
                grid-template-columns: 1fr;
            }

            .sc-right {
                position: static;
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                align-items: start;
            }
        }

        @media (max-width: 620px) {
            .sc-container {
                width: 93%;
                padding-top: 18px;
            }

            .sc-heading h1 {
                font-size: 26px;
            }

            .sc-mini-stats {
                border-radius: 15px;
            }

            .sc-toolbar {
                padding: 15px;
            }

            .sc-guarantee {
                display: none;
            }

            .sc-seller-card {
                padding: 14px;
            }

            .sc-product {
                align-items: flex-start;
            }

            .sc-product-main {
                gap: 9px;
            }

            .sc-product-photo {
                flex-basis: 64px;
                width: 64px;
                height: 64px;
                font-size: 27px;
            }

            .sc-product-name {
                font-size: 11px;
            }

            .sc-product-actions {
                padding-left: 0;
                gap: 10px;
                justify-content: space-between;
            }

            .sc-item-total {
                min-width: 90px;
            }

            .sc-item-total strong {
                font-size: 14px;
            }

            .sc-right {
                display: flex;
            }
        }
    </style>
</head>

<body class="tm-cart-redesign">

@include('partials.navbar')

@php
    /*
     * Keranjang berasal dari CartController dan MySQL.
     *
     * Product diload sekali untuk mendapatkan foto,
     * kategori, lokasi, dan akun penjual.
     *
     * Data harga dan quantity tetap memakai hasil
     * CartController, bukan nilai contoh Stitch.
     */

    $cartData = collect($keranjang ?? []);

    $productModels = \App\Models\Product::with('user')
        ->whereIn('id', $cartData->keys()->all())
        ->get()
        ->keyBy('id');

    $cartRows = $cartData->map(function ($item, $id) use ($productModels) {

        $product = $productModels->get($id);

        $sellerId = $product
            ? $product->user_id
            : null;

        $sellerName = $item['penjual'] ?? (
            $product && $product->user
                ? $product->user->name
                : 'TaniMart'
        );

        $quantity = (int) ($item['jumlah'] ?? 0);
        $stock = (int) ($item['stok'] ?? 0);

        $canBuy = (bool) ($item['bisa_dibeli'] ?? false)
            && $quantity > 0
            && $stock >= $quantity
            && !($product->is_archived ?? false);

        return [
            'id' => $id,
            'name' => $item['nama'] ?? 'Produk Pertanian',
            'price' => (int) ($item['harga'] ?? 0),
            'quantity' => $quantity,
            'stock' => $stock,
            'unit' => $item['satuan'] ?? 'pcs',
            'icon' => $item['icon'] ?? '🌱',
            'seller_name' => $sellerName,
            'seller_id' => $sellerId,
            'seller_key' => $sellerId
                ? 'seller-' . $sellerId
                : 'seller-' . $sellerName,
            'category' => $product->category ?? 'Produk Pertanian',
            'location' => $product->location ?? '',
            'image' => $product->image ?? null,
            'slug' => $product->slug ?? null,
            'can_buy' => $canBuy,
            'subtotal' => (int) ($item['harga'] ?? 0) * $quantity,
        ];
    });

    $sellerGroups = $cartRows->groupBy('seller_key');

    $cartTotalProducts = $cartRows->count();
    $cartTotalQuantity = $cartRows->sum('quantity');
    $cartTotalSellers = $sellerGroups->count();

    $availableRows = $cartRows->filter(
        fn ($row) => $row['can_buy']
    );

    $unavailableCount = $cartRows->count() - $availableRows->count();
@endphp

<main class="sc-container">

    <!-- BREADCRUMB -->

    <nav class="sc-breadcrumb" aria-label="Breadcrumb">

        <a href="{{ url('/') }}">
            <i class="fa-solid fa-house"></i>
            Beranda
        </a>

        <i class="fa-solid fa-chevron-right" style="font-size:9px;"></i>

        <span>Keranjang Belanja</span>

    </nav>

    <!-- JUDUL -->

    <header class="sc-heading">

        <div>

            <div class="sc-heading-title">

                <span>
                    <i class="fa-solid fa-cart-shopping"></i>
                </span>

                <h1>Keranjang Belanja</h1>

            </div>

            <p>
                Periksa produk pilihanmu sebelum melanjutkan
                ke pembayaran di TaniMart.
            </p>

        </div>

        @if($cartRows->isNotEmpty())

            <div class="sc-mini-stats">

                <span>
                    <i class="sc-stat-dot"></i>
                    <strong>{{ $cartTotalProducts }}</strong>
                    Produk
                </span>

                <span class="sc-stat-divider"></span>

                <span>
                    <i class="sc-stat-dot"></i>
                    <strong>{{ $cartTotalSellers }}</strong>
                    Penjual
                </span>

                <span class="sc-stat-divider"></span>

                <span>
                    <i class="sc-stat-dot"></i>
                    <strong>{{ $cartTotalQuantity }}</strong>
                    Total Barang
                </span>

            </div>

        @endif

    </header>

    <!-- NOTIFIKASI -->

    @if(session('success'))

        <div class="sc-notice" style="margin-bottom:18px;">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>

    @endif

    @if(session('error'))

        <div class="sc-notice error" style="margin-bottom:18px;">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>

    @endif

    @if($errors->any())

        <div class="sc-notice error" style="margin-bottom:18px;">
            {{ $errors->first() }}
        </div>

    @endif

    @if($cartRows->isNotEmpty())

        <div class="sc-layout">

            <!-- ====================================
                 KOLOM KIRI
            ===================================== -->

            <section class="sc-left">

                <!-- SELECT ALL -->

                <div class="sc-card sc-toolbar">

                    <div class="sc-toolbar-left">

                        <input
                            class="sc-checkbox"
                            id="cartSelectAll"
                            type="checkbox"
                            aria-label="Pilih semua produk yang tersedia"
                            {{ $availableRows->isNotEmpty() ? 'checked' : 'disabled' }}
                        >

                        <label for="cartSelectAll"
                               class="sc-toolbar-title">

                            Pilih Semua
                            (<span id="selectAllCount">{{ $availableRows->count() }}</span>)

                        </label>

                    </div>

                    <div class="sc-toolbar-right">

                        <span class="sc-guarantee">
                            <i class="fa-solid fa-shield-halved"></i>
                            Belanja Lebih Aman
                        </span>

                        <button
                            type="button"
                            id="deleteSelectedButton"
                            class="sc-delete-selected"
                            {{ $availableRows->isEmpty() ? 'disabled' : '' }}
                        >
                            <i class="fa-regular fa-trash-can"></i>
                            Hapus Terpilih
                        </button>

                    </div>

                </div>

                <!-- WARNING STOK -->

                @if($unavailableCount > 0)

                    <div class="sc-notice warning">

                        <i class="fa-solid fa-triangle-exclamation"></i>

                        Ada {{ $unavailableCount }} produk yang
                        tidak tersedia atau jumlahnya melebihi stok.

                        Silakan kurangi jumlah barang atau hapus
                        produk tersebut sebelum checkout.

                    </div>

                @endif

                <!-- PENGELOMPOKAN PENJUAL -->

                @foreach($sellerGroups as $sellerKey => $sellerItems)

                    @php
                        $firstSellerItem = $sellerItems->first();

                        $sellerName = $firstSellerItem['seller_name'];
                        $sellerId = $firstSellerItem['seller_id'];
                        $sellerLocation = $firstSellerItem['location'];

                        $groupAvailable = $sellerItems->filter(
                            fn ($row) => $row['can_buy']
                        );

                        $sellerInitial = mb_strtoupper(
                            mb_substr($sellerName, 0, 1)
                        );
                    @endphp

                    <article class="sc-card sc-seller-card"
                             data-seller-group="{{ $sellerKey }}">

                        <!-- SELLER HEADER -->

                        <div class="sc-seller-header">

                            <div class="sc-seller-left">

                                <input
                                    type="checkbox"
                                    class="sc-checkbox sc-store-check"
                                    data-store="{{ $sellerKey }}"
                                    aria-label="Pilih produk dari {{ $sellerName }}"
                                    {{ $groupAvailable->isNotEmpty() ? 'checked' : 'disabled' }}
                                >

                                <span class="sc-seller-avatar">
                                    <i class="fa-solid fa-store"></i>
                                </span>

                                <div>

                                    <div class="sc-seller-name">
                                        {{ $sellerName }}
                                    </div>

                                    @if($sellerLocation)

                                        <div class="sc-seller-location">

                                            <i class="fa-solid fa-location-dot"></i>
                                            {{ $sellerLocation }}

                                        </div>

                                    @else

                                        <div class="sc-seller-location">
                                            Penjual TaniMart
                                        </div>

                                    @endif

                                </div>

                            </div>

                            @if($sellerId && (int) $sellerId !== (int) auth()->id())

                                <a
                                    href="{{ route('chat.index', ['user_id' => $sellerId]) }}"
                                    class="sc-chat-btn"
                                >
                                    <i class="fa-regular fa-message"></i>
                                    Chat Penjual
                                </a>

                            @endif

                        </div>

                        <!-- ITEM PER SELLER -->

                        @foreach($sellerItems as $row)

                            <div
                                class="sc-product {{ !$row['can_buy'] ? 'unavailable' : '' }}"
                                data-cart-row
                                data-product="{{ $row['id'] }}"
                                data-seller="{{ $sellerKey }}"
                                data-price="{{ $row['price'] }}"
                                data-quantity="{{ $row['quantity'] }}"
                                data-available="{{ $row['can_buy'] ? '1' : '0' }}"
                            >

                                <!-- CHECKBOX PRODUK -->

                                <input
                                    type="checkbox"
                                    class="sc-checkbox sc-item-check"
                                    data-store="{{ $sellerKey }}"
                                    aria-label="Pilih {{ $row['name'] }}"
                                    {{ $row['can_buy'] ? 'checked' : 'disabled' }}
                                >

                                <!-- FOTO DAN INFORMASI -->

                                <div class="sc-product-main">

                                    <div class="sc-product-photo">

                                        @if($row['image'])

                                            <img
                                                src="{{ asset($row['image']) }}"
                                                alt="{{ $row['name'] }}"
                                                loading="lazy"
                                            >

                                        @else

                                            <span>{{ $row['icon'] }}</span>

                                        @endif

                                    </div>

                                    <div class="sc-product-info">

                                        @if($row['slug'])

                                            <a
                                                href="{{ route('products.show', $row['slug']) }}"
                                                class="sc-product-name"
                                            >
                                                {{ $row['name'] }}
                                            </a>

                                        @else

                                            <span class="sc-product-name">
                                                {{ $row['name'] }}
                                            </span>

                                        @endif

                                        <div class="sc-product-category">
                                            {{ $row['category'] }}
                                        </div>

                                        <div class="sc-product-price">

                                            Rp {{ number_format($row['price'], 0, ',', '.') }}

                                            <small>
                                                / {{ $row['unit'] }}
                                            </small>

                                        </div>

                                        @if($row['can_buy'])

                                            <span class="sc-stock-label">

                                                <i class="fa-solid fa-circle"
                                                   style="font-size:6px;"></i>

                                                Stok Tersedia:
                                                {{ $row['stock'] }}
                                                {{ $row['unit'] }}

                                            </span>

                                        @else

                                            <span class="sc-stock-label problem">

                                                <i class="fa-solid fa-triangle-exclamation"></i>

                                                {{ $row['stock'] <= 0
                                                    ? 'Stok Habis / Tidak Tersedia'
                                                    : 'Tidak Dapat Dibeli Saat Ini' }}

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                <!-- JUMLAH & SUBTOTAL -->

                                <div class="sc-product-actions">

                                    <div class="sc-quantity">

                                        <!-- KURANG -->

                                        <form
                                            action="{{ route('cart.update', ['produk' => $row['id']]) }}"
                                            method="POST"
                                        >
                                            @csrf

                                            <input
                                                type="hidden"
                                                name="aksi"
                                                value="kurang"
                                            >

                                            <button
                                                type="submit"
                                                class="sc-qty-btn"
                                                title="Kurangi jumlah"
                                                aria-label="Kurangi jumlah {{ $row['name'] }}"
                                            >
                                                <i class="fa-solid fa-minus"></i>
                                            </button>

                                        </form>

                                        <span class="sc-qty-number">
                                            {{ $row['quantity'] }}
                                        </span>

                                        <!-- TAMBAH -->

                                        <form
                                            action="{{ route('cart.update', ['produk' => $row['id']]) }}"
                                            method="POST"
                                        >
                                            @csrf

                                            <input
                                                type="hidden"
                                                name="aksi"
                                                value="tambah"
                                            >

                                            <button
                                                type="submit"
                                                class="sc-qty-btn"
                                                title="Tambah jumlah"
                                                aria-label="Tambah jumlah {{ $row['name'] }}"
                                                {{ (!$row['can_buy'] || $row['quantity'] >= $row['stock']) ? 'disabled' : '' }}
                                            >
                                                <i class="fa-solid fa-plus"></i>
                                            </button>

                                        </form>

                                    </div>

                                    <div class="sc-item-total">

                                        <small>Subtotal</small>

                                        <strong>
                                            Rp {{ number_format($row['subtotal'], 0, ',', '.') }}
                                        </strong>

                                    </div>

                                    <!-- HAPUS SATU PRODUK -->

                                    <form
                                        class="sc-remove-form"
                                        action="{{ route('cart.remove', ['produk' => $row['id']]) }}"
                                        method="POST"
                                        data-remove-form
                                        onsubmit="return confirm('Hapus produk ini dari keranjang?');"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="sc-remove"
                                            title="Hapus produk"
                                            aria-label="Hapus {{ $row['name'] }}"
                                        >
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>

                                    </form>

                                </div>

                            </div>

                        @endforeach

                    </article>

                @endforeach

            </section>

            <!-- ====================================
                 KOLOM KANAN
            ===================================== -->

            <aside class="sc-right">

                <!-- RINGKASAN BELANJA -->

                <div class="sc-card sc-summary">

                    <div class="sc-summary-head">

                        <h2>Ringkasan Belanja</h2>

                        <span class="sc-summary-badge"
                              id="summarySelectedBadge">

                            {{ $availableRows->count() }}
                            Terpilih

                        </span>

                    </div>

                    <div class="sc-summary-line">

                        <span>Total Produk Terpilih</span>

                        <strong id="summaryProductCount">
                            {{ $availableRows->count() }}
                            Produk
                        </strong>

                    </div>

                    <div class="sc-summary-line">

                        <span>Total Kuantitas Barang</span>

                        <strong id="summaryQuantity">
                            {{ $availableRows->sum('quantity') }}
                            Barang
                        </strong>

                    </div>

                    <div class="sc-summary-line">

                        <span>Subtotal Harga</span>

                        <strong id="summarySubtotal">
                            Rp {{ number_format($availableRows->sum('subtotal'), 0, ',', '.') }}
                        </strong>

                    </div>

                    <div class="sc-summary-line">

                        <span>
                            <i class="fa-solid fa-truck"></i>
                            Biaya Pengiriman
                        </span>

                        <strong>
                            Sesuai ketentuan checkout
                        </strong>

                    </div>

                    <div class="sc-summary-divider"></div>

                    <div class="sc-summary-total">

                        <span>Subtotal Terpilih</span>

                        <strong id="summaryTotal">
                            Rp {{ number_format($availableRows->sum('subtotal'), 0, ',', '.') }}
                        </strong>

                    </div>

                    <p class="sc-summary-caption">
                        Total pesanan akhir ditetapkan saat checkout.
                    </p>

                    <!-- INFORMASI KOMPATIBILITAS CHECKOUT -->

                    <div
                        class="sc-notice warning"
                        id="checkoutSelectionWarning"
                        style="margin-bottom:15px;"
                        hidden
                    >
                        Pilihan produk belum mencakup seluruh keranjang.
                        Checkout TaniMart saat ini memproses semua
                        produk yang tersimpan.
                    </div>

                    <div class="sc-summary-actions">

                        <a
                            href="{{ route('checkout') }}"
                            class="sc-btn sc-btn-primary"
                            id="checkoutButton"
                        >
                            Lanjut ke Checkout

                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                        <a
                            href="{{ url('/#produk') }}"
                            class="sc-btn sc-btn-secondary"
                        >
                            Lanjut Belanja Produk Lain
                        </a>

                    </div>

                </div>

                <!-- INFORMASI PENTING -->

                <div class="sc-card sc-info-card">

                    <h3>
                        <i class="fa-solid fa-shield-halved"></i>
                        Belanja di TaniMart
                    </h3>

                    <div class="sc-info-list">

                        <div class="sc-info-row">

                            <i class="fa-solid fa-circle-check"></i>

                            <p>
                                <strong>Informasi Stok Produk:</strong>
                                Jumlah stok diperiksa kembali ketika
                                transaksi dilakukan.
                            </p>

                        </div>

                        <div class="sc-info-row">

                            <i class="fa-solid fa-truck-fast"></i>

                            <p>
                                <strong>Informasi Pengiriman:</strong>
                                Hubungi penjual apabila membutuhkan
                                informasi pengantaran dan ketersediaan produk.
                            </p>

                        </div>

                        <div class="sc-info-row">

                            <i class="fa-solid fa-robot"></i>

                            <p>
                                <strong>Konsultasi TaniAI:</strong>
                                Tanyakan informasi perawatan tanaman,
                                pupuk, atau kebutuhan budidaya.
                            </p>

                        </div>

                    </div>

                    <a
                        href="{{ route('konsultasi') }}"
                        class="sc-btn sc-btn-secondary"
                        style="margin-top:19px;"
                    >
                        <i class="fa-solid fa-comments"></i>
                        Tanya AI Pertanian
                    </a>

                </div>

            </aside>

        </div>

    @else

        <!-- KERANJANG KOSONG -->

        <section class="sc-empty">

            <div class="sc-empty-icon">
                <i class="fa-solid fa-basket-shopping"></i>
            </div>

            <h2>Keranjangmu Masih Kosong</h2>

            <p>
                Belum ada produk di keranjang belanjamu.
                Yuk, cari benih, bibit, pupuk, atau
                perlengkapan pertanian yang kamu butuhkan!
            </p>

            <a
                href="{{ url('/#produk') }}"
                class="sc-btn sc-btn-primary"
                style="width:auto;min-width:180px;"
            >
                <i class="fa-solid fa-seedling"></i>
                Jelajahi Produk
            </a>

        </section>

    @endif

</main>

@include('partials.footer')

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // DATA DARI DOM BERDASARKAN KERANJANG MYSQL
    // ==========================================

    const rows = Array.from(
        document.querySelectorAll('[data-cart-row]')
    );

    if (rows.length === 0) {
        return;
    }

    const allCheckbox = document.getElementById('cartSelectAll');

    const itemCheckboxes = Array.from(
        document.querySelectorAll('.sc-item-check')
    );

    const storeCheckboxes = Array.from(
        document.querySelectorAll('.sc-store-check')
    );

    const deleteSelectedButton =
        document.getElementById('deleteSelectedButton');

    const checkoutButton =
        document.getElementById('checkoutButton');

    const warning =
        document.getElementById('checkoutSelectionWarning');

    const formatter = new Intl.NumberFormat('id-ID', {
        maximumFractionDigits: 0
    });

    function rupiah(value) {
        return 'Rp ' + formatter.format(value);
    }

    function eligibleCheckboxes() {

        return itemCheckboxes.filter(function (checkbox) {
            return !checkbox.disabled;
        });

    }

    function selectedRows() {

        return rows.filter(function (row) {

            const checkbox = row.querySelector('.sc-item-check');

            return checkbox && checkbox.checked;

        });

    }

    // ==========================================
    // HITUNG RINGKASAN
    // ==========================================

    function updateSummary() {

        const selected = selectedRows();

        let subtotal = 0;
        let quantity = 0;

        selected.forEach(function (row) {

            const price = Number(row.dataset.price) || 0;
            const qty = Number(row.dataset.quantity) || 0;

            subtotal += price * qty;
            quantity += qty;

        });

        const count = selected.length;

        document.getElementById(
            'summarySelectedBadge'
        ).textContent = count + ' Terpilih';

        document.getElementById(
            'summaryProductCount'
        ).textContent = count + ' Produk';

        document.getElementById(
            'summaryQuantity'
        ).textContent = quantity + ' Barang';

        document.getElementById(
            'summarySubtotal'
        ).textContent = rupiah(subtotal);

        document.getElementById(
            'summaryTotal'
        ).textContent = rupiah(subtotal);

        document.getElementById(
            'selectAllCount'
        ).textContent = count;

        const eligible = eligibleCheckboxes();

        const checkedCount = eligible.filter(function (item) {
            return item.checked;
        }).length;

        // Sinkronisasi checkbox Pilih Semua.
        allCheckbox.checked =
            eligible.length > 0 &&
            checkedCount === eligible.length;

        allCheckbox.indeterminate =
            checkedCount > 0 &&
            checkedCount < eligible.length;

        // Sinkronisasi checkbox masing-masing penjual.
        storeCheckboxes.forEach(function (storeCheckbox) {

            const storeKey = storeCheckbox.dataset.store;

            const storeItems = eligible.filter(function (item) {
                return item.dataset.store === storeKey;
            });

            const storeChecked = storeItems.filter(function (item) {
                return item.checked;
            }).length;

            storeCheckbox.checked =
                storeItems.length > 0 &&
                storeChecked === storeItems.length;

            storeCheckbox.indeterminate =
                storeChecked > 0 &&
                storeChecked < storeItems.length;

        });

        // Hapus Terpilih aktif jika ada pilihan.
        deleteSelectedButton.disabled = count === 0;

        /*
         * Checkout backend sekarang masih memproses
         * seluruh isi keranjang database.
         *
         * Karena itu, jangan membiarkan pengguna
         * checkout sebagian produk tanpa dukungan
         * backend yang sesuai.
         */

        const allItemsSelected =
            rows.length === count;

        const hasUnavailableItems =
            rows.some(function (row) {
                return row.dataset.available !== '1';
            });

        const canCheckout =
            count > 0 &&
            allItemsSelected &&
            !hasUnavailableItems;

        checkoutButton.dataset.canCheckout =
            canCheckout ? '1' : '0';

        checkoutButton.classList.toggle(
            'sc-btn-disabled',
            !canCheckout
        );

        checkoutButton.setAttribute(
            'aria-disabled',
            canCheckout ? 'false' : 'true'
        );

        warning.hidden = canCheckout;

    }

    // ==========================================
    // PILIH SEMUA
    // ==========================================

    allCheckbox.addEventListener('change', function () {

        const checked = allCheckbox.checked;

        eligibleCheckboxes().forEach(function (checkbox) {
            checkbox.checked = checked;
        });

        updateSummary();

    });

    // ==========================================
    // PILIH PER TOKO
    // ==========================================

    storeCheckboxes.forEach(function (storeCheckbox) {

        storeCheckbox.addEventListener('change', function () {

            const storeKey = storeCheckbox.dataset.store;
            const checked = storeCheckbox.checked;

            itemCheckboxes.forEach(function (checkbox) {

                if (
                    checkbox.dataset.store === storeKey &&
                    !checkbox.disabled
                ) {
                    checkbox.checked = checked;
                }

            });

            updateSummary();

        });

    });

    // ==========================================
    // PILIH PER PRODUK
    // ==========================================

    itemCheckboxes.forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {
            updateSummary();
        });

    });

    // ==========================================
    // HAPUS PRODUK TERPILIH DARI DATABASE
    // Menggunakan endpoint hapus keranjang lama.
    // ==========================================

    deleteSelectedButton.addEventListener(
        'click',
        async function () {

            const selected = selectedRows();

            if (selected.length === 0) {
                return;
            }

            const confirmed = confirm(
                'Hapus ' + selected.length +
                ' produk yang dipilih dari keranjang?'
            );

            if (!confirmed) {
                return;
            }

            deleteSelectedButton.disabled = true;

            const originalText =
                deleteSelectedButton.innerHTML;

            deleteSelectedButton.innerHTML =
                '<i class="fa-solid fa-spinner fa-spin"></i> Menghapus...';

            try {

                /*
                 * Gunakan form hapus milik setiap item.
                 * Request diproses oleh CartController@remove.
                 */

                let failedCount = 0;

                for (const row of selected) {

                    const form = row.querySelector(
                        '[data-remove-form]'
                    );

                    if (!form) {
                        failedCount++;
                        continue;
                    }

                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        credentials: 'same-origin',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!response.ok) {
                        failedCount++;
                    }

                }

                if (failedCount > 0) {

                    alert(
                        'Sebagian produk gagal dihapus. ' +
                        'Halaman akan dimuat ulang.'
                    );

                }

                window.location.reload();

            } catch (error) {

                console.error(
                    'Gagal menghapus produk terpilih:',
                    error
                );

                alert(
                    'Gagal menghapus produk. ' +
                    'Periksa koneksi atau coba kembali.'
                );

                deleteSelectedButton.disabled = false;
                deleteSelectedButton.innerHTML = originalText;

            }

        }
    );

    // ==========================================
    // PENGAMAN CHECKOUT
    // ==========================================

    checkoutButton.addEventListener('click', function (event) {

        if (checkoutButton.dataset.canCheckout !== '1') {

            event.preventDefault();

            alert(
                'Checkout TaniMart saat ini memproses seluruh ' +
                'keranjang. Pilih semua produk dan pastikan ' +
                'semuanya tersedia sebelum melanjutkan. ' +
                'Produk yang tidak ingin dibeli dapat ' +
                'dihapus dari keranjang terlebih dahulu.'
            );

        }

    });

    // ==========================================
    // INISIALISASI PERTAMA
    // ==========================================

    updateSummary();

});
</script>

</body>
</html>
