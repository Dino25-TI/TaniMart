<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil | TaniMart</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <meta name="description" content="Pesanan Anda berhasil dibuat di TaniMart — Marketplace pertanian modern.">
    <meta name="theme-color" content="#34754a">
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .success-actions-box {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .btn-track-order {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0.85rem 1.6rem;
            background: #34754a;
            color: #ffffff;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 8px 20px rgba(52, 117, 74, 0.25);
        }

        .btn-track-order:hover {
            background: #24583b;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(36, 88, 59, 0.35);
        }

        .btn-back-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0.85rem 1.4rem;
            background: #ffffff;
            color: #334155;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-back-home:hover {
            border-color: #34754a;
            color: #24583b;
            background: #f8faf8;
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <main class="section">
        <div class="order-success">
            <div class="success-icon">✓</div>

            <span class="product-eyebrow">TERIMA KASIH TELAH BERBELANJA</span>
            <h1>Pesanan Berhasil Dibuat!</h1>

            <p class="success-description">
                Pesananmu berhasil tercatat di sistem TaniMart dan terhubung langsung ke penjual.
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
                    <span>Metode Pembayaran</span>
                    <strong>{{ $pesanan['metode'] ?? 'Transfer Bank' }}</strong>
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

            <div class="success-actions-box">
                @auth
                    <a href="{{ route('pesanan.saya') }}" class="btn-track-order">
                        <i class="fa-solid fa-bag-shopping"></i> Pantau Status Pesanan Saya (Shopee) →
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-track-order">
                        <i class="fa-solid fa-right-to-bracket"></i> Masuk untuk Pantau Status Pesanan →
                    </a>
                @endauth

                <a href="/" class="btn-back-home">
                    <i class="fa-solid fa-house"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
