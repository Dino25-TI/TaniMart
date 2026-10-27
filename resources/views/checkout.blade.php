<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | TaniMart</title>
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
</head>
<body>
    <nav>
        <a href="/" class="logo">TaniMart🌱</a>

        <div class="nav-links">
            <a href="/">Beranda</a>
            <a href="/#produk">Produk</a>
            <a href="/keranjang">Keranjang</a>
        </div>
    </nav>

    <main class="section">
        <span class="product-eyebrow">SATU LANGKAH LAGI</span>
        <h1>Checkout</h1>
        <p class="section-description">
            Lengkapi informasi penerima sebelum mengonfirmasi pesananmu.
        </p>

        <div class="checkout-layout">
            <form action="{{ url('/checkout') }}" method="POST" class="checkout-form">
                @csrf

                <h2>Informasi Penerima</h2>

                <label for="nama">Nama lengkap</label>
                <input id="nama" type="text" name="nama"
                    placeholder="Masukkan nama penerima" required>

                <label for="telepon">Nomor telepon</label>
                <input id="telepon" type="tel" name="telepon"
                    placeholder="Contoh: 081234567890" required>

                <label for="alamat">Alamat lengkap</label>
                <textarea id="alamat" name="alamat" rows="4"
                    placeholder="Nama jalan, nomor rumah, kota..." required></textarea>

                <button type="submit" class="btn btn-primary">
                    Konfirmasi Pesanan
                </button>
            </form>

            <aside class="checkout-summary">
                <h2>Ringkasan Belanja</h2>

                @foreach ($keranjang as $item)
                    <div class="summary-item">
                        <span>{{ $item['nama'] }} × {{ $item['jumlah'] }}</span>
                        <strong>
                            Rp{{ number_format(
                                $item['harga'] * $item['jumlah'], 0, ',', '.'
                            ) }}
                        </strong>
                    </div>
                @endforeach

                <div class="summary-total">
                    <span>Total</span>
                    <strong>
                        Rp{{ number_format(
                            collect($keranjang)->sum(
                                fn ($item) => $item['harga'] * $item['jumlah']
                            ), 0, ',', '.'
                        ) }}
                    </strong>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>
