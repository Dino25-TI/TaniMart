
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja | TaniMart</title>
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
</head>
<body>
    <nav>
        <a href="/" class="logo">TaniMart<span>🌱</span></a>

        <div class="nav-links">
            <a href="/">Beranda</a>
            <a href="/#produk">Produk</a>
            <a href="/keranjang">Keranjang</a>
        </div>
    </nav>

    <main class="section">
        <span class="product-eyebrow">BELANJA LEBIH MUDAH</span>
        <h1>Keranjang Belanja</h1>
        <p class="section-description">
            Produk pilihanmu akan dikumpulkan di sini.
        </p>

        
@if (count(session('keranjang', [])) > 0)
    <div class="cart-list">
        @foreach (session('keranjang', []) as $id => $item)
            <div class="cart-item">
                
            <div class="cart-item-info">
                <h3>{{ $item['nama'] }}</h3>

                <p>
                    Rp{{ number_format($item['harga'], 0, ',', '.') }}
                    per barang
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
                    Rp{{ number_format(
                        $item['harga'] * $item['jumlah'],
                        0, ',', '.'
                    ) }}
                </p>
                
                <form action="{{ url('/keranjang/hapus/' . $id) }}" method="POST">
                        @csrf
                    <button type="submit" class="remove-cart">
                        Hapus
                    </button>
                </form>

            </div>
        @endforeach

        <div class="cart-total">
            <span>Total Belanja</span>
            <strong>
                Rp{{ number_format(
                    collect(session('keranjang', []))
                        ->sum(fn ($item) => $item['harga'] * $item['jumlah']),
                    0, ',', '.'
                ) }}
            </strong>
        </div>
    </div>
@else
    <div class="cart-empty">
        <div class="cart-empty-icon">🛒</div>
        <h2>Keranjangmu masih kosong</h2>
        <p>Yuk, temukan kebutuhan pertanian yang cocok untukmu.</p>
        <a href="/#produk" class="btn btn-primary">
            Mulai Belanja →
        </a>
    </div>
@endif
    </main>
</body>
</html>
