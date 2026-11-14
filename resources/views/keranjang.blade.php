<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja | TaniMart</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <meta name="description" content="Keranjang belanja produk pertanian di TaniMart.">
    <meta name="theme-color" content="#34754a">
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    @include('partials.navbar')

    <main class="section">
        @if (session('error'))
            <div class="site-toast site-toast-error" id="toastMsg">
                <span>⚠️ {{ session('error') }}</span>
                <span style="cursor: pointer; opacity: 0.7; margin-left: 8px;" onclick="this.parentElement.remove()">✕</span>
            </div>
            <script>setTimeout(() => { const el = document.getElementById('toastMsg'); if(el) el.remove(); }, 5000);</script>
        @endif

        @if (session('success'))
            <div class="site-toast site-toast-success" id="toastMsg">
                <span>✅ {{ session('success') }}</span>
                <span style="cursor: pointer; opacity: 0.7; margin-left: 8px;" onclick="this.parentElement.remove()">✕</span>
            </div>
            <script>setTimeout(() => { const el = document.getElementById('toastMsg'); if(el) el.remove(); }, 5000);</script>
        @endif

        <span class="product-eyebrow">BELANJA LEBIH MUDAH</span>
        <h1>Keranjang Belanja</h1>
        <p class="section-description">
            Produk pilihan pertanianmu dikumpulkan di sini.
        </p>

        @if (count(session('keranjang', [])) > 0)
            <div class="cart-list">
                @foreach (session('keranjang', []) as $id => $item)
                    <div class="cart-item">
                        <div class="cart-item-icon">{{ $item['icon'] ?? '🌱' }}</div>
                        <div class="cart-item-info">
                            <h3>{{ $item['nama'] }}</h3>
                            <p>
                                Rp{{ number_format($item['harga'], 0, ',', '.') }} per barang
                            </p>
                            <p style="color: #24583b; font-size: 0.85rem; margin: 0.2rem 0; font-weight: 600;">
                                <i class="fa-solid fa-store"></i> Penjual: {{ $item['penjual'] ?? 'Mitra Tani' }}
                            </p>

                            <div class="quantity-controls">
                                <form action="{{ url('/keranjang/ubah/' . $id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="aksi" value="kurang">
                                    <button type="submit" class="quantity-btn" aria-label="Kurangi jumlah">−</button>
                                </form>

                                <span class="quantity-number">{{ $item['jumlah'] }}</span>

                                <form action="{{ url('/keranjang/ubah/' . $id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="aksi" value="tambah">
                                    <button type="submit" class="quantity-btn" aria-label="Tambah jumlah">+</button>
                                </form>
                            </div>
                        </div>

                        <p class="cart-subtotal">
                            Rp{{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}
                        </p>
                        
                        <form action="{{ url('/keranjang/hapus/' . $id) }}" method="POST">
                            @csrf
                            <button type="submit" class="remove-cart" title="Hapus dari keranjang">
                                Hapus
                            </button>
                        </form>
                    </div>
                @endforeach

                <div class="cart-total">
                    <span>Total Belanja</span>
                    <strong>
                        Rp{{ number_format(
                            collect(session('keranjang', []))->sum(fn ($item) => $item['harga'] * $item['jumlah']),
                            0, ',', '.'
                        ) }}
                    </strong>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 20px; flex-wrap: wrap; align-items: center;">
                    <a href="{{ url('/#produk') }}" class="btn btn-secondary" style="font-weight: 700;">
                        ← Lanjutkan Belanja
                    </a>
                    <a href="{{ url('/checkout') }}" class="btn btn-primary" style="font-weight: 700;">
                        Lanjut Checkout →
                    </a>
                </div>
            </div>
        @else
            <div class="cart-empty">
                <div class="cart-empty-icon">🛒</div>
                <h2>Keranjangmu masih kosong</h2>
                <p>Yuk, temukan bibit, pupuk, atau pot tanaman yang cocok untukmu.</p>
                <a href="/#produk" class="btn btn-primary">
                    Mulai Belanja Sekarang →
                </a>
            </div>
        @endif
    </main>

    @include('partials.footer')
</body>
</html>
