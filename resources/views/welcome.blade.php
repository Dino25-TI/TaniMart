@php
    $categoriesList = [
        'Bibit Tanaman'          => ['icon' => '🌱', 'desc' => 'Mulai dari benih berkualitas'],
        'Pot & Perlengkapan'     => ['icon' => '🪴', 'desc' => 'Tempat tumbuh tanamanmu'],
        'Pupuk & Nutrisi'        => ['icon' => '🌿', 'desc' => 'Dukung pertumbuhan tanaman'],
        'Alat Pertanian'         => ['icon' => '🧰', 'desc' => 'Perlengkapan untuk berkebun'],
    ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaniMart | Marketplace Pertanian & Asisten AI</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <meta name="description" content="{{ $kategori ? 'Produk pertanian kategori ' . $kategori . ' di TaniMart. Belanja bibit, pupuk, alat tani langsung dari petani.' : 'TaniMart — Marketplace pertanian modern. Temukan bibit, pupuk, alat berkebun, dan konsultasi AI untuk petani Indonesia.' }}">
    <meta name="theme-color" content="#34754a">
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    @include('partials.navbar')

    {{-- Flash Notifications --}}
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

    {{-- HERO SECTION --}}
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
                    <a href="{{ route('products.create') }}" class="btn btn-secondary" style="background: #ffffff; color: #24583b; border-color: #24583b; font-weight: 700;">
                        ➕ Jual Hasil Kebunmu
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary" style="background: #ffffff; color: #24583b; border-color: #24583b; font-weight: 700;">
                        ➕ Mau Jual Produk? Masuk
                    </a>
                @endauth

                <a href="/konsultasi" class="btn" style="background: #eff6ff; color: #1d4ed8; border: 1.5px solid #bfdbfe; font-weight: 700;">
                    🤖 Tanya AI Pertanian
                </a>
            </div>
        </div>
    </section>

    {{-- DEDICATED SEARCH BAR CARD --}}
    <div class="tm-search-container" id="search-box">
        <div class="tm-search-box">
            <form action="/" method="GET">
                <div class="tm-search-input-group">
                    <div class="tm-search-input-wrap">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input 
                            type="text" 
                            name="q" 
                            id="homeSearchInput"
                            placeholder="Cari produk (contoh: benih cabai, pupuk organik, pot minimalis)..." 
                            value="{{ $q ?? '' }}"
                            autocomplete="off"
                        >
                        @if(!empty($q))
                            <a href="/{{ $kategori ? '?kategori=' . urlencode($kategori) : '' }}#produk" style="color: #94a3b8; font-size: 14px; text-decoration: none; margin-left: 8px;" title="Bersihkan kata kunci">✕</a>
                        @endif
                    </div>

                    <select name="kategori" class="tm-search-select-category">
                        <option value="">Semua Kategori</option>
                        <option value="Bibit Tanaman" {{ ($kategori === 'Bibit Tanaman') ? 'selected' : '' }}>🌱 Bibit Tanaman</option>
                        <option value="Pot & Perlengkapan" {{ ($kategori === 'Pot & Perlengkapan') ? 'selected' : '' }}>🪴 Pot & Perlengkapan</option>
                        <option value="Pupuk & Nutrisi" {{ ($kategori === 'Pupuk & Nutrisi') ? 'selected' : '' }}>🌿 Pupuk & Nutrisi</option>
                        <option value="Alat Pertanian" {{ ($kategori === 'Alat Pertanian') ? 'selected' : '' }}>🧰 Alat Pertanian</option>
                        <option value="Media Tanam" {{ ($kategori === 'Media Tanam') ? 'selected' : '' }}>🌾 Media Tanam</option>
                        <option value="Hasil Panen & Sayuran" {{ ($kategori === 'Hasil Panen & Sayuran') ? 'selected' : '' }}>🥕 Hasil Panen</option>
                    </select>

                    <button type="submit" class="btn-search-submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Cari Produk</span>
                    </button>
                </div>

                {{-- Popular Search Tags --}}
                <div class="tm-popular-tags">
                    <span class="tm-popular-label">
                        <i class="fa-solid fa-fire" style="color: #ef4444;"></i> Populer:
                    </span>
                    <a href="/?q=Cabai#produk" class="tm-tag-pill">🌶️ Benih Cabai</a>
                    <a href="/?q=Pupuk+Organik#produk" class="tm-tag-pill">🌿 Pupuk Organik</a>
                    <a href="/?q=Pot#produk" class="tm-tag-pill">🪴 Pot Minimalis</a>
                    <a href="/?q=Media+Tanam#produk" class="tm-tag-pill">🌱 Media Tanam</a>
                    <a href="/?q=Tomat#produk" class="tm-tag-pill">🍅 Benih Tomat</a>
                    <a href="/?q=Alat+Semprot#produk" class="tm-tag-pill">🧰 Alat Semprot</a>
                </div>
            </form>
        </div>
    </div>

    {{-- KATEGORI BELANJA --}}
    <section class="section" id="kategori">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.25rem;">
            <div>
                <h2>Belanja Berdasarkan Kategori</h2>
                <p class="section-description" style="margin-bottom: 0;">
                    Temukan perlengkapan pertanian sesuai kebutuhan tanammu.
                </p>
            </div>
            @if($kategori)
                <a href="/#kategori" class="btn-reset-filter" title="Reset Kategori">
                    <i class="fa-solid fa-rotate-left"></i> Semua Kategori
                </a>
            @endif
        </div>

        <div class="categories">
            @foreach($categoriesList as $catName => $catInfo)
                @php
                    $isActive = ($kategori === $catName);
                @endphp
                <a href="/?kategori={{ urlencode($catName) }}#produk" class="category-card-link">
                    <div class="category {{ $isActive ? 'active-category' : '' }}">
                        <div class="category-icon">{{ $catInfo['icon'] }}</div>
                        <h3>{{ $catName }}</h3>
                        <p>{{ $catInfo['desc'] }}</p>
                        @if($isActive)
                            <div style="margin-top: 8px; font-size: 11px; font-weight: 700; color: #166534;">
                                ✓ Kategori Terpilih
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ASISTEN AI CARD --}}
    <section class="section" id="ai">
        <div class="ai-card">
            <div>
                <h2>🌿 Bingung Merawat Tanaman?</h2>
                <p>
                    Ceritakan keluhan tanamanmu kepada Asisten AI TaniMart (berbasis Gemini) dan dapatkan panduan penanganan serta rekomendasi produk yang relevan.
                </p>
            </div>

            <a href="/konsultasi" class="btn ai-button">
                Konsultasi AI Sekarang →
            </a>
        </div>
    </section>

    {{-- PRODUK PASAR & FILTER HEADER --}}
    <section class="section" id="produk">
        <div class="product-heading" style="margin-bottom: 1rem;">
            <div>
                <span class="product-eyebrow">PILIHAN UNTUK KEBUNMU</span>
                <h2>Produk Pilihan Pasar</h2>
                <p class="section-description" style="margin-bottom: 0;">
                    Beli langsung dari petani terpercaya atau pasang produk jualan Anda sendiri.
                </p>
            </div>

            @auth
                <a href="{{ route('products.create') }}" class="btn btn-primary" style="font-size: 13px;">
                    ➕ Jual Produk Saya
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-secondary">
                    Masuk untuk Berjualan →
                </a>
            @endauth
        </div>

        {{-- Filter Status & Sorting Toolbar --}}
        <div class="tm-filter-sort-bar">
            <div class="tm-filter-status">
                <span style="font-size: 14px; color: #475569; font-weight: 600;">
                    Menampilkan <strong>{{ $products->count() }}</strong> produk
                </span>

                @if(!empty($q))
                    <span class="tm-filter-badge">
                        <i class="fa-solid fa-magnifying-glass"></i> "{{ $q }}"
                        <a href="/?{{ http_build_query(array_merge(request()->except('q'))) }}#produk" style="color: inherit; text-decoration: none; font-weight: 700;">✕</a>
                    </span>
                @endif

                @if(!empty($kategori))
                    <span class="tm-filter-badge">
                        <i class="fa-solid fa-tag"></i> {{ $kategori }}
                        <a href="/?{{ http_build_query(array_merge(request()->except('kategori'))) }}#produk" style="color: inherit; text-decoration: none; font-weight: 700;">✕</a>
                    </span>
                @endif

                @if(!empty($q) || !empty($kategori))
                    <a href="/#produk" class="btn-reset-filter">
                        <i class="fa-solid fa-rotate-left"></i> Reset Semua Filter
                    </a>
                @endif
            </div>

            {{-- Sorting Selector --}}
            <form action="/" method="GET" class="tm-sort-wrapper">
                @if(!empty($q))
                    <input type="hidden" name="q" value="{{ $q }}">
                @endif
                @if(!empty($kategori))
                    <input type="hidden" name="kategori" value="{{ $kategori }}">
                @endif

                <label for="sortSelector" style="font-size: 13px; font-weight: 600; color: #64748b;">
                    <i class="fa-solid fa-arrow-down-short-wide"></i> Urutkan:
                </label>
                <select name="sort" id="sortSelector" class="tm-sort-select" onchange="this.form.submit()">
                    <option value="terbaru" {{ ($sort === 'terbaru') ? 'selected' : '' }}>Produk Terbaru</option>
                    <option value="termurah" {{ ($sort === 'termurah') ? 'selected' : '' }}>Harga: Terendah</option>
                    <option value="termahal" {{ ($sort === 'termahal') ? 'selected' : '' }}>Harga: Tertinggi</option>
                </select>
            </form>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="product-grid">

            @forelse($products as $prod)
                <article class="product-card" style="transition: transform 0.2s, box-shadow 0.2s;">
                    <a href="{{ route('products.show', $prod->slug) }}" style="text-decoration: none; color: inherit; display: block;">
                        <div class="product-image">
                            @if($prod->image)
                                <img src="{{ asset($prod->image) }}" alt="{{ $prod->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <span class="product-emoji">{{ $prod->icon ?? '🌱' }}</span>
                            @endif
                            <span class="product-badge">{{ $prod->category }}</span>
                        </div>
                    </a>

                    <div class="product-info">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <p class="product-category" style="margin-bottom: 0;">{{ $prod->category }}</p>
                            <small style="color: #64748b; font-size: 11px;"><i class="fa-solid fa-location-dot" style="color: #ef4444;"></i> {{ $prod->location ?? 'Indonesia' }}</small>
                        </div>

                        <h3 class="product-name">
                            <a href="{{ route('products.show', $prod->slug) }}" style="text-decoration: none; color: inherit;">
                                {{ $prod->name }}
                            </a>
                        </h3>
                        
                        <p class="product-description">
                            {{ Str::limit($prod->description ?? 'Produk pilihan petani mitra TaniMart.', 85) }}
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
                {{-- Empty Search / Filter State --}}
                <div class="tm-search-empty-state">
                    <span class="tm-empty-icon">🔍🌱</span>
                    <h3 class="tm-empty-title">
                        @if(!empty($q))
                            Produk "{{ $q }}" Tidak Ditemukan
                        @elseif(!empty($kategori))
                            Belum Ada Produk di Kategori "{{ $kategori }}"
                        @else
                            Belum Ada Produk yang Dipasang
                        @endif
                    </h3>
                    <p class="tm-empty-desc">
                        @if(!empty($q))
                            Coba periksa ejaan kata kunci, gunakan istilah yang lebih umum seperti "bibit" atau "pupuk", atau lihat kategori lain.
                        @else
                            Jadilah yang pertama memasang produk pertanian di marketplace TaniMart!
                        @endif
                    </p>
                    <div style="display: flex; justify-content: center; gap: 0.75rem; flex-wrap: wrap;">
                        <a href="/#produk" class="btn btn-primary">
                            <i class="fa-solid fa-rotate-left"></i> Lihat Semua Produk
                        </a>
                        @auth
                            <a href="{{ route('products.create') }}" class="btn btn-secondary">
                                ➕ Pasang Produk Ini
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- Recommended Products if search has 0 result --}}
                @if(isset($recommended) && $recommended->isNotEmpty())
                    <div style="grid-column: 1 / -1; margin-top: 2rem;">
                        <h3 style="font-size: 1.15rem; color: #1e3a29; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-sparkles" style="color: #eab308;"></i> Rekomendasi Produk Lainnya untuk Anda:
                        </h3>
                        <div class="product-grid">
                            @foreach($recommended as $rec)
                                <article class="product-card">
                                    <a href="{{ route('products.show', $rec->slug) }}" style="text-decoration: none; color: inherit; display: block;">
                                        <div class="product-image">
                                            @if($rec->image)
                                                <img src="{{ asset($rec->image) }}" alt="{{ $rec->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <span class="product-emoji">{{ $rec->icon ?? '🌱' }}</span>
                                            @endif
                                            <span class="product-badge">{{ $rec->category }}</span>
                                        </div>
                                    </a>
                                    <div class="product-info">
                                        <h3 class="product-name">
                                            <a href="{{ route('products.show', $rec->slug) }}" style="text-decoration: none; color: inherit;">
                                                {{ $rec->name }}
                                            </a>
                                        </h3>
                                        <div class="product-bottom">
                                            <p class="product-price">
                                                Rp{{ number_format($rec->price, 0, ',', '.') }}
                                            </p>
                                            <form action="{{ url('/keranjang/tambah/' . $rec->id) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                <button class="add-cart" type="submit" title="Tambah ke keranjang">+</button>
                                            </form>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforelse

        </div>
    </section>

    @include('partials.footer')

</body>
</html>
