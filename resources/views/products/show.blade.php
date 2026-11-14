<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | TaniMart</title>
    <meta name="description" content="{{ Str::limit($product->description ?? $product->name . ' - Produk pertanian berkualitas dari TaniMart.', 160) }}">
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* ===== BREADCRUMB ===== */
        .breadcrumb-wrap {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 10px 7%;
        }
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--text-muted);
            flex-wrap: wrap;
        }
        .breadcrumb a {
            color: var(--green-main);
            font-weight: 500;
            transition: color 0.2s;
        }
        .breadcrumb a:hover { color: var(--green-dark); }
        .breadcrumb-sep { opacity: 0.4; }
        .breadcrumb-current { color: var(--text-main); font-weight: 600; }

        /* ===== PRODUCT DETAIL SECTION ===== */
        .product-detail-section {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2.5rem 5% 3rem;
        }

        .product-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1.15fr;
            gap: 2.5rem;
            align-items: start;
        }

        /* Left column – Image */
        .product-detail-image-col {
            position: sticky;
            top: 90px;
        }

        .product-image-box {
            background: linear-gradient(135deg, #f0f7ec 0%, #e3f0de 100%);
            border-radius: 20px;
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1.5px solid var(--border);
            box-shadow: 0 8px 32px rgba(36, 88, 59, 0.1);
        }

        .product-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
        }

        .product-image-emoji {
            font-size: 8rem;
            line-height: 1;
            filter: drop-shadow(0 4px 12px rgba(0,0,0,0.12));
        }

        /* Right column – Info */
        .product-detail-info {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .product-detail-category-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--green-light);
            color: var(--green-dark);
            border-radius: 50px;
            padding: 4px 14px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            width: fit-content;
        }

        .product-detail-name {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.25;
            margin: 0;
        }

        .product-detail-price-block {
            display: flex;
            align-items: baseline;
            gap: 8px;
        }

        .product-detail-price {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--green-dark);
        }

        .product-detail-unit {
            font-size: 1rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .product-meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .product-meta-chip {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #f8f7f0;
            border: 1px solid var(--border);
            border-radius: 50px;
            padding: 6px 14px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-main);
        }

        .product-meta-chip i {
            color: var(--green-main);
        }

        .stock-badge-ok {
            color: #16a34a;
            font-weight: 700;
        }

        .stock-badge-low {
            color: #d97706;
            font-weight: 700;
        }

        .product-detail-divider {
            height: 1px;
            background: var(--border);
            border: none;
            margin: 0.25rem 0;
        }

        .product-detail-desc-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .product-detail-desc {
            font-size: 15px;
            line-height: 1.75;
            color: #3a4a3f;
            white-space: pre-line;
        }

        /* Seller card */
        .seller-card {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 16px;
            padding: 16px 20px;
            box-shadow: 0 2px 12px rgba(36, 88, 59, 0.05);
        }

        .seller-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--green-dark);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .seller-info strong {
            display: block;
            font-size: 15px;
            font-weight: 700;
            color: var(--text-main);
        }

        .seller-info small {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Action buttons */
        .product-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-add-cart {
            flex: 1;
            min-width: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--green-dark);
            color: #fff;
            border: none;
            border-radius: 14px;
            padding: 0.9rem 1.5rem;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(36, 88, 59, 0.25);
        }

        .btn-add-cart:hover {
            background: #1b4529;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(36, 88, 59, 0.3);
        }

        .btn-add-cart:active {
            transform: translateY(0);
        }

        .btn-chat-penjual {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #fff;
            color: var(--green-dark);
            border: 2px solid var(--green-dark);
            border-radius: 14px;
            padding: 0.9rem 1.4rem;
            font-size: 15px;
            font-weight: 700;
            transition: background 0.2s, color 0.2s, transform 0.15s;
            white-space: nowrap;
        }

        .btn-chat-penjual:hover {
            background: var(--green-light);
            transform: translateY(-2px);
        }

        /* ===== RELATED PRODUCTS ===== */
        .related-section {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 5% 4rem;
        }

        .related-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .related-title::after {
            content: '';
            flex: 1;
            height: 2px;
            background: var(--border);
            border-radius: 2px;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.25rem;
        }

        .related-card {
            background: #fff;
            border-radius: 16px;
            border: 1.5px solid var(--border);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .related-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(36, 88, 59, 0.12);
        }

        .related-card-img {
            background: linear-gradient(135deg, #f0f7ec, #e3f0de);
            height: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            overflow: hidden;
        }

        .related-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .related-card-body {
            padding: 12px 14px;
        }

        .related-card-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 4px;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-card-price {
            font-size: 14px;
            font-weight: 800;
            color: var(--green-dark);
        }

        .related-card-unit {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 400;
        }

        /* ===== PAGE FOOTER ===== */
        .page-footer {
            background: var(--green-dark);
            color: rgba(255,255,255,0.75);
            text-align: center;
            padding: 1.5rem;
            font-size: 13px;
        }

        .page-footer a {
            color: rgba(255,255,255,0.9);
            font-weight: 600;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .product-detail-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .product-detail-image-col {
                position: static;
            }

            .product-image-box {
                max-height: 280px;
            }

            .product-detail-name {
                font-size: 1.5rem;
            }

            .product-detail-price {
                font-size: 1.75rem;
            }

            .related-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .product-detail-section,
            .related-section {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    {{-- ===== BREADCRUMB ===== --}}
    <div class="breadcrumb-wrap">
        <nav class="breadcrumb" aria-label="breadcrumb">
            <a href="/"><i class="fa-solid fa-house" style="font-size:11px;"></i> Beranda</a>
            <span class="breadcrumb-sep">/</span>
            <a href="/?kategori={{ urlencode($product->category) }}">{{ $product->category }}</a>
            <span class="breadcrumb-sep">/</span>
            <span class="breadcrumb-current">{{ $product->name }}</span>
        </nav>
    </div>

    {{-- ===== TOAST ===== --}}
    @if(session('success'))
        <div class="site-toast site-toast-success" id="toastMsg">
            <span>✅ {{ session('success') }}</span>
            <span style="cursor: pointer; opacity: 0.7; margin-left: 8px;" onclick="this.parentElement.remove()">✕</span>
        </div>
        <script>setTimeout(() => { const el = document.getElementById('toastMsg'); if(el) el.remove(); }, 5000);</script>
    @endif

    {{-- ===== PRODUCT DETAIL ===== --}}
    <div class="product-detail-section">
        <div class="product-detail-grid">

            {{-- LEFT: Image --}}
            <div class="product-detail-image-col">
                <div class="product-image-box">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                    @else
                        <span class="product-image-emoji">{{ $product->icon ?? '🌱' }}</span>
                    @endif
                </div>
            </div>

            {{-- RIGHT: Info --}}
            <div class="product-detail-info">

                {{-- Category badge --}}
                <div>
                    <span class="product-detail-category-badge">
                        <i class="fa-solid fa-tag" style="font-size:10px;"></i>
                        {{ $product->category }}
                    </span>
                </div>

                {{-- Name --}}
                <h1 class="product-detail-name">{{ $product->name }}</h1>

                {{-- Price --}}
                <div class="product-detail-price-block">
                    <span class="product-detail-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                    <span class="product-detail-unit">/ {{ $product->unit ?? 'pcs' }}</span>
                </div>

                {{-- Meta chips: stok & lokasi --}}
                <div class="product-meta-row">
                    <div class="product-meta-chip">
                        <i class="fa-solid fa-boxes-stacking"></i>
                        @if(($product->stock ?? 0) > 10)
                            <span class="stock-badge-ok">Stok: {{ $product->stock ?? '–' }} {{ $product->unit ?? 'pcs' }}</span>
                        @elseif(($product->stock ?? 0) > 0)
                            <span class="stock-badge-low">Stok Terbatas: {{ $product->stock }} {{ $product->unit ?? 'pcs' }}</span>
                        @else
                            <span style="color:#ef4444; font-weight:700;">Stok Habis</span>
                        @endif
                    </div>
                    @if($product->location)
                    <div class="product-meta-chip">
                        <i class="fa-solid fa-location-dot" style="color:#ef4444;"></i>
                        {{ $product->location }}
                    </div>
                    @endif
                    <div class="product-meta-chip">
                        <i class="fa-solid fa-circle-check" style="color:#16a34a;"></i>
                        {{ ucfirst($product->status ?? 'tersedia') }}
                    </div>
                </div>

                <hr class="product-detail-divider">

                {{-- Description --}}
                <div>
                    <p class="product-detail-desc-label">Deskripsi Produk</p>
                    <p class="product-detail-desc">{{ $product->description ?? 'Produk pertanian berkualitas dari mitra terpercaya TaniMart.' }}</p>
                </div>

                <hr class="product-detail-divider">

                {{-- Seller card --}}
                <div class="seller-card">
                    <div class="seller-avatar">
                        {{ strtoupper(substr($product->user->name ?? 'T', 0, 1)) }}
                    </div>
                    <div class="seller-info">
                        <strong>{{ $product->user->name ?? 'Mitra TaniMart' }}</strong>
                        <small><i class="fa-solid fa-store" style="margin-right:4px;"></i>Penjual Produk</small>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="product-actions">
                    <form action="{{ url('/keranjang/tambah/' . $product->id) }}" method="POST" style="flex:1; margin:0;">
                        @csrf
                        <button type="submit" class="btn-add-cart" style="width:100%;">
                            <i class="fa-solid fa-cart-plus"></i>
                            Tambah ke Keranjang
                        </button>
                    </form>

                    @auth
                        @if($product->user_id && auth()->id() !== $product->user_id)
                            <a href="{{ route('chat.index', ['user_id' => $product->user_id, 'product_id' => $product->id]) }}"
                               class="btn-chat-penjual">
                                <i class="fa-solid fa-comment-dots"></i>
                                Chat Penjual
                            </a>
                        @endif
                    @else
                        <a href="{{ route('chat.index', ['user_id' => $product->user_id ?? 0, 'product_id' => $product->id]) }}"
                           class="btn-chat-penjual">
                            <i class="fa-solid fa-comment-dots"></i>
                            Chat Penjual
                        </a>
                    @endauth
                </div>

            </div>{{-- end info col --}}
        </div>{{-- end grid --}}
    </div>{{-- end detail section --}}

    {{-- ===== RELATED PRODUCTS ===== --}}
    @if($related->count() > 0)
    <div class="related-section">
        <h2 class="related-title">Produk Terkait</h2>
        <div class="related-grid">
            @foreach($related as $rel)
                <a href="{{ route('products.show', $rel->slug) }}" class="related-card">
                    <div class="related-card-img">
                        @if($rel->image)
                            <img src="{{ asset($rel->image) }}" alt="{{ $rel->name }}">
                        @else
                            {{ $rel->icon ?? '🌱' }}
                        @endif
                    </div>
                    <div class="related-card-body">
                        <p class="related-card-name">{{ $rel->name }}</p>
                        <p class="related-card-price">
                            Rp{{ number_format($rel->price, 0, ',', '.') }}
                            <span class="related-card-unit">/ {{ $rel->unit ?? 'pcs' }}</span>
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ===== FOOTER ===== --}}
    @include('partials.footer')

</body>
</html>
