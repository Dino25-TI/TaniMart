
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaniMart | Marketplace Pertanian</title>
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">

</head>

<body>

    <nav>
        <div class="logo">🌱 TaniMart</div>

        <div class="nav-links">
            <a href="{{ url('/keranjang') }}">Keranjang</a>
            <a href="#">Beranda</a>
            <a href="#kategori">Kategori</a>
            <a href="{{ url('/konsultasi') }}">Asisten AI</a>
            <a href="#produk">Produk</a>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <div class="tagline">TEMAN BERKEBUN ANDALANMU</div>

            <h1>Mulai Menanam, Tumbuhkan Harapan.</h1>

            <p>
                Temukan bibit, pupuk, pot, dan perlengkapan pertanian
                pilihan. Bingung memilih? Asisten AI kami siap membantumu.
            </p>

            <div class="buttons">
                <a href="#kategori" class="btn btn-primary">
                    Jelajahi Produk →
                </a>

                <a href="{{ url('/konsultasi') }}" class="btn btn-secondary">
                    ✨ Tanya AI
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

    <a href="/?kategori=bibit#produk" class="category">
        <div class="category-icon">🌱</div>
        <h3>Bibit Tanaman</h3>
        <p>Mulai dari benih berkualitas</p>
    </a>

    <a href="/?kategori=pot-media#produk" class="category">
        <div class="category-icon">🪴</div>
        <h3>Pot & Media Tanam</h3>
        <p>Tempat tumbuh tanamanmu</p>
    </a>

    <a href="/?kategori=pupuk#produk" class="category">
        <div class="category-icon">🌿</div>
        <h3>Pupuk</h3>
        <p>Dukung pertumbuhan tanaman</p>
    </a>

    <a href="/?kategori=alat#produk" class="category">
        <div class="category-icon">🧰</div>
        <h3>Alat Pertanian</h3>
        <p>Perlengkapan untuk berkebun</p>
    </a>

</div>

        </div>
    </section>

    <section class="section" id="ai">
        <div class="ai-card">
            <div>
                <h2>🌿 Bingung Merawat Tanaman?</h2>
                <p>
                    Ceritakan kebutuhanmu dan dapatkan panduan
                    serta rekomendasi produk yang relevan.
                </p>
            </div>

            <a href="{{ url('/konsultasi') }}" class="btn ai-button">
                Kenali Asisten AI →
            </a>
        </div>
    </section>

    
    <section class="section" id="produk">
        <div class="product-heading">
            <div>
                <span class="product-eyebrow">PILIHAN UNTUK KEBUNMU</span>
                <h2>Produk Pilihan</h2>
                <p class="section-description">
                    Temukan kebutuhan pertanian untuk membantu tanamanmu
                    tumbuh lebih sehat.
                </p>
            </div>

            <a href="#kategori" class="btn btn-secondary">
                Lihat Kategori →
            </a>
        </div>

@if ($kategori)
    <div class="category-filter-info">
        <span>Menampilkan produk berdasarkan kategori</span>

        <a href="{{ url('/') }}#produk">
            ✕ Lihat Semua Produk
        </a>
    </div>
@endif

 <div class="product-grid">

    @forelse ($products as $product)

        @php
            $emoji = [
                'cabai' => '🌶️',
                'media-tanam' => '🌱',
                'pot' => '🪴',
            ][$product->slug] ?? '🌿';
        @endphp

        <article class="product-card">

            <div class="product-image">
                <span class="product-emoji">
                    {{ $emoji }}
                </span>

                <span class="product-badge">
                    {{ $product->category->name }}
                </span>
            </div>

            <div class="product-info">

                <p class="product-category">
                    {{ $product->category->name }}
                </p>

                <h3 class="product-name">
                    {{ $product->name }}
                </h3>

                <p class="product-description">
                    {{ $product->description }}
                </p>

                <p>Stok: {{ $product->stock }}</p>

                <div class="product-bottom">

                    <p class="product-price">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <form
                        action="{{ url('/keranjang/tambah/' . $product->slug) }}"
                        method="POST">

                        @csrf

                        <button
                            class="add-cart"
                            type="submit"
                            aria-label="Tambah {{ $product->name }} ke keranjang"
                            @disabled($product->stock <= 0)>
                            +
                        </button>

                    </form>

                </div>

            </div>

        </article>

@empty
    <p>
        Belum ada produk untuk kategori ini.
        Silakan pilih kategori lainnya.
    </p>
    @endforelse

</div>
        </div>
    </section>


    <footer>
        © 2026 TaniMart. Tumbuh bersama, panen bersama.
    </footer>

</body>
</html>
