
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil | TaniMart</title>
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    @include('partials.navbar')

    <main class="section">
        <div class="order-success">
            <div class="success-icon">✓</div>

            <span class="product-eyebrow">TERIMA KASIH TELAH BERBELANJA</span>
            <h1>Pesanan Berhasil Dibuat!</h1>

            <p class="success-description">
                Pesananmu berhasil diproses dalam demo TaniMart.
            </p>

            <div class="order-number">
                <span>Nomor Pesanan</span>
                <strong>{{ $pesanan['nomor'] }}</strong>
            </div>

            <div class="order-detail">
                <h2>Detail Pesanan</h2>

                <p>
                    <span>Nama penerima</span>
                    <strong>{{ $pesanan['penerima']['nama'] }}</strong>
                </p>

                <p>
                    <span>Nomor telepon</span>
                    <strong>{{ $pesanan['penerima']['telepon'] }}</strong>
                </p>

                <p>
                    <span>Alamat</span>
                    <strong>{{ $pesanan['penerima']['alamat'] }}</strong>
                </p>

                <p>
                    <span>Tanggal</span>
                    <strong>{{ $pesanan['tanggal'] }}</strong>
                </p>

                <div class="order-products">
                    @foreach ($pesanan['produk'] as $item)
                        <p>
                            <span>{{ $item['nama'] }} × {{ $item['jumlah'] }}</span>
                            <strong>
                                Rp{{ number_format(
                                    $item['harga'] * $item['jumlah'],
                                    0, ',', '.'
                                ) }}
                            </strong>
                        </p>
                    @endforeach
                </div>

                <div class="order-total">
                    <span>Total Belanja</span>
                    <strong>
                        Rp{{ number_format($pesanan['total'], 0, ',', '.') }}
                    </strong>
                </div>
            </div>

            <a href="/" class="btn btn-primary">
                Kembali ke Beranda →
            </a>
        </div>
    </main>
</body>
</html>
