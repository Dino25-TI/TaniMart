<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pesanan | TaniMart</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <meta name="description" content="Selesaikan checkout produk pertanian berkualitas di TaniMart.">
    <meta name="theme-color" content="#34754a">
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .payment-method-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin: 0.6rem 0 1.5rem;
        }

        @media (max-width: 640px) {
            .payment-method-grid {
                grid-template-columns: 1fr;
            }
        }

        .payment-option-card {
            position: relative;
            cursor: pointer;
        }

        .payment-option-card input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .payment-box {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.85rem 0.75rem;
            text-align: center;
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .payment-box i {
            font-size: 1.35rem;
            margin-bottom: 0.35rem;
            display: block;
            color: #64748b;
        }

        .payment-box span {
            font-size: 0.85rem;
            font-weight: 700;
            color: #334155;
            display: block;
        }

        .payment-option-card input:checked + .payment-box {
            border-color: #34754a;
            background: #f0fdf4;
        }

        .payment-option-card input:checked + .payment-box i,
        .payment-option-card input:checked + .payment-box span {
            color: #166534;
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <main class="section">
        <span class="product-eyebrow">SATU LANGKAH LAGI</span>
        <h1>Checkout Pesanan</h1>
        <p class="section-description">
            Lengkapi informasi penerima dan pilih metode pembayaran sebelum mengonfirmasi pesananmu.
        </p>

        @if ($errors->any())
            <div class="site-toast site-toast-error" style="position: static; margin-bottom: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <p style="margin: 0;">⚠️ {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="checkout-layout">
            <form action="{{ url('/checkout') }}" method="POST" class="checkout-form">
                @csrf

                <h2><i class="fa-solid fa-address-card" style="color: #34754a;"></i> Informasi Penerima</h2>

                <label for="nama">Nama Lengkap</label>
                <input
                    id="nama"
                    type="text"
                    name="nama"
                    value="{{ old('nama', auth()->check() ? auth()->user()->name : '') }}"
                    placeholder="Masukkan nama penerima"
                    required
                >

                <label for="telepon">Nomor Telepon / WhatsApp</label>
                <input
                    id="telepon"
                    type="tel"
                    name="telepon"
                    value="{{ old('telepon', auth()->check() ? auth()->user()->phone : '') }}"
                    placeholder="Contoh: 081234567890"
                    required
                >

                <label for="alamat">Alamat Lengkap Pengiriman</label>
                <textarea
                    id="alamat"
                    name="alamat"
                    rows="3"
                    placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota..."
                    required
                >{{ old('alamat') }}</textarea>

                <label style="margin-top: 1rem; display: block; font-weight: 700; color: #1e293b;">
                    <i class="fa-solid fa-credit-card" style="color: #34754a;"></i> Pilih Metode Pembayaran
                </label>
                <div class="payment-method-grid">
                    <label class="payment-option-card">
                        <input type="radio" name="metode_bayar" value="Transfer Bank" checked>
                        <div class="payment-box">
                            <i class="fa-solid fa-building-columns"></i>
                            <span>Transfer Bank</span>
                        </div>
                    </label>

                    <label class="payment-option-card">
                        <input type="radio" name="metode_bayar" value="COD (Bayar di Tempat)">
                        <div class="payment-box">
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                            <span>COD (Bayar di Tempat)</span>
                        </div>
                    </label>

                    <label class="payment-option-card">
                        <input type="radio" name="metode_bayar" value="QRIS / E-Wallet">
                        <div class="payment-box">
                            <i class="fa-solid fa-qrcode"></i>
                            <span>QRIS / E-Wallet</span>
                        </div>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; font-size: 1rem; padding: 0.9rem;">
                    <i class="fa-solid fa-check"></i> Konfirmasi Pesanan Sekarang →
                </button>
            </form>

            <aside class="checkout-summary">
                <h2>Ringkasan Belanja</h2>

                @foreach ($keranjang as $item)
                    <div class="summary-item">
                        <span>
                            <strong>{{ $item['icon'] ?? '🌱' }} {{ $item['nama'] }}</strong>
                            <br>
                            <small style="color: #64748b;">Penjual: {{ $item['penjual'] ?? 'Mitra Tani' }} (x{{ $item['jumlah'] }})</small>
                        </span>
                        <strong>
                            Rp{{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}
                        </strong>
                    </div>
                @endforeach

                <div class="summary-total">
                    <span>Total Pembayaran</span>
                    <strong style="color: #166534; font-size: 1.3rem;">
                        Rp{{ number_format(
                            collect($keranjang)->sum(fn ($item) => $item['harga'] * $item['jumlah']), 0, ',', '.'
                        ) }}
                    </strong>
                </div>
            </aside>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
