
@php
    /*
    |--------------------------------------------------------------------------
    | KATEGORI TANIMART
    |--------------------------------------------------------------------------
    | Kategori bawaan tetap ada.
    | Kategori tambahan dari database tetap ditampilkan.
    */
    $categoriesList = [
        'Bibit Tanaman' => [
            'icon' => '🌱',
            'desc' => 'Mulai dari benih dan bibit berkualitas',
        ],
        'Media Tanam' => [
            'icon' => '🌾',
            'desc' => 'Media tanam untuk mendukung pertumbuhan',
        ],
        'Pupuk & Nutrisi' => [
            'icon' => '🌿',
            'desc' => 'Pupuk dan nutrisi untuk tanamanmu',
        ],
        'Pot & Perlengkapan' => [
            'icon' => '🪴',
            'desc' => 'Pot dan perlengkapan untuk berkebun',
        ],
        'Hasil Panen & Sayuran' => [
            'icon' => '🥕',
            'desc' => 'Temukan aneka hasil kebun dan sayuran',
        ],
        'Alat Pertanian' => [
            'icon' => '🧰',
            'desc' => 'Peralatan untuk pekerjaan pertanian',
        ],
    ];

    foreach (($availableCategories ?? collect()) as $categoryName) {
        if (!isset($categoriesList[$categoryName])) {
            $categoriesList[$categoryName] = [
                'icon' => '🌱',
                'desc' => 'Jelajahi produk ' . $categoryName,
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | PARAMETER FILTER
    |--------------------------------------------------------------------------
    */
    $filterParams = array_filter([
        'q' => $q ?? '',
        'kategori' => $kategori ?? '',
        'sort' => ($sort ?? 'terbaru') !== 'terbaru'
            ? $sort : '',
        'stok' => $stok ?? '',
    ], fn ($value) => $value !== '');

    $hasActiveFilter =
        !empty($q) ||
        !empty($kategori) ||
        !empty($stok) ||
        ($sort ?? 'terbaru') !== 'terbaru';
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>TaniMart | Marketplace Pertanian & Asisten AI</title>

    <meta name="description"
          content="TaniMart — marketplace pertanian modern. Temukan bibit, pupuk, perlengkapan berkebun, hasil panen, dan konsultasi AI pertanian.">

    <meta name="theme-color" content="#004631">

    <link rel="icon"
          href="{{ asset('favicon.svg') }}"
          type="image/svg+xml">

    {{-- CSS GLOBAL TANIMART TETAP DIGUNAKAN --}}
    <link rel="stylesheet"
          href="{{ asset('css/tanimart.css') }}">

    {{-- FONT AWESOME --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- FONT DESAIN STITCH --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        /* ==========================================================
           TANIMART — STITCH HOMEPAGE 2026
           Scoped CSS: hanya bekerja pada halaman beranda.
           CSS global tidak dihapus atau ditimpa filenya.
        ========================================================== */

        body.tm-stitch-home {
            --st-green: #004631;
            --st-green-hover: #006247;
            --st-dark: #193a2a;
            --st-muted: #667e6e;
            --st-bg: #effcf2;
            --st-bg-alt: #e8f7ed;
            --st-border: #dfede2;

            margin: 0;
            background: var(--st-bg);
            color: var(--st-dark);
            font-family:
                "Plus Jakarta Sans",
                "Segoe UI",
                Arial,
                sans-serif;
            overflow-x: hidden;
        }

        .tm-stitch-home,
        .tm-stitch-home *,
        .tm-stitch-home *::before,
        .tm-stitch-home *::after {
            box-sizing: border-box;
        }

        .tm-stitch-home .section {
            width: min(90%, 1320px);
            max-width: 1320px;
            margin: 0 auto;
        }

        .tm-stitch-home section[id] {
            scroll-margin-top: 90px;
        }

        /* ==========================================================
           NAVBAR
        ========================================================== */

        .tm-stitch-home .tm-navbar-wrapper {
            background: rgba(239, 253, 242, 0.97);
            border-bottom: 1px solid #d9ebdf;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 4px 20px rgba(0, 60, 32, 0.04);
        }

        .tm-stitch-home .tm-navbar {
            max-width: 1410px;
        }

        .tm-stitch-home .tm-navbar-brand,
        .tm-stitch-home .tm-brand-name {
            color: var(--st-green);
        }

        .tm-stitch-home .tm-nav-link.active {
            background: #dff1e5;
            color: var(--st-green);
        }

        .tm-stitch-home .tm-nav-link:hover {
            background: #e2f3e8;
            color: var(--st-green);
        }

        .tm-stitch-home .tm-nav-sell {
            background: var(--st-green);
            border: 1px solid var(--st-green);
            border-radius: 999px;
            color: white !important;
        }

        .tm-stitch-home .tm-nav-sell i {
            color: white !important;
        }

        .tm-stitch-home .tm-nav-sell:hover {
            background: var(--st-green-hover) !important;
            color: white !important;
        }

        /* ==========================================================
           HERO SECTION
        ========================================================== */

        .tm-stitch-home .hero {
            width: 100%;
            max-width: none;
            min-height: 625px;
            margin: 0;
            padding:
                78px
                max(5%, calc((100vw - 1320px) / 2));

            display: grid;
            grid-template-columns:
                minmax(0, 1.13fr)
                minmax(0, 0.87fr);
            align-items: center;
            gap: clamp(35px, 5vw, 85px);

            border: none;
            border-radius: 0;
            box-shadow: none;
            overflow: visible;

            background:
                radial-gradient(
                    circle at 8% 22%,
                    #dff9e7,
                    transparent 48%
                ),
                linear-gradient(
                    115deg,
                    #f1fff3,
                    #e9faed
                );
        }

        .tm-stitch-home .hero-content {
            max-width: 690px;
            min-width: 0;
            position: relative;
            z-index: 2;
        }

        .tm-stitch-home .hero .tagline {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            width: fit-content;

            margin-bottom: 27px;
            padding: 11px 18px;

            border: none;
            border-radius: 999px;
            background: #e1f2e7;

            color: #236147;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0;
            text-transform: none;
        }

        .tm-stitch-home .hero h1 {
            max-width: 720px;
            margin: 0 0 25px;

            color: var(--st-green);
            font-family: inherit;
            font-size: clamp(37px, 4.4vw, 61px);
            font-weight: 800;
            letter-spacing: -2.1px;
            line-height: 1.13;
        }

        .tm-stitch-home .hero h1 span {
            color: var(--st-green);
        }

        .tm-stitch-home .hero p {
            max-width: 605px;
            margin-bottom: 32px;

            color: #577160;
            font-size: 15px;
            line-height: 1.9;
        }

        .tm-stitch-home .hero .buttons {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }

        .tm-stitch-home .hero .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            min-height: 48px;
            padding: 12px 20px;

            border-radius: 999px;
            border: 1px solid transparent;

            font-family: inherit;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .tm-stitch-home .hero .btn-primary {
            background: var(--st-green);
            color: white;
        }

        .tm-stitch-home .hero .btn-secondary {
            background: #e0f0e6;
            color: var(--st-green);
            border-color: transparent;
        }

        .tm-stitch-home .hero .tm-hero-ai-btn {
            background: #f7e9d1;
            color: #73521d;
        }

        .tm-stitch-home .hero .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 57, 35, 0.12);
        }

        /* HERO STATISTICS */

        .tm-stitch-home .tm-hero-stats {
            display: flex;
            align-items: flex-start;
            flex-wrap: wrap;

            margin-top: 65px;
            gap: clamp(24px, 4vw, 65px);
        }

        .tm-stitch-home .tm-hero-stat {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .tm-stitch-home .tm-hero-stat strong {
            color: var(--st-green);
            font-size: clamp(21px, 2vw, 27px);
            font-weight: 800;
            line-height: 1.2;
        }

        .tm-stitch-home .tm-hero-stat span {
            color: #6a8272;
            font-size: 12px;
        }

        /* HERO IMAGE */

        .tm-stitch-home .tm-hero-visual {
            position: relative;
            width: 100%;
            height: 485px;
            min-width: 0;
        }

        .tm-stitch-home .tm-hero-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            border-radius: 30px;

            box-shadow:
                12px 13px 0 #dbeee0,
                0 25px 38px rgba(0, 55, 30, 0.13);
        }

        .tm-stitch-home .tm-hero-floating {
            position: absolute;
            z-index: 3;

            display: flex;
            align-items: center;
            gap: 11px;

            max-width: 245px;
            padding: 14px 16px;

            border-radius: 17px;
            background: #fff;

            box-shadow:
                0 13px 30px rgba(0, 52, 32, 0.16);
        }

        .tm-stitch-home .tm-hero-floating.top {
            top: -20px;
            right: -17px;
        }

        .tm-stitch-home .tm-hero-floating.bottom {
            bottom: -21px;
            left: -23px;
        }

        .tm-stitch-home .tm-floating-icon {
            display: flex;
            justify-content: center;
            align-items: center;

            width: 42px;
            height: 42px;
            flex-shrink: 0;

            background: #daf0dc;
            border-radius: 12px;
            color: var(--st-green);
            font-size: 18px;
        }

        .tm-stitch-home .tm-hero-floating.bottom .tm-floating-icon {
            background: var(--st-green);
            color: white;
        }

        .tm-stitch-home .tm-hero-floating strong {
            display: block;
            font-size: 12px;
            color: #234533;
            line-height: 1.5;
        }

        .tm-stitch-home .tm-hero-floating small {
            display: block;
            color: #738778;
            font-size: 11px;
            line-height: 1.5;
        }

        /* ==========================================================
           GENERAL TITLES
        ========================================================== */

        .tm-stitch-home .section h2 {
            color: var(--st-green);
            font-size: clamp(27px, 3vw, 38px);
            font-weight: 800;
            letter-spacing: -1.2px;
            line-height: 1.25;
        }

        .tm-stitch-home .section-description {
            color: var(--st-muted);
            font-size: 14px;
            line-height: 1.8;
        }

        .tm-stitch-home .tm-section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 13px;
            color: #397b57;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.65px;
        }

        /* ==========================================================
           CATEGORIES
        ========================================================== */

        .tm-stitch-home #kategori {
            width: 100%;
            max-width: none;
            margin: 0;

            padding:
                78px
                max(5%, calc((100vw - 1320px) / 2))
                90px;

            background: #e8f7ed;
        }

        .tm-stitch-home .tm-section-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;

            margin-bottom: 29px;
        }

        .tm-stitch-home .tm-section-heading .section-description {
            margin-bottom: 0;
        }

        .tm-stitch-home .tm-all-categories {
            color: var(--st-green);
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
        }

        .tm-stitch-home #kategori .categories {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 14px;
            align-items: stretch;
        }

        .tm-stitch-home #kategori .category-card-link {
            display: block;
            height: 100%;
            border-radius: 19px;
            text-decoration: none;
        }

        .tm-stitch-home #kategori .category {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;

            width: 100%;
            height: 100%;
            min-height: 245px;
            padding: 21px 17px;

            border: 1px solid #e0ece3;
            border-radius: 18px;
            background: #fff;

            text-align: left;
            box-shadow: 0 5px 18px rgba(0, 54, 34, 0.035);
            transition: 0.25s ease;
        }

        .tm-stitch-home #kategori .category::before {
            display: none;
        }

        .tm-stitch-home #kategori .category:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 30px rgba(0, 58, 37, 0.10);
        }

        .tm-stitch-home #kategori .category-icon {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 53px;
            height: 53px;
            margin: 0 0 20px;

            border-radius: 15px;
            background: #dcf2de;
            font-size: 25px;
        }

        .tm-stitch-home #kategori
        .category-card-link:nth-child(2) .category-icon {
            background: #d5f5e3;
        }

        .tm-stitch-home #kategori
        .category-card-link:nth-child(3) .category-icon {
            background: #fff0d9;
        }

        .tm-stitch-home #kategori
        .category-card-link:nth-child(4) .category-icon {
            background: #e1ece4;
        }

        .tm-stitch-home #kategori
        .category-card-link:nth-child(5) .category-icon {
            background: #d3efd0;
        }

        .tm-stitch-home #kategori
        .category-card-link:nth-child(6) .category-icon {
            background: #e8f1d9;
        }

        .tm-stitch-home #kategori .category h3 {
            margin-bottom: 10px;
            color: #203629;
            font-size: 14px;
            font-weight: 800;
            line-height: 1.5;
            text-align: left;
        }

        .tm-stitch-home #kategori .category p {
            color: #728476;
            font-size: 11px;
            line-height: 1.75;
            text-align: left;
        }

        .tm-stitch-home #kategori .category.active-category {
            border: 2px solid #118156 !important;
            background: #f1fff4 !important;
        }

        .tm-stitch-home .tm-category-arrow {
            margin-top: auto;
            padding-top: 20px;
            color: #48775c;
            font-size: 14px;
            align-self: flex-end;
        }

        /* ==========================================================
           SEARCH BOX
        ========================================================== */

        .tm-stitch-home .tm-search-container {
            width: min(90%, 1100px);
            max-width: 1100px;
            margin: 46px auto 0;
            padding: 0;
            position: relative;
            z-index: 3;
        }

        .tm-stitch-home .tm-search-box {
            padding: 22px;

            border-radius: 21px;
            border: 1px solid #dfebe2;
            background: #fff;

            box-shadow: 0 13px 33px rgba(0, 56, 34, 0.07);
        }

        .tm-stitch-home .tm-search-input-wrap,
        .tm-stitch-home .tm-search-select-category {
            background: #f3faf5;
            border-color: #d8e8dc;
            border-radius: 13px;
        }

        .tm-stitch-home .tm-search-input-wrap:focus-within {
            background: #fff;
            border-color: var(--st-green);
        }

        .tm-stitch-home .btn-search-submit {
            background: var(--st-green);
            border-radius: 13px;
        }

        .tm-stitch-home .btn-search-submit:hover {
            background: var(--st-green-hover);
        }

        .tm-stitch-home .tm-tag-pill {
            background: #eaf6ed;
            border-color: #d6e9da;
            color: #316d4c;
        }

        .tm-stitch-home .tm-tag-pill:hover {
            background: var(--st-green);
            border-color: var(--st-green);
            color: white;
        }

        /* ==========================================================
           PRODUCT SECTION
        ========================================================== */

        .tm-stitch-home #produk {
            padding-top: 74px;
            padding-bottom: 90px;
        }

        .tm-stitch-home #produk .product-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 20px;

            margin-bottom: 25px;
        }

        .tm-stitch-home #produk .product-eyebrow {
            color: #39815d;
            letter-spacing: 0.6px;
        }

        .tm-stitch-home #produk .tm-filter-sort-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;

            gap: 15px;
            margin-bottom: 27px;
            padding: 17px;

            border: 1px solid #dce9de;
            border-radius: 17px;
            background: #e6f4e9;
        }

        .tm-stitch-home #produk .tm-stock-filter-controls {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 9px;
        }

        .tm-stitch-home #produk .tm-stock-select,
        .tm-stitch-home #produk .tm-sort-select {
            padding: 9px 12px;
            border: 1px solid #d6e5da;
            border-radius: 11px;

            background: #fff;
            color: var(--st-green);
            font-size: 12px;
        }

        .tm-stitch-home #produk .tm-filter-badge {
            background: #d7efdf;
            border-color: #c6e4d0;
            color: var(--st-green);
        }

        .tm-stitch-home #produk .product-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            align-items: stretch;
            gap: 19px;
        }

        .tm-stitch-home #produk .product-card {
            display: flex;
            flex-direction: column;
            min-width: 0;

            overflow: hidden;
            border: 1px solid #e4eee7;
            border-radius: 20px;
            background: #fff;

            box-shadow: 0 5px 20px rgba(0, 50, 32, 0.04);
            transition: 0.25s ease;
        }

        .tm-stitch-home #produk .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 17px 34px rgba(0, 56, 34, 0.11);
        }

        .tm-stitch-home #produk .product-image {
            position: relative;
            width: 100%;
            min-height: 0;
            aspect-ratio: 1.22 / 1;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #e4f0e7;
            overflow: hidden;
        }

        .tm-stitch-home #produk .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .tm-stitch-home #produk .product-emoji {
            font-size: 65px;
        }

        .tm-stitch-home #produk .product-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            z-index: 2;

            padding: 6px 11px;
            border-radius: 999px;

            background: rgba(255, 255, 255, 0.96);
            color: var(--st-green);

            font-size: 10px;
            font-weight: 800;
        }

        .tm-stitch-home #produk .tm-out-of-stock {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 3;

            padding: 6px 9px;
            border-radius: 999px;

            background: #b42318;
            color: white;
            font-size: 10px;
            font-weight: 800;
        }

        .tm-stitch-home #produk .product-info {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-width: 0;

            padding: 18px;
        }

        .tm-stitch-home #produk .product-category {
            color: #54876b;
            font-size: 11px;
        }

        .tm-stitch-home #produk .product-name {
            min-height: 46px;
            margin: 6px 0 10px;

            color: #1d3226;
            font-size: 16px;
            font-weight: 800;
            line-height: 1.45;

            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            overflow: hidden;
        }

        .tm-stitch-home #produk .product-description {
            min-height: 40px;
            margin-bottom: 11px;

            color: #76877a;
            font-size: 12px;
            line-height: 1.7;
        }

        .tm-stitch-home #produk .tm-seller-line {
            color: #66826d;
            font-size: 11px;
            margin-bottom: 13px;
        }

        .tm-stitch-home #produk .tm-stock-line {
            margin: auto 0 12px;
            font-size: 11px;
            font-weight: 700;
        }

        .tm-stitch-home #produk .tm-stock-line.is-ready {
            color: #23814b;
        }

        .tm-stitch-home #produk .tm-stock-line.is-low {
            color: #af690c;
        }

        .tm-stitch-home #produk .tm-stock-line.is-empty {
            color: #b42318;
        }

        .tm-stitch-home #produk .product-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 11px;

            margin-top: 0;
            padding-top: 14px;
            border-top: 1px solid #edf2ee;
        }

        .tm-stitch-home #produk .product-price {
            color: var(--st-green);
            font-size: 19px;
            font-weight: 800;
            line-height: 1.4;
        }

        .tm-stitch-home #produk .tm-product-buttons {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .tm-stitch-home #produk .add-cart {
            position: relative;
            top: 0;
            flex: 0 0 38px;

            width: 38px;
            height: 38px;
            padding: 0;

            display: flex;
            justify-content: center;
            align-items: center;

            border: none;
            border-radius: 50%;
            background: #e1f1e5;
            color: var(--st-green);
            box-shadow: none;

            font-size: 15px;
            line-height: 1;
        }

        .tm-stitch-home #produk .add-cart:hover {
            background: #c7e7d0;
            color: var(--st-green);
        }

        .tm-stitch-home #produk .add-cart:disabled {
            background: #e5e7eb !important;
            color: #94a3b8 !important;
            cursor: not-allowed;
        }

        .tm-stitch-home #produk .btn-chat-seller {
            padding: 9px 11px;
            background: #e7f4e9;
            color: var(--st-green);
            border: 1px solid #d2e9d8;
            border-radius: 999px;
            font-size: 11px;
        }

        .tm-stitch-home #produk .tm-detail-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 9px 12px;
            border-radius: 999px;
            background: #e7f4e9;

            color: var(--st-green);
            font-size: 11px;
            font-weight: 800;
            text-decoration: none;
        }

        .tm-stitch-home #produk .tm-extra-product[hidden] {
            display: none !important;
        }

        .tm-stitch-home .tm-more-wrap {
            display: flex;
            justify-content: center;
            margin-top: 42px;
        }

        .tm-stitch-home .tm-more-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 13px;

            padding: 14px 27px;
            border: none;
            border-radius: 999px;

            background: #e1f1e6;
            color: var(--st-green);
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
        }

        .tm-stitch-home .tm-more-btn:hover {
            background: #cfe8d8;
        }

        /* ==========================================================
           AI BANNER
        ========================================================== */

        .tm-stitch-home #ai {
            padding-top: 28px;
            padding-bottom: 100px;
        }

        .tm-stitch-home #ai .ai-card {
            min-height: 375px;
            padding: 54px;

            display: grid;
            grid-template-columns:
                minmax(0, 1fr)
                minmax(0, 0.9fr);
            gap: 42px;
            align-items: center;

            border-radius: 25px;

            background:
                radial-gradient(
                    circle at 79% 50%,
                    rgba(74, 147, 96, 0.25),
                    transparent 55%
                ),
                linear-gradient(
                    115deg,
                    #003d2b,
                    #07513a
                );

            box-shadow: 0 20px 35px rgba(0, 51, 34, 0.14);
        }

        .tm-stitch-home .tm-ai-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 23px;
            padding: 8px 13px;

            border-radius: 999px;
            background: rgba(255,255,255,0.13);

            color: #d1ead8;
            font-size: 10px;
            font-weight: 800;
        }

        .tm-stitch-home #ai .ai-card h2 {
            color: #fff;
            font-size: clamp(29px, 3vw, 44px);
            letter-spacing: -1.3px;
            line-height: 1.2;
        }

        .tm-stitch-home #ai .ai-card p {
            color: #d2e5d6;
            font-size: 13px;
            line-height: 1.9;
            margin-top: 18px;
        }

        .tm-stitch-home .tm-ai-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 24px 0;
        }

        .tm-stitch-home .tm-ai-chips span {
            padding: 8px 11px;
            border-radius: 999px;

            background: rgba(255, 255, 255, 0.11);
            color: #e7f5ea;
            font-size: 10px;
            font-weight: 700;
        }

        .tm-stitch-home #ai .ai-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;

            padding: 13px 20px;
            border-radius: 999px;

            background: #ffdda7;
            color: #493315;

            font-size: 12px;
            font-weight: 800;
            white-space: normal;
        }

        .tm-stitch-home .tm-ai-demo {
            display: flex;
            flex-direction: column;
            gap: 12px;
            min-width: 0;
        }

        .tm-stitch-home .tm-ai-question {
            width: 89%;
            align-self: flex-end;

            padding: 18px;
            border-radius: 18px;
            background: rgba(255,255,255,0.13);
            color: #fff;

            font-size: 12px;
            line-height: 1.7;
        }

        .tm-stitch-home .tm-ai-answer {
            padding: 21px;
            border-radius: 19px;
            background: #fff;
            box-shadow: 0 12px 27px rgba(0,0,0,0.12);
        }

        .tm-stitch-home .tm-ai-answer strong {
            color: var(--st-green);
            font-size: 12px;
        }

        .tm-stitch-home .tm-ai-answer p {
            color: #657c6b !important;
            font-size: 12px !important;
            margin: 10px 0 !important;
            line-height: 1.7 !important;
        }

        .tm-stitch-home .tm-ai-answer ul {
            margin: 12px 0 0 19px;
            color: #526f5e;
            font-size: 11px;
            line-height: 1.8;
        }

        .tm-stitch-home .tm-ai-answer small {
            display: block;
            margin-top: 15px;
            color: #829588;
            font-size: 10px;
        }

        /* ==========================================================
           BENEFITS
        ========================================================== */

        .tm-stitch-home #tm-benefits {
            width: 100%;
            max-width: none;
            margin: 0;

            padding:
                85px
                max(5%, calc((100vw - 1320px) / 2))
                95px;

            background: #e8f7ed;
        }

        .tm-stitch-home .tm-benefits-title {
            margin-bottom: 40px;
            text-align: center;
        }

        .tm-stitch-home .tm-benefits-title span {
            color: #47825e;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .tm-stitch-home .tm-benefits-title h2 {
            margin: 12px 0;
        }

        .tm-stitch-home .tm-benefits-title p {
            color: #6b8271;
            font-size: 13px;
            line-height: 1.8;
        }

        .tm-stitch-home .tm-benefit-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }

        .tm-stitch-home .tm-benefit-card {
            min-height: 235px;
            padding: 25px;

            border: 1px solid #e2eee6;
            border-radius: 19px;
            background: #fff;

            box-shadow: 0 4px 14px rgba(0, 55, 35, 0.025);
        }

        .tm-stitch-home .tm-benefit-icon {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 48px;
            height: 48px;
            margin-bottom: 20px;

            border-radius: 13px;
            background: #d7f0da;
            color: var(--st-green);
            font-size: 19px;
        }

        .tm-stitch-home .tm-benefit-card:nth-child(2)
        .tm-benefit-icon {
            background: #c9f3dc;
        }

        .tm-stitch-home .tm-benefit-card:nth-child(3)
        .tm-benefit-icon {
            background: #ffe4b9;
        }

        .tm-stitch-home .tm-benefit-card h3 {
            margin-bottom: 11px;

            color: #24382b;
            font-size: 16px;
            line-height: 1.5;
        }

        .tm-stitch-home .tm-benefit-card p {
            color: #758679;
            font-size: 12px;
            line-height: 1.8;
        }

        /* ==========================================================
           FOOTER: TAMPILAN KHUSUS BERANDA
        ========================================================== */

        .tm-stitch-home .tm-footer {
            margin-top: 0;
            background: #e5f4e9;
            color: #5b7864;
        }

        .tm-stitch-home .tm-footer-brand strong,
        .tm-stitch-home .tm-footer-links h4 {
            color: var(--st-green);
        }

        .tm-stitch-home .tm-footer-brand p,
        .tm-stitch-home .tm-footer-links a {
            color: #607b68;
        }

        .tm-stitch-home .tm-footer-bottom {
            border-top-color: #cfe5d4;
        }

        /* ==========================================================
           RESPONSIVE
        ========================================================== */

        @media (max-width: 1250px) {
            .tm-stitch-home #kategori .categories {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .tm-stitch-home .hero {
                gap: 35px;
            }
        }

        @media (max-width: 1100px) {
            .tm-stitch-home #produk .product-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .tm-stitch-home .tm-benefit-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .tm-stitch-home .hero {
                grid-template-columns: 1fr;
                padding: 55px 6%;
                gap: 45px;
            }

            .tm-stitch-home .hero-content {
                max-width: 100%;
            }

            .tm-stitch-home .tm-hero-visual {
                height: 385px;
            }

            .tm-stitch-home #produk .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .tm-stitch-home #ai .ai-card {
                grid-template-columns: 1fr;
                padding: 36px;
            }
        }

        @media (max-width: 650px) {
            .tm-stitch-home .hero {
                padding: 43px 5% 57px;
            }

            .tm-stitch-home .hero h1 {
                font-size: 37px;
                letter-spacing: -1.4px;
            }

            .tm-stitch-home .hero p {
                font-size: 13px;
            }

            .tm-stitch-home .hero .btn {
                min-height: 42px;
                font-size: 11px;
                padding: 10px 13px;
            }

            .tm-stitch-home .tm-hero-stats {
                margin-top: 40px;
                gap: 24px;
            }

            .tm-stitch-home .tm-hero-visual {
                height: 290px;
            }

            .tm-stitch-home .tm-hero-floating {
                padding: 10px;
                max-width: 195px;
            }

            .tm-stitch-home .tm-hero-floating.top {
                right: -4px;
            }

            .tm-stitch-home .tm-hero-floating.bottom {
                left: -4px;
            }

            .tm-stitch-home #kategori,
            .tm-stitch-home #tm-benefits {
                padding: 55px 5%;
            }

            .tm-stitch-home #kategori .categories {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 11px;
            }

            .tm-stitch-home #kategori .category {
                min-height: 215px;
                padding: 17px 13px;
            }

            .tm-stitch-home #kategori .category h3 {
                font-size: 13px;
            }

            .tm-stitch-home #kategori .category p {
                font-size: 11px;
            }

            .tm-stitch-home .section {
                width: 92%;
            }

            .tm-stitch-home #produk {
                padding: 55px 0;
            }

            .tm-stitch-home #produk .product-grid {
                gap: 11px;
            }

            .tm-stitch-home #produk .product-info {
                padding: 12px;
            }

            .tm-stitch-home #produk .product-name {
                font-size: 13px;
                min-height: 38px;
            }

            .tm-stitch-home #produk .product-description {
                font-size: 11px;
            }

            .tm-stitch-home #produk .product-price {
                font-size: 16px;
            }

            .tm-stitch-home #produk .product-bottom {
                align-items: flex-start;
            }

            .tm-stitch-home #ai .ai-card {
                padding: 26px 20px;
            }

            .tm-stitch-home .tm-benefit-grid {
                grid-template-columns: 1fr;
            }

            .tm-stitch-home .tm-search-input-group {
                flex-direction: column;
                align-items: stretch;
            }
        }

        @media (max-width: 390px) {
            .tm-stitch-home #produk .product-grid {
                grid-template-columns: 1fr;
            }

            .tm-stitch-home #kategori .categories {
                grid-template-columns: 1fr;
            }
        }
    </style>

<!-- ===========================================
     TANIMART — STITCH COMPACT NAVBAR
     Khusus beranda, tidak mengubah navbar global
=========================================== -->
<style>
/* Navbar utama */
body.tm-stitch-home .tm-navbar-wrapper {
    background: rgba(239, 253, 241, .97) !important;
    border-bottom: 1px solid #e1f0e5;
    box-shadow: 0 2px 12px rgba(4, 68, 44, .04);
    backdrop-filter: blur(14px);
    z-index: 1050;
}

body.tm-stitch-home .tm-navbar {
    width: 100%;
    max-width: 1520px;
    min-height: 72px;
    margin: 0 auto;
    padding: 9px 19px;

    display: flex;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: space-between;
    gap: 17px;
}

/* Logo */
body.tm-stitch-home .tm-navbar-brand {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    flex-shrink: 0;

    font-size: 19px;
    line-height: 1;
    letter-spacing: -.5px;
}

body.tm-stitch-home .tm-brand-icon {
    font-size: 22px;
}

body.tm-stitch-home .tm-brand-name {
    font-size: 19px;
    font-weight: 800;
    white-space: nowrap;
    color: #04442c;
}

/* Kelompok menu */
body.tm-stitch-home .tm-navbar-collapse {
    flex: 1;
    min-width: 0;

    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 11px;
}

body.tm-stitch-home .tm-nav-main {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
    gap: 2px;
    min-width: 0;
}

/* Menu: Beranda, Kategori, Produk, AI, Pesanan */
body.tm-stitch-home .tm-nav-main .tm-nav-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    gap: 5px;

    min-height: 37px;
    padding: 8px 9px;

    font-size: 12px;
    font-weight: 600;
    line-height: 1.2;
    white-space: nowrap;

    border-radius: 9px;
    box-shadow: none;
    text-decoration: none;
}

/* Hilangkan ikon menu biasa seperti Stitch */
body.tm-stitch-home
.tm-nav-main .tm-nav-link:not(.tm-nav-sell) > i {
    display: none;
}

/* Beranda aktif tidak berbentuk kotak besar */
body.tm-stitch-home .tm-nav-main .tm-nav-link.active {
    color: #04442c;
    background: transparent;
    font-weight: 800;
}

body.tm-stitch-home .tm-nav-main .tm-nav-link:hover {
    background: #e4f3e8;
    color: #04442c;
}

/* Tanya AI seperti Stitch */
body.tm-stitch-home .tm-nav-main .tm-nav-ai {
    background: transparent !important;
    border: 0 !important;
    color: #425d4b !important;
    box-shadow: none !important;
}

body.tm-stitch-home .tm-nav-ai .ai-sparkle {
    display: none;
}

body.tm-stitch-home .tm-nav-ai .ai-badge-chip {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-width: 26px;
    min-height: 19px;
    margin-left: 2px;
    padding: 3px 6px;

    background: #ffdfad !important;
    color: #77501b !important;

    border-radius: 999px;
    font-size: 0;
    box-shadow: none;
}

body.tm-stitch-home .tm-nav-ai .ai-badge-chip::after {
    content: "AI";
    font-size: 10px;
    font-weight: 800;
}

/* Jual Produk: kecil, hijau tua, satu baris */
body.tm-stitch-home .tm-nav-main .tm-nav-sell {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    min-height: 40px;
    padding: 9px 15px;
    margin-left: 7px;

    background: #04442c !important;
    border: 1px solid #04442c !important;
    border-radius: 999px;

    color: #ffffff !important;
    font-size: 11.5px;
    font-weight: 800;
    white-space: nowrap;
    box-shadow: none;
}

body.tm-stitch-home .tm-nav-sell i {
    display: inline-flex !important;
    color: white !important;
    font-size: 12px;
}

body.tm-stitch-home .tm-nav-sell:hover {
    background: #096346 !important;
    transform: none;
}

/* Bagian ikon dan profil */
body.tm-stitch-home .tm-nav-actions {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-items: center;
    flex-shrink: 0;
    gap: 7px;
    padding: 0;
    border: 0;
}

/* Keranjang dan pesan dibuat seperti icon button */
body.tm-stitch-home .tm-nav-actions .tm-nav-cart {
    width: 40px;
    height: 40px;
    min-width: 40px;

    padding: 0;
    gap: 0;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    background: transparent;
    border: 1px solid transparent !important;
    border-radius: 50%;

    box-shadow: none;
    color: #365446;
}

body.tm-stitch-home .tm-nav-cart:hover {
    background: #e0f1e5;
    transform: none;
}

body.tm-stitch-home .tm-nav-cart > i {
    font-size: 18px;
    color: #345d46 !important;
}

/* Teks Keranjang dan Pesan disembunyikan.
   Tombol serta link tetap berfungsi. */
body.tm-stitch-home .tm-nav-cart .cart-label {
    display: none;
}

/* Badge jumlah keranjang / pesan */
body.tm-stitch-home .tm-cart-badge {
    position: absolute;
    top: -1px;
    right: -2px;

    min-width: 17px;
    height: 17px;
    padding: 0 4px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 999px;
    background: #b88724;
    color: white;

    font-size: 10px;
    line-height: 1;
}

/* Tombol pencarian popup tetap dipakai,
   hanya dibuat bulat dan ringkas */
body.tm-stitch-home
.tm-navbar button:has(.fa-magnifying-glass) {
    width: 42px;
    height: 42px;
    min-width: 42px;
    padding: 0;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;
    background: #ffffff;
    border: 1px solid #e8f0e9;
    box-shadow: none;
}

body.tm-stitch-home
.tm-navbar button:has(.fa-magnifying-glass) i {
    font-size: 16px;
}

/* Area akun jadi ringan, seperti Stitch */
body.tm-stitch-home .tm-account-capsule {
    display: inline-flex;
    flex-shrink: 0;
    align-items: center;

    padding: 0;
    gap: 0;
    border: 0;
    border-radius: 999px;

    background: transparent;
    box-shadow: none;
}

body.tm-stitch-home .tm-user-trigger {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    height: 41px;
    padding: 4px 6px;

    border-radius: 999px;
    background: transparent;
}

body.tm-stitch-home .tm-avatar-circle {
    width: 32px;
    height: 32px;

    flex-shrink: 0;
    font-size: 12px;
    border-radius: 50%;
}

body.tm-stitch-home .tm-user-name {
    max-width: 100px;

    font-size: 12px;
    color: #344c3c;
    font-weight: 700;

    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

body.tm-stitch-home .tm-chevron {
    font-size: 9px;
}

/* Logout cepat diringkas.
   Logout tetap ada di menu dropdown akun. */
body.tm-stitch-home .tm-account-capsule
> .tm-capsule-sep,
body.tm-stitch-home .tm-account-capsule
> form {
    display: none;
}

/* Dropdown profil tetap tampil normal */
body.tm-stitch-home .tm-dropdown-menu {
    z-index: 1200;
}

/* Responsif: saat ruang terlalu sempit,
   gunakan menu hamburger agar tidak bertabrakan */
@media (max-width: 1350px) {
    body.tm-stitch-home .tm-navbar {
        max-width: 100%;
        padding: 11px 22px;
        min-height: 66px;
    }

    body.tm-stitch-home .tm-mobile-toggle {
        display: flex;
        margin-left: auto;
    }

    body.tm-stitch-home .tm-navbar-collapse {
        display: none;
        position: absolute;

        top: 100%;
        left: 0;
        right: 0;

        padding: 20px;
        max-height: calc(100vh - 66px);
        overflow-y: auto;

        flex-direction: column;
        align-items: stretch;
        gap: 15px;

        background: #effdf1;
        border-bottom: 1px solid #dcebe0;
        box-shadow: 0 15px 24px rgba(0,45,30,.1);
    }

    body.tm-stitch-home .tm-navbar-collapse.show {
        display: flex;
    }

    body.tm-stitch-home .tm-nav-main {
        flex-direction: column;
        align-items: stretch;
        gap: 5px;
    }

    body.tm-stitch-home .tm-nav-main .tm-nav-link {
        justify-content: flex-start;
        padding: 12px;
        font-size: 13px;
    }

    body.tm-stitch-home .tm-nav-main .tm-nav-sell {
        margin: 8px 0 0;
        width: fit-content;
    }

    body.tm-stitch-home .tm-nav-actions {
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 12px;
        padding-top: 12px;
        border-top: 1px solid #dcebe0;
    }
}
</style>

</head>

<body class="tm-stitch-home">

    {{-- ========================================================
         NAVBAR ASLI TANIMART
         Semua fungsi akun, navbar search, keranjang tetap ada
    ======================================================== --}}

    @include('partials.navbar')


    {{-- ========================================================
         NOTIFIKASI SUKSES
    ======================================================== --}}

    @if(session('success'))
        <div
            class="site-toast site-toast-success"
            id="toastMsg"
        >
            <span>
                ✅ {{ session('success') }}
            </span>

            <button
                type="button"
                onclick="this.parentElement.remove()"
                aria-label="Tutup notifikasi"
                style="border:0;background:transparent;color:inherit;"
            >
                ✕
            </button>
        </div>

        <script>
            setTimeout(function () {
                const toast = document.getElementById('toastMsg');
                if (toast) toast.remove();
            }, 5000);
        </script>
    @endif

    {{-- NOTIFIKASI ERROR --}}

    @if(session('error'))
        <div
            class="site-toast site-toast-error"
            id="toastErrorMsg"
        >
            <span>
                ⚠️ {{ session('error') }}
            </span>

            <button
                type="button"
                onclick="this.parentElement.remove()"
                aria-label="Tutup notifikasi"
                style="border:0;background:transparent;color:inherit;"
            >
                ✕
            </button>
        </div>

        <script>
            setTimeout(function () {
                const toast = document.getElementById('toastErrorMsg');
                if (toast) toast.remove();
            }, 5000);
        </script>
    @endif


    {{-- ========================================================
         1. HERO — DESAIN STITCH
    ======================================================== --}}

    <section class="hero" id="beranda">

        <div class="hero-content">

            <div class="tagline">
                <i class="fa-solid fa-seedling"></i>
                Marketplace Pertanian untuk Semua
            </div>

            <h1>
                Mulai Menanam,<br>
                <span>Tumbuhkan Harapan.</span>
            </h1>

            <p>
                Temukan benih unggul, pupuk organik,
                perlengkapan berkebun, hingga hasil panen segar
                langsung dari penjual lokal.
                Didukung asisten AI pertanian untuk membantu
                merawat tanamanmu.
            </p>

            <div class="buttons">

                <a href="#produk" class="btn btn-primary">
                    Jelajahi Produk
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                @auth
                    <a
                        href="{{ route('products.create') }}"
                        class="btn btn-secondary"
                    >
                        <i class="fa-solid fa-store"></i>
                        Jual Hasil Kebunmu
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="btn btn-secondary"
                    >
                        <i class="fa-solid fa-store"></i>
                        Mulai Berjualan
                    </a>
                @endauth

                <a
                    href="{{ url('/konsultasi') }}"
                    class="btn tm-hero-ai-btn"
                >
                    <i class="fa-solid fa-robot"></i>
                    Tanya AI Pertanian
                </a>

            </div>

            {{-- STATISTIK DINAMIS: TIDAK MENGARANG DATA --}}

            <div class="tm-hero-stats">

                <div class="tm-hero-stat">
                    <strong>
                        {{ number_format($products->count(), 0, ',', '.') }}
                    </strong>
                    <span>Produk Ditemukan</span>
                </div>

                <div class="tm-hero-stat">
                    <strong>
                        {{ count($categoriesList) }}
                    </strong>
                    <span>Kategori Pertanian</span>
                </div>

                <div class="tm-hero-stat">
                    <strong>AI</strong>
                    <span>Asisten Pertanian</span>
                </div>

            </div>
        </div>

        {{-- FOTO HERO --}}

        <div class="tm-hero-visual">

            <img
                class="tm-hero-photo"
                src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&amp;fit=crop&amp;w=1200&amp;q=85"
                alt="Berbagai hasil pertanian segar"
                loading="eager"
            >

            <div class="tm-hero-floating top">

                <div class="tm-floating-icon">
                    <i class="fa-solid fa-seedling"></i>
                </div>

                <div>
                    <strong>Produk Pertanian Pilihan</strong>
                    <small>Jelajahi hasil kebun lokal</small>
                </div>
            </div>

            <div class="tm-hero-floating bottom">

                <div class="tm-floating-icon">
                    <i class="fa-solid fa-robot"></i>
                </div>

                <div>
                    <strong>Asisten AI TaniMart</strong>
                    <small>Konsultasi tanaman tersedia</small>
                </div>
            </div>

        </div>

    </section>


    {{-- ========================================================
         2. KATEGORI — TETAP DINAMIS
    ======================================================== --}}

    <section class="section" id="kategori">

        <div class="tm-section-heading">

            <div>

                <span class="tm-section-label">
                    <i class="fa-solid fa-grip"></i>
                    KATALOG PERTANIAN
                </span>

                <h2>Jelajahi Kategori Pertanian</h2>

                <p class="section-description">
                    Temukan kebutuhan berkebun, budidaya,
                    dan berbagai perlengkapan pertanian.
                </p>

            </div>

            @if(!empty($kategori))
                <a
                    class="tm-all-categories"
                    href="{{ url('/') }}?{{ http_build_query(array_diff_key($filterParams, ['kategori' => true])) }}#produk"
                >
                    <i class="fa-solid fa-rotate-left"></i>
                    Semua Kategori
                </a>
            @else
                <a
                    class="tm-all-categories"
                    href="#produk"
                >
                    Lihat Produk Pasar
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            @endif

        </div>

        <div class="categories">

            @foreach($categoriesList as $catName => $catInfo)

                @php
                    $isActive = ($kategori ?? '') === $catName;
                @endphp

                <a
                    class="category-card-link"
                    href="{{ url('/') }}?{{ http_build_query(array_merge($filterParams, ['kategori' => $catName])) }}#produk"
                    aria-label="Lihat kategori {{ $catName }}"
                >

                    <div class="category {{ $isActive ? 'active-category' : '' }}">

                        <div class="category-icon">
                            {{ $catInfo['icon'] }}
                        </div>

                        <h3>{{ $catName }}</h3>

                        <p>{{ $catInfo['desc'] }}</p>

                        @if($isActive)
                            <small style="margin-top:9px;color:#178156;font-weight:800;">
                                ✓ Kategori Terpilih
                            </small>
                        @endif

                        <span class="tm-category-arrow">
                            <i class="fa-solid fa-arrow-right"></i>
                        </span>

                    </div>

                </a>

            @endforeach

        </div>

    </section>


    {{-- ========================================================
         3. SEARCH — SEMUA FITUR PENCARIAN LAMA DIPERTAHANKAN
    ======================================================== --}}

    <div class="tm-search-container" id="search-box">

        <div class="tm-search-box">

            <form
                action="{{ url('/') }}#produk"
                method="GET"
            >

                <div class="tm-search-input-group">

                    <div class="tm-search-input-wrap">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input
                            type="text"
                            name="q"
                            id="homeSearchInput"
                            placeholder="Cari benih, pupuk, pot, hasil panen..."
                            value="{{ $q ?? '' }}"
                            maxlength="100"
                            autocomplete="off"
                            aria-label="Cari produk pertanian"
                        >

                        @if(!empty($q))
                            <a
                                href="{{ url('/') }}?{{ http_build_query(array_diff_key($filterParams, ['q' => true])) }}#produk"
                                title="Bersihkan kata kunci"
                                aria-label="Hapus kata kunci"
                                style="color:#94a3b8;margin-left:8px;"
                            >
                                ✕
                            </a>
                        @endif

                    </div>

                    {{-- PILIH KATEGORI --}}

                    <select
                        name="kategori"
                        class="tm-search-select-category"
                        aria-label="Filter kategori"
                    >

                        <option value="">
                            Semua Kategori
                        </option>

                        @foreach($categoriesList as $catName => $catInfo)
                            <option
                                value="{{ $catName }}"
                                @selected(($kategori ?? '') === $catName)
                            >
                                {{ $catInfo['icon'] }} {{ $catName }}
                            </option>
                        @endforeach

                    </select>

                    {{-- SORT DAN STOK TETAP DIKIRIM --}}

                    <input
                        type="hidden"
                        name="sort"
                        value="{{ $sort ?? 'terbaru' }}"
                    >

                    <input
                        type="hidden"
                        name="stok"
                        value="{{ $stok ?? '' }}"
                    >

                    <button
                        type="submit"
                        class="btn-search-submit"
                    >
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Cari Produk</span>
                    </button>

                </div>

                {{-- PENCARIAN POPULER --}}

                <div class="tm-popular-tags">

                    <span class="tm-popular-label">
                        <i
                            class="fa-solid fa-fire"
                            style="color:#ef4444;"
                        ></i>
                        Populer:
                    </span>

                    <a
                        href="{{ url('/') }}?q=Cabai#produk"
                        class="tm-tag-pill"
                    >
                        🌶️ Benih Cabai
                    </a>

                    <a
                        href="{{ url('/') }}?q=Pupuk+Organik#produk"
                        class="tm-tag-pill"
                    >
                        🌿 Pupuk Organik
                    </a>

                    <a
                        href="{{ url('/') }}?q=Pot#produk"
                        class="tm-tag-pill"
                    >
                        🪴 Pot Minimalis
                    </a>

                    <a
                        href="{{ url('/') }}?q=Media+Tanam#produk"
                        class="tm-tag-pill"
                    >
                        🌱 Media Tanam
                    </a>

                    <a
                        href="{{ url('/') }}?q=Tomat#produk"
                        class="tm-tag-pill"
                    >
                        🍅 Benih Tomat
                    </a>

                    <a
                        href="{{ url('/') }}?q=Alat+Semprot#produk"
                        class="tm-tag-pill"
                    >
                        🧰 Alat Semprot
                    </a>

                </div>

            </form>
        </div>

    </div>


    {{-- ========================================================
         4. PRODUK PASAR — DATA MYSQL ASLI
    ======================================================== --}}

    <section class="section" id="produk">

        <div class="product-heading">

            <div>

                <span class="product-eyebrow">
                    <i class="fa-solid fa-certificate"></i>
                    PRODUK PASAR TANIMART
                </span>

                <h2>Produk Pilihan Pasar Tani</h2>

                <p class="section-description">
                    Jelajahi produk pertanian yang ditawarkan
                    oleh para penjual di TaniMart.
                </p>

            </div>

            @auth
                <a
                    href="{{ route('products.create') }}"
                    class="btn btn-primary"
                    style="font-size:12px;border-radius:999px;"
                >
                    <i class="fa-solid fa-store"></i>
                    Jual Produk Saya
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="btn btn-secondary"
                    style="font-size:12px;border-radius:999px;"
                >
                    Masuk untuk Berjualan
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            @endauth

        </div>


        {{-- ========================================================
             FILTER YANG SEDANG AKTIF
        ======================================================== --}}

        <div class="tm-filter-sort-bar">

            <div class="tm-filter-status">

                <span
                    style="font-size:13px;color:#4e6857;font-weight:600;"
                >
                    Menampilkan
                    <strong>{{ $products->count() }}</strong>
                    produk
                </span>

                {{-- FILTER KATA KUNCI --}}

                @if(!empty($q))
                    <span class="tm-filter-badge">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        "{{ $q }}"

                        <a
                            href="{{ url('/') }}?{{ http_build_query(array_diff_key($filterParams, ['q' => true])) }}#produk"
                            title="Hapus filter pencarian"
                            aria-label="Hapus filter pencarian"
                            style="color:inherit;text-decoration:none;font-weight:800;"
                        >
                            ✕
                        </a>

                    </span>
                @endif

                {{-- FILTER KATEGORI --}}

                @if(!empty($kategori))
                    <span class="tm-filter-badge">

                        <i class="fa-solid fa-tag"></i>

                        {{ $kategori }}

                        <a
                            href="{{ url('/') }}?{{ http_build_query(array_diff_key($filterParams, ['kategori' => true])) }}#produk"
                            title="Hapus filter kategori"
                            aria-label="Hapus filter kategori"
                            style="color:inherit;text-decoration:none;font-weight:800;"
                        >
                            ✕
                        </a>

                    </span>
                @endif

                {{-- FILTER STOK --}}

                @if(!empty($stok))
                    <span class="tm-filter-badge">

                        <i class="fa-solid fa-box"></i>

                        {{ $stok === 'habis' ? 'Stok Habis' : 'Stok Tersedia' }}

                        <a
                            href="{{ url('/') }}?{{ http_build_query(array_diff_key($filterParams, ['stok' => true])) }}#produk"
                            title="Hapus filter stok"
                            aria-label="Hapus filter stok"
                            style="color:inherit;text-decoration:none;font-weight:800;"
                        >
                            ✕
                        </a>

                    </span>
                @endif

                @if($hasActiveFilter)
                    <a
                        href="{{ url('/') }}#produk"
                        class="btn-reset-filter"
                    >
                        <i class="fa-solid fa-rotate-left"></i>
                        Reset Semua Filter
                    </a>
                @endif

            </div>

            {{-- ====================================================
                 FILTER STOK DAN SORTING
            ==================================================== --}}

            <div class="tm-stock-filter-controls">

                <form
                    action="{{ url('/') }}#produk"
                    method="GET"
                    class="tm-sort-wrapper"
                    style="display:flex;align-items:center;flex-wrap:wrap;gap:9px;"
                >

                    <input
                        type="hidden"
                        name="q"
                        value="{{ $q ?? '' }}"
                    >

                    <input
                        type="hidden"
                        name="kategori"
                        value="{{ $kategori ?? '' }}"
                    >

                    <label
                        for="stockSelector"
                        class="tm-stock-filter-label"
                    >
                        <i class="fa-solid fa-box"></i>
                        Stok:
                    </label>

                    <select
                        name="stok"
                        id="stockSelector"
                        class="tm-stock-select"
                        onchange="this.form.submit()"
                    >

                        <option
                            value=""
                            @selected(empty($stok))
                        >
                            Semua Stok
                        </option>

                        <option
                            value="tersedia"
                            @selected(($stok ?? '') === 'tersedia')
                        >
                            Stok Tersedia
                        </option>

                        <option
                            value="habis"
                            @selected(($stok ?? '') === 'habis')
                        >
                            Stok Habis
                        </option>

                    </select>

                    <label
                        for="sortSelector"
                        class="tm-stock-filter-label"
                    >
                        <i class="fa-solid fa-arrow-down-short-wide"></i>
                        Urutkan:
                    </label>

                    <select
                        name="sort"
                        id="sortSelector"
                        class="tm-sort-select"
                        onchange="this.form.submit()"
                    >

                        <option
                            value="terbaru"
                            @selected(($sort ?? 'terbaru') === 'terbaru')
                        >
                            Produk Terbaru
                        </option>

                        <option
                            value="termurah"
                            @selected(($sort ?? 'terbaru') === 'termurah')
                        >
                            Harga: Terendah
                        </option>

                        <option
                            value="termahal"
                            @selected(($sort ?? 'terbaru') === 'termahal')
                        >
                            Harga: Tertinggi
                        </option>

                    </select>

                </form>

            </div>

        </div>


        {{-- ========================================================
             GRID PRODUK — TETAP DARI DATABASE
        ======================================================== --}}

        <div class="product-grid" id="tmProductGrid">

            @forelse($products as $prod)

                @php
                    $availableStock = max(
                        0,
                        (int) ($prod->stock ?? 0)
                    );

                    $isProductActive =
                        ($prod->status ?? 'tersedia') === 'tersedia';

                    $canBuyProduct =
                        $isProductActive && $availableStock > 0;
                @endphp

                <article
                    class="product-card {{ $loop->index >= 8 ? 'tm-extra-product' : '' }}"
                    @if($loop->index >= 8) hidden @endif
                >

                    {{-- ============================================
                         FOTO PRODUK
                    ============================================ --}}

                    <a
                        href="{{ route('products.show', $prod->slug) }}"
                        style="text-decoration:none;color:inherit;display:block;"
                    >

                        <div class="product-image">

                            @if($prod->image)
                                <img
                                    src="{{ asset($prod->image) }}"
                                    alt="{{ $prod->name }}"
                                    loading="lazy"
                                >
                            @else
                                <span class="product-emoji">
                                    {{ $prod->icon ?? '🌱' }}
                                </span>
                            @endif

                            <span class="product-badge">
                                {{ $prod->category }}
                            </span>

                            @if($availableStock === 0)
                                <span class="tm-out-of-stock">
                                    Stok Habis
                                </span>
                            @elseif(!$isProductActive)
                                <span class="tm-out-of-stock">
                                    Tidak Tersedia
                                </span>
                            @endif

                        </div>

                    </a>


                    {{-- ============================================
                         INFORMASI PRODUK
                    ============================================ --}}

                    <div class="product-info">

                        <p class="product-category">
                            <i class="fa-solid fa-seedling"></i>
                            {{ $prod->category }}
                        </p>

                        <h3 class="product-name">

                            <a
                                href="{{ route('products.show', $prod->slug) }}"
                                style="color:inherit;text-decoration:none;"
                            >
                                {{ $prod->name }}
                            </a>

                        </h3>

                        <p class="product-description">
                            {{ \Illuminate\Support\Str::limit($prod->description ?? 'Produk pertanian dari mitra TaniMart.', 80) }}
                        </p>

                        {{-- SELLER --}}

                        <p class="tm-seller-line">

                            <i class="fa-solid fa-store"></i>

                            {{ $prod->user->name ?? 'Mitra TaniMart' }}

                            <span style="margin:0 4px;">
                                •
                            </span>

                            <i class="fa-solid fa-location-dot"></i>

                            {{ $prod->location ?? 'Indonesia' }}

                        </p>

                        {{-- STATUS STOK --}}

                        <p class="tm-stock-line {{ $canBuyProduct ? ($availableStock <= 10 ? 'is-low' : 'is-ready') : 'is-empty' }}">

                            @if($availableStock === 0)

                                <i class="fa-solid fa-circle-xmark"></i>
                                Stok Habis

                            @elseif(!$isProductActive)

                                <i class="fa-solid fa-circle-xmark"></i>
                                Tidak Tersedia

                            @elseif($availableStock <= 10)

                                <i class="fa-solid fa-box-open"></i>

                                Stok Terbatas:
                                {{ $availableStock }}
                                {{ $prod->unit ?? 'pcs' }}

                            @else

                                <i class="fa-solid fa-circle-check"></i>

                                Stok Tersedia:
                                {{ $availableStock }}
                                {{ $prod->unit ?? 'pcs' }}

                            @endif

                        </p>


                        {{-- ========================================
                             HARGA DAN ACTION BUTTON
                        ======================================== --}}

                        <div class="product-bottom">

                            <div>

                                <p class="product-price">
                                    Rp {{ number_format($prod->price, 0, ',', '.') }}
                                </p>

                                <small
                                    style="font-size:10px;color:#718475;"
                                >
                                    / {{ $prod->unit ?? 'pcs' }}
                                </small>

                            </div>

                            <div class="tm-product-buttons">

                                {{-- CHAT PENJUAL --}}

                                @if(
                                    $prod->user_id &&
                                    (
                                        !auth()->check() ||
                                        auth()->id() !== $prod->user_id
                                    )
                                )
                                    <a
                                        href="{{ route('chat.index', ['user_id' => $prod->user_id, 'product_id' => $prod->id]) }}"
                                        class="btn-chat-seller"
                                        title="Chat Penjual"
                                    >
                                        <i class="fa-solid fa-comment-dots"></i>
                                    </a>
                                @endif

                                {{-- KERANJANG DATABASE --}}

                                <form
                                    action="{{ url('/keranjang/tambah/' . $prod->id) }}"
                                    method="POST"
                                    style="margin:0;"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="add-cart"
                                        title="{{ $canBuyProduct ? 'Tambah ke keranjang' : 'Produk tidak dapat dibeli' }}"
                                        aria-label="{{ $canBuyProduct ? 'Tambah '.$prod->name.' ke keranjang' : 'Produk tidak dapat dibeli' }}"
                                        @disabled(!$canBuyProduct)
                                    >
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </button>

                                </form>

                                {{-- DETAIL PRODUK --}}

                                <a
                                    href="{{ route('products.show', $prod->slug) }}"
                                    class="tm-detail-btn"
                                    title="Lihat Detail Produk"
                                >
                                    Detail
                                </a>

                            </div>

                        </div>

                    </div>

                </article>


            @empty

                {{-- =================================================
                     EMPTY STATE — PERTAHANKAN PENCARIAN KOSONG
                ================================================= --}}

                <div class="tm-search-empty-state">

                    <span class="tm-empty-icon">
                        🔍🌱
                    </span>

                    <h3 class="tm-empty-title">

                        @if(!empty($q))
                            Produk "{{ $q }}" Tidak Ditemukan

                        @elseif(!empty($kategori))
                            Belum Ada Produk di Kategori "{{ $kategori }}"

                        @elseif(($stok ?? '') === 'habis')
                            Tidak Ada Produk dengan Stok Habis

                        @elseif(($stok ?? '') === 'tersedia')
                            Tidak Ada Produk dengan Stok Tersedia

                        @else
                            Belum Ada Produk yang Dipasang
                        @endif

                    </h3>

                    <p class="tm-empty-desc">

                        @if(!empty($q))
                            Coba periksa ejaan kata kunci,
                            gunakan istilah yang lebih umum,
                            atau pilih kategori pertanian lain.

                        @elseif(!empty($kategori) || !empty($stok))
                            Coba gunakan kategori lain
                            atau reset filter untuk
                            melihat produk lainnya.

                        @else
                            Jadilah yang pertama memasang
                            produk pertanian di TaniMart!
                        @endif

                    </p>

                    <div
                        style="display:flex;justify-content:center;gap:12px;flex-wrap:wrap;"
                    >

                        <a
                            href="{{ url('/') }}#produk"
                            class="btn btn-primary"
                        >
                            <i class="fa-solid fa-rotate-left"></i>
                            Lihat Semua Produk
                        </a>

                        @auth
                            <a
                                href="{{ route('products.create') }}"
                                class="btn btn-secondary"
                            >
                                <i class="fa-solid fa-plus"></i>
                                Pasang Produk
                            </a>
                        @endauth

                    </div>

                </div>


                {{-- =================================================
                     REKOMENDASI PRODUK
                ================================================= --}}

                @if(isset($recommended) && $recommended->isNotEmpty())

                    <div
                        style="grid-column:1/-1;margin-top:30px;"
                    >

                        <h3
                            style="font-size:18px;color:#004631;margin-bottom:20px;"
                        >
                            <i
                                class="fa-solid fa-star"
                                style="color:#d79f20;"
                            ></i>

                            Rekomendasi Produk Lainnya untuk Anda
                        </h3>

                        <div class="product-grid">

                            @foreach($recommended as $rec)

                                @php
                                    $recStock = max(
                                        0,
                                        (int) ($rec->stock ?? 0)
                                    );

                                    $recActive =
                                        ($rec->status ?? 'tersedia') === 'tersedia';

                                    $recCanBuy =
                                        $recActive && $recStock > 0;
                                @endphp

                                <article class="product-card">

                                    <a
                                        href="{{ route('products.show', $rec->slug) }}"
                                        style="color:inherit;text-decoration:none;display:block;"
                                    >

                                        <div class="product-image">

                                            @if($rec->image)

                                                <img
                                                    src="{{ asset($rec->image) }}"
                                                    alt="{{ $rec->name }}"
                                                    loading="lazy"
                                                >

                                            @else

                                                <span class="product-emoji">
                                                    {{ $rec->icon ?? '🌱' }}
                                                </span>

                                            @endif

                                            <span class="product-badge">
                                                {{ $rec->category }}
                                            </span>

                                            @if($recStock <= 0)

                                                <span class="tm-out-of-stock">
                                                    Stok Habis
                                                </span>

                                            @elseif(!$recActive)

                                                <span class="tm-out-of-stock">
                                                    Tidak Tersedia
                                                </span>

                                            @endif

                                        </div>

                                    </a>

                                    <div class="product-info">

                                        <p class="product-category">
                                            {{ $rec->category }}
                                        </p>

                                        <h3 class="product-name">

                                            <a
                                                href="{{ route('products.show', $rec->slug) }}"
                                                style="color:inherit;text-decoration:none;"
                                            >
                                                {{ $rec->name }}
                                            </a>

                                        </h3>

                                        <p class="product-description">
                                            {{ \Illuminate\Support\Str::limit($rec->description ?? 'Produk pertanian TaniMart.', 75) }}
                                        </p>

                                        <p class="tm-seller-line">

                                            <i class="fa-solid fa-store"></i>

                                            {{ $rec->user->name ?? 'Mitra TaniMart' }}

                                        </p>

                                        <p class="tm-stock-line {{ $recCanBuy ? 'is-ready' : 'is-empty' }}">

                                            @if($recCanBuy)
                                                Stok: {{ $recStock }}
                                                {{ $rec->unit ?? 'pcs' }}
                                            @else
                                                Tidak tersedia
                                            @endif

                                        </p>

                                        <div class="product-bottom">

                                            <p class="product-price">
                                                Rp {{ number_format($rec->price, 0, ',', '.') }}
                                            </p>

                                            <div class="tm-product-buttons">

                                                @if(
                                                    $rec->user_id &&
                                                    (
                                                        !auth()->check() ||
                                                        auth()->id() !== $rec->user_id
                                                    )
                                                )
                                                    <a
                                                        href="{{ route('chat.index', ['user_id' => $rec->user_id, 'product_id' => $rec->id]) }}"
                                                        class="btn-chat-seller"
                                                        title="Chat Penjual"
                                                    >
                                                        <i class="fa-solid fa-comment-dots"></i>
                                                    </a>
                                                @endif

                                                <form
                                                    action="{{ url('/keranjang/tambah/' . $rec->id) }}"
                                                    method="POST"
                                                    style="margin:0;"
                                                >

                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="add-cart"
                                                        title="{{ $recCanBuy ? 'Tambah ke keranjang' : 'Tidak tersedia' }}"
                                                        @disabled(!$recCanBuy)
                                                    >
                                                        <i class="fa-solid fa-cart-plus"></i>
                                                    </button>

                                                </form>

                                                <a
                                                    href="{{ route('products.show', $rec->slug) }}"
                                                    class="tm-detail-btn"
                                                >
                                                    Detail
                                                </a>

                                            </div>

                                        </div>

                                    </div>

                                </article>

                            @endforeach

                        </div>

                    </div>

                @endif

            @endforelse

        </div>


        {{-- TAMPILKAN LEBIH BANYAK
             Produk ke-9 dan seterusnya tetap ada.
             Hanya disembunyikan sementara di browser. --}}

        @if($products->count() > 8)

            <div class="tm-more-wrap">

                <button
                    type="button"
                    id="tmLoadMore"
                    class="tm-more-btn"
                    aria-expanded="false"
                >
                    <span>Tampilkan Lebih Banyak Produk Pasar</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>

            </div>

        @endif

    </section>


    {{-- ========================================================
         5. BANNER KONSULTASI AI
    ======================================================== --}}

    <section class="section" id="ai">

        <div class="ai-card">

            <div class="tm-ai-content">

                <span class="tm-ai-label">

                    <i class="fa-solid fa-robot"></i>

                    ASISTEN AI PERTANIAN TANIMART

                </span>

                <h2>
                    Bingung Merawat<br>
                    Tanamanmu?
                </h2>

                <p>
                    Dapatkan informasi dan saran perawatan tanaman
                    melalui asisten AI TaniMart.
                    Tanyakan gejala pada tanaman,
                    kebutuhan pupuk, dan tips budidaya.
                </p>

                <div class="tm-ai-chips">

                    <span>
                        <i class="fa-solid fa-leaf"></i>
                        Kesehatan Tanaman
                    </span>

                    <span>
                        <i class="fa-solid fa-flask"></i>
                        Nutrisi dan Pupuk
                    </span>

                    <span>
                        <i class="fa-solid fa-sun"></i>
                        Tips Budidaya
                    </span>

                </div>

                <a
                    href="{{ url('/konsultasi') }}"
                    class="btn ai-button"
                >
                    <i class="fa-regular fa-comment-dots"></i>
                    Mulai Konsultasi Gratis
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>


            {{-- ILUSTRASI OBROLAN
                 BUKAN HASIL AI REAL-TIME --}}

            <div class="tm-ai-demo">

                <div class="tm-ai-question">

                    <strong>
                        <i class="fa-solid fa-user"></i>
                        Contoh Pertanyaan Petani
                    </strong>

                    <div style="margin-top:10px;">
                        "Daun cabai saya menguning dan
                        mulai menggulung. Apa penyebabnya?"
                    </div>

                </div>

                <div class="tm-ai-answer">

                    <strong>
                        <i class="fa-solid fa-robot"></i>
                        Asisten AI TaniMart
                    </strong>

                    <p>
                        Daun menguning dapat disebabkan oleh
                        beberapa faktor. Sebaiknya periksa:
                    </p>

                    <ul>
                        <li>
                            Kelembapan dan drainase media tanam.
                        </li>

                        <li>
                            Ketersediaan nutrisi tanaman.
                        </li>

                        <li>
                            Tanda hama atau perubahan
                            pada bagian daun.
                        </li>
                    </ul>

                    <small>
                        *Ilustrasi percakapan. Jawaban sebenarnya
                        dihasilkan melalui fitur konsultasi AI.
                    </small>

                </div>

            </div>

        </div>

    </section>


    {{-- ========================================================
         6. KEUNGGULAN TANIMART
    ======================================================== --}}

    <section class="section" id="tm-benefits">

        <div class="tm-benefits-title">

            <span>
                STANDAR PELAYANAN TANIMART
            </span>

            <h2>
                Kenapa Berbelanja di TaniMart?
            </h2>

            <p>
                TaniMart membantu menghubungkan penjual
                dan pembeli dalam satu marketplace pertanian
                dengan dukungan teknologi digital.
            </p>

        </div>


        <div class="tm-benefit-grid">

            {{-- BENEFIT 1 --}}

            <div class="tm-benefit-card">

                <div class="tm-benefit-icon">
                    <i class="fa-solid fa-handshake"></i>
                </div>

                <h3>
                    Belanja dari Penjual Lokal
                </h3>

                <p>
                    Temukan kebutuhan pertanian
                    yang ditawarkan oleh berbagai penjual
                    melalui marketplace TaniMart.
                </p>

            </div>


            {{-- BENEFIT 2 --}}

            <div class="tm-benefit-card">

                <div class="tm-benefit-icon">
                    <i class="fa-solid fa-seedling"></i>
                </div>

                <h3>
                    Beragam Produk Pertanian
                </h3>

                <p>
                    Jelajahi benih, pupuk, media tanam,
                    perlengkapan berkebun, serta
                    hasil panen dari penjual.
                </p>

            </div>


            {{-- BENEFIT 3 --}}

            <div class="tm-benefit-card">

                <div class="tm-benefit-icon">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>

                <h3>
                    Pengelolaan Pesanan
                </h3>

                <p>
                    Pantau perubahan status pesanan
                    melalui sistem transaksi
                    untuk pembeli dan penjual.
                </p>

            </div>


            {{-- BENEFIT 4 --}}

            <div class="tm-benefit-card">

                <div class="tm-benefit-icon">
                    <i class="fa-solid fa-robot"></i>
                </div>

                <h3>
                    Konsultasi AI Pertanian
                </h3>

                <p>
                    Dapatkan bantuan informasi tentang
                    budidaya dan perawatan tanaman
                    melalui asisten AI TaniMart.
                </p>

            </div>

        </div>

    </section>


    {{-- ========================================================
         FOOTER ASLI
         Tidak mengubah struktur maupun link Laravel.
    ======================================================== --}}

    @include('partials.footer')


    {{-- ========================================================
         JAVASCRIPT: TAMPILKAN PRODUK TAMBAHAN
         Hanya mengubah tampilan, tidak memodifikasi database.
    ======================================================== --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const moreButton = document.getElementById('tmLoadMore');
            const productGrid = document.getElementById('tmProductGrid');

            if (!moreButton || !productGrid) {
                return;
            }

            const extraProducts = productGrid.querySelectorAll(
                '.tm-extra-product'
            );

            moreButton.addEventListener('click', function () {

                const expanded =
                    moreButton.getAttribute('aria-expanded') === 'true';

                extraProducts.forEach(function (card) {
                    card.hidden = expanded;
                });

                moreButton.setAttribute(
                    'aria-expanded',
                    String(!expanded)
                );

                if (expanded) {

                    moreButton.innerHTML =
                        '<span>Tampilkan Lebih Banyak Produk Pasar</span>' +
                        '<i class="fa-solid fa-chevron-down"></i>';

                } else {

                    moreButton.innerHTML =
                        '<span>Tampilkan Lebih Sedikit Produk</span>' +
                        '<i class="fa-solid fa-chevron-up"></i>';

                }

            });

        });
    </script>

</body>
</html>
