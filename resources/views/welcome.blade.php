@php
    $products = $products ?? \App\Models\Product::with('user')->where('status', 'tersedia')->latest()->get();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaniMart | Marketplace Pertanian & Asisten AI</title>
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    @include('partials.navbar')

    @if(session('success'))
        <div class="site-toast site-toast-success" id="toastMsg">
            <span>✅ {{ session('success') }}</span>
            <span style="cursor: pointer; opacity: 0.7; margin-left: 8px;" onclick="this.parentElement.remove()">✕</span>
        </div>
        <script>setTimeout(() => { const el = document.getElementById('toastMsg'); if(el) el.remove(); }, 5000);</script>
    @endif

    @if(session('error'))
        <div class="site-toast site-toast-error" id="toastMsg">
            <span>⚠️ {{ session('error') }}</span>
            <span style="cursor: pointer; opacity: 0.7; margin-left: 8px;" onclick="this.parentElement.remove()">✕</span>
        </div>
        <script>setTimeout(() => { const el = document.getElementById('toastMsg'); if(el) el.remove(); }, 5000);</script>
    @endif

    <section class="hero">
        <div class="hero-content">
            <div class="tagline">TEMAN BERKEBUN ANDALANMU</div>

            <h1>Mulai Menanam, Tumbuhkan Harapan.</h1>

            <p>
                Temukan bibit, pupuk, pot, dan hasil panen pilihan petani. Mau jual hasil kebunmu atau bingung memilih tanaman? Asisten AI & Marketplace TaniMart siap membantumu.
            </p>

            <div class="buttons">
                <a href="#produk" class="btn btn-primary">
                    Jelajahi Produk →
                </a>

                @auth
                    <a href="/jual-produk" class="btn btn-secondary" style="background: #ffffff; color: #24583b; border-color: #24583b; font-weight: 700;">
                        ➕ Jual Hasil Kebunmu
                    </a>
                @else
                    <a href="/login" class="btn btn-secondary" style="background: #ffffff; color: #24583b; border-color: #24583b; font-weight: 700;">
                        ➕ Mau Jual Produk? Masuk
                    </a>
                @endauth

                <a href="/konsultasi" class="btn" style="background: #eff6ff; color: #1d4ed8; border: 1.5px solid #bfdbfe; font-weight: 700;">
                    🤖 Tanya AI Pertanian
                </a>
            </div>
        </div>
    </section>

    <section class="section" id="kategori">
        <h2>Belanja Berdasarkan Kategori</h2>
        <p class="section-description">
            Temukan perlengkapan sesuai kebutuhan tanammu.
        </p>

        <div class="categories">
            <div class="category">
                <div class="category-icon">🌱</div>
                <h3>Bibit Tanaman</h3>
                <p>Mulai dari benih berkualitas</p>
            </div>

            <div class="category">
                <div class="category-icon">🪴</div>
                <h3>Pot & Media Tanam</h3>
                <p>Tempat tumbuh tanamanmu</p>
            </div>

            <div class="category">
                <div class="category-icon">🌿</div>
                <h3>Pupuk</h3>
                <p>Dukung pertumbuhan tanaman</p>
            </div>

            <div class="category">
                <div class="category-icon">🧰</div>
                <h3>Alat Pertanian</h3>
                <p>Perlengkapan untuk berkebun</p>
            </div>
        </div>
    </section>

    <section class="section" id="ai">
        <div class="ai-card">
            <div>
                <h2>🌿 Bingung Merawat Tanaman?</h2>
                <p>
                    Ceritakan keluhan tanamanmu kepada Asisten AI TaniMart dan dapatkan panduan penanganan serta rekomendasi produk yang relevan.
                </p>
            </div>

            <a href="/konsultasi" class="btn ai-button">
                Konsultasi AI Sekarang →
            </a>
        </div>
    </section>

    <section class="section" id="produk">
        <div class="product-heading">
            <div>
                <span class="product-eyebrow">PILIHAN UNTUK KEBUNMU</span>
                <h2>Produk Pilihan Pasar</h2>
                <p class="section-description">
                    Beli langsung dari petani terpercaya atau pasang produk jualan Anda sendiri.
                </p>
            </div>

            @auth
                <a href="/jual-produk" class="btn btn-primary" style="font-size: 13px;">
                    ➕ Jual Produk Saya
                </a>
            @else
                <a href="/login" class="btn btn-secondary">
                    Masuk untuk Berjualan →
                </a>
            @endauth
        </div>

        <div class="product-grid">

            @forelse($products as $prod)
                <article class="product-card">
                    <div class="product-image">
                        @if($prod->image)
                            <img src="{{ asset($prod->image) }}" alt="{{ $prod->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <span class="product-emoji">{{ $prod->icon ?? '🌱' }}</span>
                        @endif
                        <span class="product-badge">{{ $prod->category }}</span>
                    </div>

                    <div class="product-info">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <p class="product-category" style="margin-bottom: 0;">{{ $prod->category }}</p>
                            <small style="color: #64748b; font-size: 11px;"><i class="fa-solid fa-location-dot" style="color: #ef4444;"></i> {{ $prod->location ?? 'Indonesia' }}</small>
                        </div>

                        <h3 class="product-name">{{ $prod->name }}</h3>
                        
                        <p class="product-description">
                            {{ Str::limit($prod->description ?? 'Produk segar pilihan petani mitra TaniMart.', 85) }}
                        </p>

                        <div style="font-size: 11px; color: #3b6b47; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-user-check"></i>
                            <span>Penjual: <strong>{{ $prod->user->name ?? 'Mitra TaniMart' }}</strong></span>
                        </div>

                        <div class="product-bottom">
                            <p class="product-price">
                                Rp{{ number_format($prod->price, 0, ',', '.') }}
                                <span style="font-size: 11px; font-weight: normal; color: #64748b;">/ {{ $prod->unit ?? 'pcs' }}</span>
                            </p>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                @if($prod->user_id && (!auth()->check() || auth()->id() !== $prod->user_id))
                                    <a href="{{ route('chat.index', ['user_id' => $prod->user_id, 'product_id' => $prod->id]) }}" 
                                       class="btn-chat-seller" 
                                       title="Chat Penjual (Tanya Stok & Produk)">
                                        <i class="fa-solid fa-comment-dots"></i> Chat
                                    </a>
                                @endif
                                <form action="{{ url('/keranjang/tambah/' . $prod->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button class="add-cart" type="submit" aria-label="Tambah {{ $prod->name }} ke keranjang" title="Tambah ke keranjang">
                                        +
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem 1rem; color: #758176;">
                    <p style="font-size: 1.1rem; margin-bottom: 1rem;">Belum ada produk yang dipasang.</p>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">Mulai Jual Produk Pertama →</a>
                </div>
            @endforelse

        </div>
    </section>

    <footer>
        © 2026 TaniMart. Tumbuh bersama, panen bersama.
    </footer>

</body>
</html>
