
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru | TaniMart</title>
    <meta name="theme-color" content="#04442c">
    <meta name="description" content="Tambahkan produk pertanian untuk dijual di TaniMart.">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ===============================================
           TANIMART - CREATE PRODUCT STITCH DESIGN
           Tidak mengubah CSS global halaman lain.
        =============================================== */

        body.tm-create-stitch {
            --cp-green: #04442c;
            --cp-green-2: #245c42;
            --cp-bg: #effdf1;
            --cp-border: #dce9df;
            --cp-soft: #e9f7ec;
            --cp-text: #263c2d;
            --cp-muted: #718476;

            margin: 0;
            color: var(--cp-text);
            background: var(--cp-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        .tm-create-stitch *,
        .tm-create-stitch *::before,
        .tm-create-stitch *::after {
            box-sizing: border-box;
        }

        .tm-create-stitch [hidden] {
            display: none !important;
        }

        .tm-create-stitch button,
        .tm-create-stitch input,
        .tm-create-stitch select,
        .tm-create-stitch textarea {
            font-family: inherit;
        }

        .tm-create-stitch button {
            cursor: pointer;
        }

        .tm-create-stitch .tm-navbar-wrapper {
            background: #effdf1 !important;
        }

        /* MAIN WRAPPER */

        .cp-page {
            width: min(94%, 1390px);
            margin: 0 auto;
            padding: 29px 0 90px;
        }

        .cp-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 9px;
            color: #748578;
            font-size: 11px;
            margin-bottom: 19px;
        }

        .cp-breadcrumb a {
            color: #527260;
            text-decoration: none;
        }

        .cp-breadcrumb a:hover {
            color: var(--cp-green);
        }

        .cp-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            padding-bottom: 28px;
            border-bottom: 1px solid var(--cp-border);
        }

        .cp-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border-radius: 999px;
            background: #d8eedb;
            color: #38654b;
            padding: 7px 11px;
            font-size: 10px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .cp-heading h1 {
            color: #193e2b;
            font-size: clamp(25px, 3vw, 35px);
            line-height: 1.3;
            letter-spacing: -.7px;
            margin: 0 0 8px;
            font-weight: 800;
        }

        .cp-heading h1 i {
            color: #35815b;
            font-size: 20px;
            vertical-align: middle;
        }

        .cp-heading p {
            max-width: 690px;
            font-size: 12px;
            color: var(--cp-muted);
            line-height: 1.8;
            margin: 0;
        }

        .cp-seller-note {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            border: 1px solid #dfebe2;
            padding: 13px 16px;
            border-radius: 15px;
        }

        .cp-seller-note i {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 11px;
            background: #e7f4e9;
            color: #245d40;
        }

        .cp-seller-note strong {
            display: block;
            font-size: 11px;
        }

        .cp-seller-note small {
            color: #748978;
            font-size: 10px;
        }

        /* GRID */

        .cp-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.7fr) minmax(280px, .85fr);
            align-items: start;
            gap: 25px;
            margin-top: 27px;
        }

        .cp-form-column,
        .cp-side {
            display: flex;
            flex-direction: column;
            gap: 21px;
            min-width: 0;
        }

        .cp-side {
            position: sticky;
            top: 90px;
        }

        .cp-card {
            padding: 25px;
            border-radius: 18px;
            border: 1px solid #e0ebe2;
            background: #fff;
            box-shadow: 0 5px 20px rgba(3, 61, 36, .035);
        }

        .cp-card-title {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 18px;
            margin-bottom: 20px;
            border-bottom: 1px solid #ebf1eb;
        }

        .cp-card-icon {
            width: 37px;
            height: 37px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            background: #e7f3e9;
            color: #2a6244;
            border-radius: 11px;
            font-size: 16px;
        }

        .cp-card-title h2 {
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 5px;
            color: #223e2d;
        }

        .cp-card-title p {
            font-size: 11px;
            line-height: 1.7;
            color: #829385;
            margin: 0;
        }

        /* FORM FIELD */

        .cp-field {
            margin-bottom: 19px;
            min-width: 0;
        }

        .cp-field:last-child {
            margin-bottom: 0;
        }

        .cp-field-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 9px;
        }

        .cp-label {
            display: block;
            font-size: 12px;
            font-weight: 800;
            color: #2b4434;
        }

        .cp-required {
            color: #ce3939;
        }

        .cp-counter {
            color: #8a998c;
            font-size: 10px;
        }

        .cp-input,
        .cp-select,
        .cp-textarea {
            display: block;
            width: 100%;
            min-width: 0;
            padding: 13px 15px;
            border: 1px solid #cddbd0;
            border-radius: 11px;
            outline: 0;
            background: #fff;
            color: #2c4333;
            font-size: 12px;
            line-height: 1.6;
            transition: .2s;
        }

        .cp-input,
        .cp-select {
            min-height: 47px;
        }

        .cp-textarea {
            resize: vertical;
            min-height: 122px;
        }

        .cp-input:focus,
        .cp-select:focus,
        .cp-textarea:focus {
            border-color: #438963;
            box-shadow: 0 0 0 3px rgba(65, 142, 94, .1);
        }

        .cp-input::placeholder,
        .cp-textarea::placeholder {
            color: #9ba99d;
        }

        .cp-help {
            display: block;
            font-size: 10px;
            line-height: 1.7;
            color: #859588;
            margin-top: 7px;
        }

        .cp-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
        }

        .cp-row-three {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .cp-input-wrap {
            position: relative;
        }

        .cp-input-wrap .cp-prefix {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #40634c;
            font-size: 12px;
            font-weight: 800;
        }

        .cp-input-wrap.has-prefix .cp-input {
            padding-left: 43px;
        }

        .cp-suggestions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 7px;
            margin-top: 10px;
        }

        .cp-suggestions span {
            color: #829284;
            font-size: 10px;
        }

        .cp-tip-chip {
            padding: 6px 10px;
            background: #e6f3e8;
            color: #466e51;
            border: 0;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
        }

        .cp-tip-chip:hover {
            background: #d3e9d8;
        }

        /* STOCK AND PRICE */

        .cp-price-note {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-top: 5px;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #d3ead6;
            background: #edf9ef;
        }

        .cp-price-note i {
            color: #33774e;
            font-size: 19px;
        }

        .cp-price-note strong {
            display: block;
            color: #2c563b;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .cp-price-note p {
            color: #7a8e7c;
            font-size: 10px;
            line-height: 1.7;
            margin: 0;
        }

        /* ICON CHOOSER */

        .cp-icon-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 10px;
        }

        .cp-icon-option {
            min-width: 0;
            min-height: 91px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 7px;
            position: relative;
            background: #fff;
            border: 1px solid #d6e2d8;
            border-radius: 13px;
            padding: 10px 5px;
            transition: .2s;
        }

        .cp-icon-option:hover {
            transform: translateY(-2px);
            border-color: #6fa983;
            background: #f5fbf5;
        }

        .cp-icon-option.selected {
            border: 2px solid #245c42;
            background: #e0f2e1;
        }

        .cp-emoji {
            font-size: 26px;
            line-height: 1.3;
        }

        .cp-icon-option small {
            display: block;
            color: #516a56;
            text-align: center;
            font-size: 9px;
            line-height: 1.5;
        }

        .cp-icon-option.selected small {
            color: #164d31;
            font-weight: 800;
        }

        .cp-icon-check {
            display: none;
            position: absolute;
            right: 7px;
            top: 7px;
            color: #0b653b;
            font-size: 13px;
        }

        .cp-icon-option.selected .cp-icon-check {
            display: block;
        }

        .cp-icon-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
            padding-top: 14px;
            border-top: 1px solid #edf2ed;
            font-size: 11px;
        }

        .cp-icon-summary strong {
            color: #245c42;
        }

        .cp-icon-summary small {
            color: #89998c;
        }

        /* FILE UPLOAD */

        .cp-upload-zone {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 170px;
            padding: 24px;
            border: 2px dashed #a7cfb3;
            border-radius: 15px;
            background: #f4fbf6;
            text-align: center;
            cursor: pointer;
            transition: .2s;
        }

        .cp-upload-zone:hover,
        .cp-upload-zone.dragging {
            background: #e4f6e9;
            border-color: #367f56;
        }

        .cp-upload-circle {
            display: grid;
            place-items: center;
            width: 49px;
            height: 49px;
            margin-bottom: 12px;
            background: #e1f0e5;
            color: #266948;
            border-radius: 50%;
            font-size: 20px;
        }

        .cp-upload-zone strong {
            font-size: 12px;
            color: #315840;
            line-height: 1.7;
        }

        .cp-upload-zone small {
            margin-top: 7px;
            font-size: 10px;
            color: #8c9b8e;
            line-height: 1.7;
        }

        .cp-upload-preview {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-top: 16px;
            padding: 12px;
            background: #f1f9f3;
            border: 1px solid #dcebe0;
            border-radius: 13px;
        }

        .cp-upload-preview img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            flex-shrink: 0;
        }

        .cp-upload-preview p {
            margin: 0;
            font-size: 11px;
            color: #436149;
            overflow-wrap: anywhere;
        }

        .cp-remove-photo {
            margin-left: auto;
            padding: 9px;
            border-radius: 50%;
            border: 0;
            background: #ffe9e6;
            color: #b33d36;
        }

        /* FORM ACTIONS */

        .cp-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
            padding: 17px;
            border: 1px solid #dfebe2;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 8px 25px rgba(0, 45, 27, .06);
        }

        .cp-back {
            color: #728576;
            text-decoration: none;
            font-size: 11px;
            font-weight: 700;
        }

        .cp-back:hover {
            color: #bf4a40;
        }

        .cp-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 43px;
            padding: 11px 22px;
            border: 0;
            border-radius: 999px;
            background: #04442c;
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            box-shadow: 0 5px 12px rgba(4,68,44,.15);
        }

        .cp-submit:hover {
            background: #126344;
            transform: translateY(-1px);
        }

        .cp-submit:disabled {
            opacity: .6;
            cursor: wait;
        }

        /* RIGHT SIDE PREVIEW */

        .cp-preview-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .cp-preview-head h3 {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-size: 13px;
            color: #244632;
        }

        .cp-preview-tag {
            font-size: 9px;
            font-weight: 800;
            background: #d8efd9;
            color: #3a7852;
            padding: 5px 8px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .cp-product-preview {
            border: 1px solid #e0ebe1;
            border-radius: 15px;
            overflow: hidden;
        }

        .cp-preview-image {
            position: relative;
            height: 225px;
            background: linear-gradient(145deg, #dcefdc, #f4faf1);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .cp-preview-image > img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cp-preview-image > .cp-placeholder {
            font-size: 64px;
            opacity: .85;
        }

        .cp-preview-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            max-width: 80%;
            padding: 7px 10px;
            border-radius: 999px;
            background: #04442c;
            color: #fff;
            font-weight: 800;
            font-size: 10px;
        }

        .cp-preview-content {
            padding: 18px;
        }

        .cp-preview-category {
            color: #718c78;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        .cp-preview-name {
            color: #243d2b;
            font-size: 16px;
            font-weight: 800;
            line-height: 1.55;
            margin: 0 0 12px;
            overflow-wrap: anywhere;
        }

        .cp-preview-price {
            color: #04442c;
            font-size: 23px;
            font-weight: 800;
            line-height: 1.4;
        }

        .cp-preview-unit {
            font-size: 11px;
            font-weight: 500;
            color: #899b8b;
        }

        .cp-preview-meta {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
            padding-top: 12px;
            border-top: 1px solid #e8f0e9;
            color: #66816d;
            font-size: 10px;
        }

        .cp-preview-location {
            display: flex;
            align-items: flex-start;
            gap: 7px;
            margin-top: 12px;
            color: #86958a;
            font-size: 10px;
            line-height: 1.6;
        }

        .cp-preview-cart {
            width: 100%;
            margin-top: 16px;
            padding: 11px;
            border: 0;
            border-radius: 999px;
            background: #d8eed9;
            color: #46724f;
            font-size: 11px;
            font-weight: 800;
            cursor: not-allowed !important;
        }

        .cp-preview-caption {
            text-align: center;
            font-size: 10px;
            color: #899a8b;
            line-height: 1.7;
            margin: 14px 0 0;
        }

        /* SELLER TIPS */

        .cp-tips {
            background: #e7f5e9;
        }

        .cp-tips h3 {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #2a4b36;
            font-size: 14px;
            margin: 0 0 6px;
        }

        .cp-tips h3 i {
            color: #aa801d;
            font-size: 18px;
        }

        .cp-tips > p {
            margin: 0 0 17px;
            color: #728a78;
            font-size: 10px;
        }

        .cp-tips-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .cp-tip-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .cp-tip-num {
            flex: 0 0 23px;
            height: 23px;
            border-radius: 50%;
            background: #fff;
            color: #2c6a43;
            display: grid;
            place-items: center;
            font-size: 11px;
            font-weight: 800;
        }

        .cp-tip-row p {
            color: #657d6b;
            line-height: 1.8;
            font-size: 11px;
            margin: 0;
        }

        .cp-tip-row strong {
            color: #34513c;
        }

        .cp-ai-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            border-top: 1px solid #d1e7d5;
            margin-top: 19px;
            padding-top: 15px;
            font-size: 11px;
            color: #698273;
        }

        .cp-ai-link a {
            color: #125f40;
            text-decoration: none;
            font-weight: 800;
        }

        /* VALIDATION */

        .cp-error-box {
            padding: 16px;
            background: #fff0ee;
            border: 1px solid #f4cfcc;
            border-radius: 13px;
            color: #9b3833;
            margin-top: 20px;
            font-size: 12px;
        }

        .cp-error-box ul {
            margin: 9px 0 0;
            padding-left: 19px;
        }

        .cp-field-error {
            display: block;
            color: #bb3d35;
            font-size: 11px;
            margin-top: 7px;
        }

        /* RESPONSIVE */

        @media (max-width: 1110px) {
            .cp-layout {
                grid-template-columns: minmax(0, 1.45fr) minmax(260px, .85fr);
                gap: 17px;
            }

            .cp-card {
                padding: 19px;
            }

            .cp-icon-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        @media (max-width: 850px) {
            .cp-layout {
                grid-template-columns: 1fr;
            }

            .cp-side {
                position: static;
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                align-items: start;
            }

            .cp-icon-grid {
                grid-template-columns: repeat(6, minmax(0, 1fr));
            }
        }

        @media (max-width: 620px) {
            .cp-page {
                width: 93%;
                padding-top: 18px;
            }

            .cp-heading h1 {
                font-size: 25px;
            }

            .cp-row,
            .cp-row-three {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .cp-card {
                padding: 17px;
            }

            .cp-icon-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .cp-side {
                display: flex;
            }

            .cp-preview-image {
                height: 210px;
            }

            .cp-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .cp-submit {
                width: 100%;
            }
        }
    </style>
</head>

<body class="tm-create-stitch">

@include('partials.navbar')

@php
    /*
     * Menggunakan kategori asli database TaniMart.
     * Tidak memakai kategori contoh dari Stitch.
     */
    $productCategories = \App\Models\Category::query()
        ->orderBy('name')
        ->get();

    $iconOptions = [
        ['emoji' => '🌱', 'label' => 'Bibit / Tunas'],
        ['emoji' => '🌶️', 'label' => 'Cabai & Pedas'],
        ['emoji' => '🍅', 'label' => 'Tomat & Buah'],
        ['emoji' => '🪴', 'label' => 'Tanaman Hias'],
        ['emoji' => '🍃', 'label' => 'Daun Herbal'],
        ['emoji' => '🌽', 'label' => 'Jagung & Padi'],
        ['emoji' => '🥕', 'label' => 'Wortel & Umbi'],
        ['emoji' => '🥦', 'label' => 'Sayuran Hijau'],
        ['emoji' => '🍓', 'label' => 'Stroberi & Berry'],
        ['emoji' => '🍎', 'label' => 'Buah Tropis'],
        ['emoji' => '🌾', 'label' => 'Biji-bijian'],
        ['emoji' => '📦', 'label' => 'Paket Tani'],
    ];

    $selectedIcon = old('icon', '🌱');
@endphp

<main class="cp-page">

    <!-- BREADCRUMB -->

    <nav class="cp-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ url('/') }}">
            Beranda
        </a>

        <i class="fa-solid fa-chevron-right"></i>

        <a href="{{ route('products.my') }}">
            Jual Produk
        </a>

        <i class="fa-solid fa-chevron-right"></i>

        <strong>Tambah Produk Baru</strong>
    </nav>

    <!-- HEADER -->

    <header class="cp-heading">

        <div>
            <span class="cp-badge">
                <i class="fa-solid fa-seedling"></i>
                Portal Penjual TaniMart
            </span>

            <h1>
                Tambah Produk Baru
                <i class="fa-solid fa-circle-plus"></i>
            </h1>

            <p>
                Jual hasil panen, benih, pupuk, dan perlengkapan
                pertanianmu kepada pembeli melalui TaniMart.
            </p>
        </div>

        <div class="cp-seller-note">
            <i class="fa-solid fa-shop"></i>

            <div>
                <strong>Akun Penjual TaniMart</strong>

                <small>
                    {{ auth()->user()->name ?? 'Pengguna' }}
                </small>
            </div>
        </div>

    </header>

    <!-- VALIDATION ERRORS -->

    @if($errors->any())

        <div class="cp-error-box" role="alert">

            <strong>
                <i class="fa-solid fa-circle-exclamation"></i>
                Produk belum bisa disimpan.
            </strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    @if(session('error'))
        <div class="cp-error-box" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <!-- FORM PRODUK ASLI -->

    <form
        id="createProductForm"
        action="{{ route('products.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <!-- Field tambahan sesuai data TaniMart -->

        <input type="hidden"
               name="category"
               id="categoryName"
               value="{{ old('category', '') }}">

        <input type="hidden"
               name="icon"
               id="selectedIcon"
               value="{{ $selectedIcon }}">

        <input type="hidden"
               name="status"
               value="tersedia">

        <div class="cp-layout">

            <!-- ======================================
                 KOLOM KIRI
            ======================================= -->

            <div class="cp-form-column">

                <!-- INFORMASI DASAR -->

                <section class="cp-card">

                    <div class="cp-card-title">

                        <span class="cp-card-icon">
                            <i class="fa-regular fa-clipboard"></i>
                        </span>

                        <div>
                            <h2>Informasi Dasar Produk</h2>

                            <p>
                                Lengkapi informasi agar produk mudah
                                ditemukan oleh pembeli.
                            </p>
                        </div>

                    </div>

                    <!-- NAMA -->

                    <div class="cp-field">

                        <div class="cp-field-head">

                            <label for="productName"
                                   class="cp-label">
                                Nama Produk Pertanian
                                <span class="cp-required">*</span>
                            </label>

                            <span class="cp-counter" id="nameCounter">
                                0/120
                            </span>

                        </div>

                        <input
                            id="productName"
                            name="name"
                            class="cp-input"
                            type="text"
                            placeholder="Contoh: Benih Cabai Rawit Merah Unggul"
                            value="{{ old('name') }}"
                            minlength="3"
                            maxlength="120"
                            required
                        >

                        <small class="cp-help">
                            <i class="fa-regular fa-circle-info"></i>
                            Gunakan nama spesifik mencakup jenis,
                            varietas, atau ukuran kemasan.
                        </small>

                        @error('name')
                            <span class="cp-field-error">{{ $message }}</span>
                        @enderror

                    </div>

                    <!-- KATEGORI DAN LOKASI -->

                    <div class="cp-row">

                        <div class="cp-field">

                            <div class="cp-field-head">

                                <label for="productCategory"
                                       class="cp-label">
                                    Kategori Produk
                                    <span class="cp-required">*</span>
                                </label>

                            </div>

                            <select
                                name="category_id"
                                id="productCategory"
                                class="cp-select"
                                required
                            >
                                <option value="">
                                    Pilih kategori produk
                                </option>

                                @foreach($productCategories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        data-name="{{ $category->name }}"
                                        {{ (string) old('category_id') === (string) $category->id ? 'selected' : '' }}
                                    >
                                        {{ $category->name }}
                                    </option>

                                @endforeach

                            </select>

                            @if($productCategories->isEmpty())
                                <small class="cp-help">
                                    Belum ada kategori di database.
                                    Kategori perlu disiapkan sebelum
                                    produk diterbitkan.
                                </small>
                            @endif

                            @error('category_id')
                                <span class="cp-field-error">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="cp-field">

                            <div class="cp-field-head">
                                <label for="productLocation"
                                       class="cp-label">
                                    Asal Lokasi / Gudang Kirim
                                    <span class="cp-required">*</span>
                                </label>
                            </div>

                            <input
                                type="text"
                                id="productLocation"
                                name="location"
                                class="cp-input"
                                maxlength="150"
                                required
                                placeholder="Contoh: Denpasar, Bali"
                                value="{{ old('location') }}"
                            >

                            @error('location')
                                <span class="cp-field-error">{{ $message }}</span>
                            @enderror

                        </div>

                    </div>

                    <!-- DESKRIPSI -->

                    <div class="cp-field">

                        <div class="cp-field-head">
                            <label for="productDescription"
                                   class="cp-label">
                                Deskripsi Produk
                                <span class="cp-required">*</span>
                            </label>

                            <span class="cp-counter" id="descCounter">
                                0/1000
                            </span>
                        </div>

                        <textarea
                            id="productDescription"
                            name="description"
                            class="cp-textarea"
                            minlength="10"
                            maxlength="1000"
                            rows="5"
                            required
                            placeholder="Jelaskan kualitas, kegunaan, ukuran, keunggulan, dan cara penggunaan produk..."
                        >{{ old('description') }}</textarea>

                        <div class="cp-suggestions">

                            <span>Saran deskripsi:</span>

                            <button type="button"
                                    class="cp-tip-chip"
                                    data-description-tip="Kondisi dan kualitas produk: ">
                                + Kualitas Produk
                            </button>

                            <button type="button"
                                    class="cp-tip-chip"
                                    data-description-tip="Cara penggunaan atau petunjuk tanam: ">
                                + Petunjuk Penggunaan
                            </button>

                            <button type="button"
                                    class="cp-tip-chip"
                                    data-description-tip="Ukuran, isi bersih, atau jumlah per kemasan: ">
                                + Detail Kemasan
                            </button>

                        </div>

                        @error('description')
                            <span class="cp-field-error">{{ $message }}</span>
                        @enderror

                    </div>

                </section>

                <!-- HARGA DAN STOK -->

                <section class="cp-card">

                    <div class="cp-card-title">

                        <span class="cp-card-icon">
                            <i class="fa-solid fa-money-bill-wave"></i>
                        </span>

                        <div>
                            <h2>Harga dan Persediaan</h2>

                            <p>
                                Tentukan harga jual, stok tersedia,
                                dan satuan produk.
                            </p>
                        </div>

                    </div>

                    <div class="cp-row cp-row-three">

                        <!-- HARGA -->

                        <div class="cp-field">

                            <div class="cp-field-head">
                                <label for="productPrice"
                                       class="cp-label">
                                    Harga Jual
                                    <span class="cp-required">*</span>
                                </label>
                            </div>

                            <div class="cp-input-wrap has-prefix">

                                <span class="cp-prefix">Rp</span>

                                <input
                                    type="number"
                                    id="productPrice"
                                    name="price"
                                    class="cp-input"
                                    min="1"
                                    max="2147483647"
                                    step="1"
                                    placeholder="25000"
                                    value="{{ old('price') }}"
                                    required
                                >

                            </div>

                            <small class="cp-help">
                                Masukkan angka tanpa titik.
                            </small>

                            @error('price')
                                <span class="cp-field-error">{{ $message }}</span>
                            @enderror

                        </div>

                        <!-- STOK -->

                        <div class="cp-field">

                            <div class="cp-field-head">
                                <label for="productStock"
                                       class="cp-label">
                                    Stok Tersedia
                                    <span class="cp-required">*</span>
                                </label>
                            </div>

                            <input
                                type="number"
                                id="productStock"
                                name="stock"
                                class="cp-input"
                                min="0"
                                max="1000000"
                                step="1"
                                value="{{ old('stock', 0) }}"
                                required
                            >

                            <small class="cp-help">
                                Stok 0 berarti habis.
                            </small>

                            @error('stock')
                                <span class="cp-field-error">{{ $message }}</span>
                            @enderror

                        </div>

                        <!-- SATUAN -->

                        <div class="cp-field">

                            <div class="cp-field-head">
                                <label for="productUnit"
                                       class="cp-label">
                                    Satuan Produk
                                    <span class="cp-required">*</span>
                                </label>
                            </div>

                            <select
                                id="productUnit"
                                name="unit"
                                class="cp-select"
                                required
                            >
                                @foreach([
                                    'pcs' => 'Satuan / pcs',
                                    'pack' => 'Kemasan / pack',
                                    'kg' => 'Kilogram / kg',
                                    'gram' => 'Gram',
                                    'liter' => 'Liter',
                                    'botol' => 'Botol',
                                    'karung' => 'Karung / sak',
                                    'polybag' => 'Polybag',
                                    'ikat' => 'Ikat',
                                    'boks' => 'Boks',
                                ] as $unitValue => $unitLabel)

                                    <option
                                        value="{{ $unitValue }}"
                                        {{ old('unit', 'pcs') === $unitValue ? 'selected' : '' }}
                                    >
                                        {{ $unitLabel }}
                                    </option>

                                @endforeach
                            </select>

                            @error('unit')
                                <span class="cp-field-error">{{ $message }}</span>
                            @enderror

                        </div>

                    </div>

                    <div class="cp-price-note">

                        <i class="fa-solid fa-wallet"></i>

                        <div>
                            <strong>
                                Harga Jual Per Item:
                                <span id="priceSummary">Rp 0</span>
                            </strong>

                            <p>
                                Harga ini akan ditampilkan kepada pembeli.
                                Penghasilan bersih bergantung pada ketentuan
                                transaksi dan biaya yang berlaku.
                            </p>
                        </div>

                    </div>

                </section>

                <!-- PILIH IKON -->

                <section class="cp-card">

                    <div class="cp-card-title">

                        <span class="cp-card-icon">
                            <i class="fa-solid fa-icons"></i>
                        </span>

                        <div>
                            <h2>Pilih Ikon Representasi</h2>

                            <p>
                                Ikon membantu menampilkan gambaran
                                produk ketika tidak ada foto.
                            </p>
                        </div>

                    </div>

                    <div class="cp-icon-grid" id="iconGrid">

                        @foreach($iconOptions as $option)

                            <button
                                type="button"
                                class="cp-icon-option {{ $selectedIcon === $option['emoji'] ? 'selected' : '' }}"
                                data-icon="{{ $option['emoji'] }}"
                                data-label="{{ $option['label'] }}"
                                aria-pressed="{{ $selectedIcon === $option['emoji'] ? 'true' : 'false' }}"
                            >

                                <span class="cp-icon-check">
                                    <i class="fa-solid fa-circle-check"></i>
                                </span>

                                <span class="cp-emoji">
                                    {{ $option['emoji'] }}
                                </span>

                                <small>
                                    {{ $option['label'] }}
                                </small>

                            </button>

                        @endforeach

                    </div>

                    <div class="cp-icon-summary">

                        <div>
                            Ikon terpilih:
                            <strong id="iconSummary">
                                {{ $selectedIcon }}
                            </strong>
                        </div>

                        <small>
                            Digunakan sebagai identitas visual produk.
                        </small>

                    </div>

                </section>

                <!-- FOTO PRODUK -->

                <section class="cp-card">

                    <div class="cp-card-title">

                        <span class="cp-card-icon">
                            <i class="fa-regular fa-image"></i>
                        </span>

                        <div>
                            <h2>Foto Produk Utama</h2>

                            <p>
                                Pilih foto asli dengan pencahayaan yang baik
                                agar pembeli mudah mengenali produk.
                            </p>
                        </div>

                    </div>

                    <label
                        for="productImage"
                        class="cp-upload-zone"
                        id="uploadZone"
                    >

                        <span class="cp-upload-circle">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </span>

                        <strong>
                            Tarik dan lepas foto ke sini,
                            atau klik untuk memilih foto.
                        </strong>

                        <small>
                            JPEG atau PNG. Disarankan maksimal 2 MB.
                            Satu foto utama untuk satu produk.
                        </small>

                    </label>

                    <input
                        type="file"
                        id="productImage"
                        name="image"
                        accept="image/jpeg,image/png"
                        style="position:absolute;width:1px;height:1px;opacity:0;"
                    >

                    <!-- PREVIEW FOTO -->

                    <div class="cp-upload-preview"
                         id="uploadPreview"
                         hidden>

                        <img
                            id="uploadedPhoto"
                            src=""
                            alt="Preview foto yang diunggah"
                        >

                        <div style="min-width:0;">
                            <strong style="font-size:11px;color:#28563d;">
                                Foto Utama
                            </strong>

                            <p id="uploadedFileName"></p>
                        </div>

                        <button
                            class="cp-remove-photo"
                            id="removePhoto"
                            type="button"
                            title="Hapus foto terpilih"
                            aria-label="Hapus foto terpilih"
                        >
                            <i class="fa-solid fa-trash"></i>
                        </button>

                    </div>

                    @error('image')
                        <span class="cp-field-error">{{ $message }}</span>
                    @enderror

                </section>

                <!-- AKSI FORM -->

                <div class="cp-actions">

                    <a href="{{ route('products.my') }}"
                       class="cp-back">
                        <i class="fa-solid fa-xmark"></i>
                        Batalkan & Kembali
                    </a>

                    <button
                        type="submit"
                        class="cp-submit"
                        id="publishButton"
                    >
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        Terbitkan Produk
                    </button>

                </div>

            </div>

            <!-- ======================================
                 KOLOM KANAN
            ======================================= -->

            <aside class="cp-side">

                <!-- PREVIEW PRODUK -->

                <section class="cp-card">

                    <div class="cp-preview-head">

                        <h3>
                            <i class="fa-regular fa-eye"></i>
                            Preview di Marketplace
                        </h3>

                        <span class="cp-preview-tag">
                            Tampilan Pembeli
                        </span>

                    </div>

                    <div class="cp-product-preview">

                        <div class="cp-preview-image">

                            <span
                                id="previewPlaceholder"
                                class="cp-placeholder"
                            >
                                {{ $selectedIcon }}
                            </span>

                            <img
                                id="previewProductImage"
                                src=""
                                alt="Preview produk"
                                hidden
                            >

                            <span class="cp-preview-badge"
                                  id="previewBadge">
                                {{ $selectedIcon }} Produk Pertanian
                            </span>

                        </div>

                        <div class="cp-preview-content">

                            <div class="cp-preview-category"
                                 id="previewCategory">
                                Pilih kategori
                            </div>

                            <h3 class="cp-preview-name"
                                id="previewName">
                                Nama produkmu akan tampil di sini
                            </h3>

                            <div>

                                <span class="cp-preview-price"
                                      id="previewPrice">
                                    Rp 0
                                </span>

                                <span class="cp-preview-unit"
                                      id="previewUnit">
                                    / pcs
                                </span>

                            </div>

                            <div class="cp-preview-meta">

                                <span>
                                    <i class="fa-solid fa-seedling"></i>
                                    Produk Baru
                                </span>

                                <span id="previewStock">
                                    Stok: 0
                                </span>

                            </div>

                            <div class="cp-preview-location">

                                <i class="fa-solid fa-location-dot"></i>

                                <span id="previewLocation">
                                    Lokasi penjual akan tampil di sini
                                </span>

                            </div>

                            <!-- HANYA TAMPILAN PREVIEW -->

                            <button
                                type="button"
                                class="cp-preview-cart"
                                disabled
                            >
                                <i class="fa-solid fa-cart-shopping"></i>
                                + Keranjang
                            </button>

                        </div>

                    </div>

                    <p class="cp-preview-caption">
                        Preview berubah otomatis ketika kamu
                        mengisi formulir. Ini bukan produk
                        yang sudah dipublikasikan.
                    </p>

                </section>

                <!-- TIPS PENJUAL -->

                <section class="cp-card cp-tips">

                    <h3>
                        <i class="fa-regular fa-lightbulb"></i>
                        Tips Sukses Menjual
                    </h3>

                    <p>
                        Panduan mengisi informasi produk TaniMart.
                    </p>

                    <div class="cp-tips-list">

                        <div class="cp-tip-row">

                            <span class="cp-tip-num">1</span>

                            <p>
                                <strong>Nama yang jelas.</strong>
                                Sebutkan jenis produk, varietas,
                                jumlah isi, atau ukuran kemasannya.
                            </p>

                        </div>

                        <div class="cp-tip-row">

                            <span class="cp-tip-num">2</span>

                            <p>
                                <strong>Gunakan foto asli.</strong>
                                Pastikan gambar menunjukkan barang
                                yang benar-benar akan dijual.
                            </p>

                        </div>

                        <div class="cp-tip-row">

                            <span class="cp-tip-num">3</span>

                            <p>
                                <strong>Harga yang sesuai.</strong>
                                Perhitungkan biaya pembelian,
                                produksi, dan pengemasan.
                            </p>

                        </div>

                        <div class="cp-tip-row">

                            <span class="cp-tip-num">4</span>

                            <p>
                                <strong>Stok harus akurat.</strong>
                                Sesuaikan jumlah stok ketika produk
                                terjual di luar TaniMart.
                            </p>

                        </div>

                    </div>

                    <div class="cp-ai-link">

                        <span>
                            Perlu bantuan membuat deskripsi?
                        </span>

                        <a href="{{ route('konsultasi') }}">
                            <i class="fa-solid fa-robot"></i>
                            Tanya TaniAI
                        </a>

                    </div>

                </section>

            </aside>

        </div>

    </form>

</main>

@include('partials.footer')

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ============================================
    // AMBIL ELEMEN FORM
    // ============================================

    const form = document.getElementById('createProductForm');

    const nameInput = document.getElementById('productName');
    const categorySelect = document.getElementById('productCategory');
    const categoryName = document.getElementById('categoryName');

    const locationInput = document.getElementById('productLocation');
    const descriptionInput = document.getElementById('productDescription');

    const priceInput = document.getElementById('productPrice');
    const stockInput = document.getElementById('productStock');
    const unitSelect = document.getElementById('productUnit');

    const iconInput = document.getElementById('selectedIcon');

    const fileInput = document.getElementById('productImage');
    const uploadZone = document.getElementById('uploadZone');
    const uploadPreview = document.getElementById('uploadPreview');

    const uploadedPhoto = document.getElementById('uploadedPhoto');
    const uploadedFileName = document.getElementById('uploadedFileName');
    const removePhotoButton = document.getElementById('removePhoto');

    const productPhoto = document.getElementById('previewProductImage');
    const placeholder = document.getElementById('previewPlaceholder');

    const publishButton = document.getElementById('publishButton');

    let imageObjectUrl = null;
    let isSubmitting = false;

    // ============================================
    // UTILITIES
    // ============================================

    function formatRupiah(value) {

        const amount = Math.max(
            0,
            Number(value) || 0
        );

        return 'Rp ' + new Intl.NumberFormat('id-ID', {
            maximumFractionDigits: 0
        }).format(amount);

    }

    // ============================================
    // SINKRONISASI PREVIEW
    // ============================================

    function updatePreview() {

        const productName = nameInput.value.trim();

        const selectedCategory = categorySelect
            .options[categorySelect.selectedIndex];

        const categoryText = selectedCategory &&
            selectedCategory.value !== ''
                ? selectedCategory.textContent.trim()
                : '';

        const location = locationInput.value.trim();

        const price = priceInput.value;

        const stock = Math.max(
            0,
            Number(stockInput.value) || 0
        );

        const unit = unitSelect.value;

        const icon = iconInput.value || '🌱';

        document.getElementById('previewName').textContent =
            productName || 'Nama produkmu akan tampil di sini';

        document.getElementById('previewCategory').textContent =
            categoryText || 'Pilih kategori';

        document.getElementById('previewPrice').textContent =
            formatRupiah(price);

        document.getElementById('priceSummary').textContent =
            formatRupiah(price);

        document.getElementById('previewStock').textContent =
            'Stok: ' + stock;

        document.getElementById('previewUnit').textContent =
            '/ ' + unit;

        document.getElementById('previewLocation').textContent =
            location || 'Lokasi penjual akan tampil di sini';

        document.getElementById('previewBadge').textContent =
            icon + ' ' + (categoryText || 'Produk Pertanian');

        placeholder.textContent = icon;

        // Category text mengikuti kategori asli database.
        categoryName.value = categoryText;

        document.getElementById('nameCounter').textContent =
            nameInput.value.length + '/120';

        document.getElementById('descCounter').textContent =
            descriptionInput.value.length + '/1000';

    }

    [
        nameInput,
        categorySelect,
        locationInput,
        descriptionInput,
        priceInput,
        stockInput,
        unitSelect
    ].forEach(function (element) {

        element.addEventListener('input', updatePreview);
        element.addEventListener('change', updatePreview);

    });

    // ============================================
    // PILIH IKON
    // ============================================

    document.querySelectorAll('.cp-icon-option')
        .forEach(function (button) {

            button.addEventListener('click', function () {

                document.querySelectorAll('.cp-icon-option')
                    .forEach(function (other) {

                        other.classList.remove('selected');

                        other.setAttribute(
                            'aria-pressed',
                            'false'
                        );

                    });

                button.classList.add('selected');

                button.setAttribute(
                    'aria-pressed',
                    'true'
                );

                const icon = button.dataset.icon || '🌱';

                iconInput.value = icon;

                document.getElementById('iconSummary').textContent =
                    icon + ' ' + (button.dataset.label || '');

                updatePreview();

            });

        });

    // ============================================
    // SARAN DESKRIPSI
    // ============================================

    document.querySelectorAll('[data-description-tip]')
        .forEach(function (button) {

            button.addEventListener('click', function () {

                const addition = button.getAttribute(
                    'data-description-tip'
                ) || '';

                const current = descriptionInput.value;

                const separator =
                    current.trim() === '' ? '' : '\n';

                const candidate = current + separator + addition;

                if (
                    candidate.length <=
                    Number(descriptionInput.maxLength)
                ) {
                    descriptionInput.value = candidate;

                    descriptionInput.focus();

                    updatePreview();
                }

            });

        });

    // ============================================
    // FOTO PRODUK: PREVIEW LOKAL
    // ============================================

    function clearPhoto() {

        fileInput.value = '';

        if (imageObjectUrl) {
            URL.revokeObjectURL(imageObjectUrl);
            imageObjectUrl = null;
        }

        uploadedPhoto.removeAttribute('src');
        productPhoto.removeAttribute('src');

        uploadPreview.hidden = true;
        productPhoto.hidden = true;
        placeholder.hidden = false;

    }

    function setPhoto(file) {

        if (!file) {
            clearPhoto();
            return;
        }

        const allowedTypes = [
            'image/jpeg',
            'image/png'
        ];

        if (!allowedTypes.includes(file.type)) {

            alert(
                'Gunakan foto berformat JPEG atau PNG.'
            );

            clearPhoto();
            return;
        }

        // Batas preview untuk memudahkan unggahan.
        if (file.size > 2 * 1024 * 1024) {

            alert(
                'Ukuran foto maksimal 2 MB pada formulir ini.'
            );

            clearPhoto();
            return;
        }

        if (imageObjectUrl) {
            URL.revokeObjectURL(imageObjectUrl);
        }

        imageObjectUrl = URL.createObjectURL(file);

        uploadedPhoto.src = imageObjectUrl;
        productPhoto.src = imageObjectUrl;

        uploadedFileName.textContent =
            file.name;

        uploadPreview.hidden = false;
        productPhoto.hidden = false;
        placeholder.hidden = true;

    }

    fileInput.addEventListener('change', function () {
        setPhoto(fileInput.files[0]);
    });

    removePhotoButton.addEventListener('click', function () {
        clearPhoto();
    });

    // ============================================
    // DRAG & DROP SATU FOTO
    // ============================================

    ['dragenter', 'dragover'].forEach(function (eventName) {

        uploadZone.addEventListener(eventName, function (event) {

            event.preventDefault();

            uploadZone.classList.add('dragging');

        });

    });

    ['dragleave', 'dragend'].forEach(function (eventName) {

        uploadZone.addEventListener(eventName, function (event) {

            event.preventDefault();

            uploadZone.classList.remove('dragging');

        });

    });

    uploadZone.addEventListener('drop', function (event) {

        event.preventDefault();

        uploadZone.classList.remove('dragging');

        const files = event.dataTransfer.files;

        if (!files || files.length === 0) {
            return;
        }

        if (files.length > 1) {
            alert('Pilih satu foto utama saja.');
            return;
        }

        const file = files[0];

        try {

            const transfer = new DataTransfer();

            transfer.items.add(file);

            fileInput.files = transfer.files;

            setPhoto(file);

        } catch (error) {

            alert(
                'Browser tidak mendukung drag & drop ini. ' +
                'Silakan klik area unggah untuk memilih foto.'
            );

        }

    });

    // ============================================
    // CEGAH SUBMIT BERULANG
    // ============================================

    form.addEventListener('submit', function (event) {

        if (isSubmitting) {

            event.preventDefault();
            return;

        }

        // Pastikan kategori teks dan preview terbaru.
        updatePreview();

        if (!form.checkValidity()) {

            form.reportValidity();
            event.preventDefault();
            return;

        }

        isSubmitting = true;

        publishButton.disabled = true;

        publishButton.innerHTML =
            '<i class="fa-solid fa-spinner fa-spin"></i>' +
            ' Menyimpan Produk...';

    });

    // Browser back-forward cache.
    window.addEventListener('pageshow', function () {

        isSubmitting = false;

        publishButton.disabled = false;

        publishButton.innerHTML =
            '<i class="fa-solid fa-cloud-arrow-up"></i>' +
            ' Terbitkan Produk';

    });

    // ============================================
    // PREVIEW PERTAMA KALI
    // ============================================

    updatePreview();

    const selectedButton = document.querySelector(
        '.cp-icon-option.selected'
    );

    if (selectedButton) {

        document.getElementById('iconSummary').textContent =
            selectedButton.dataset.icon + ' ' +
            selectedButton.dataset.label;

    }

});
</script>

</body>
</html>
