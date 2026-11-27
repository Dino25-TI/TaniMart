<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan — TaniMart</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="/css/tanimart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .riwayat-wrapper {
            max-width: 900px;
            margin: 2.5rem auto;
            padding: 0 1.5rem;
        }
        .riwayat-header {
            margin-bottom: 2rem;
        }
        .riwayat-header h1 {
            font-size: 1.7rem;
            color: #1a3d28;
            margin: 0 0 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .riwayat-header p {
            color: #6b8c78;
            font-size: 0.95rem;
            margin: 0;
        }
        .pesanan-card {
            background: #fff;
            border: 1.5px solid #e0ece5;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.2rem;
            box-shadow: 0 2px 10px rgba(45,106,79,0.06);
            transition: box-shadow 0.2s, border-color 0.2s;
        }
        .pesanan-card:hover {
            box-shadow: 0 4px 18px rgba(45,106,79,0.13);
            border-color: #b2d8bf;
        }
        .pesanan-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .pesanan-nomor {
            font-weight: 700;
            color: #1a3d28;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.3rem 0.9rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .status-pending { background: #fef9e7; color: #d97706; border: 1px solid #fcd34d; }
        .status-diproses { background: #eff6ff; color: #2563eb; border: 1px solid #93c5fd; }
        .status-dikirim { background: #f0f9ff; color: #0284c7; border: 1px solid #7dd3fc; }
        .status-selesai { background: #e8f5ed; color: #15803d; border: 1px solid #86efac; }
        .status-dibatalkan { background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; }
        .pesanan-meta {
            display: flex;
            gap: 2rem;
            font-size: 0.88rem;
            color: #6b8c78;
            border-top: 1px solid #f0f4f2;
            padding-top: 0.9rem;
            flex-wrap: wrap;
        }
        .pesanan-meta span {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }
        .pesanan-total {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a3d28;
        }
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            color: #6b8c78;
        }
        .empty-state .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            display: block;
        }
        .empty-state h2 {
            font-size: 1.3rem;
            color: #2d6a4f;
            margin-bottom: 0.5rem;
        }
        .empty-state p {
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.5rem;
            background: #34754a;
            color: #fff;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: background 0.2s;
        }
        .btn-primary:hover { background: #2d6a4f; }
    </style>
</head>
<body>
    @include('partials.navbar')

    <main style="min-height: 70vh; padding-bottom: 2rem;">
        <div class="riwayat-wrapper">

            <div class="riwayat-header">
                <h1>
                    <i class="fa-solid fa-clock-rotate-left" style="color:#34754a;"></i>
                    Riwayat Pesanan
                </h1>
                <p>Semua pesanan yang pernah kamu buat di TaniMart</p>
            </div>

            @if($pesanan->isEmpty())
                <div class="empty-state">
                    <span class="empty-icon">📦</span>
                    <h2>Belum Ada Pesanan</h2>
                    <p>Kamu belum pernah melakukan pesanan. Yuk, mulai belanja produk pertanian!</p>
                    <a href="/#produk" class="btn-primary">
                        <i class="fa-solid fa-basket-shopping"></i> Mulai Belanja
                    </a>
                </div>
            @else
                <p style="color:#6b8c78;font-size:0.9rem;margin-bottom:1.5rem;">
                    <i class="fa-solid fa-box-open"></i>
                    Menampilkan <strong>{{ $pesanan->count() }}</strong> pesanan
                </p>

                @foreach($pesanan as $order)
                    <div class="pesanan-card">
                        <div class="pesanan-card-header">
                            <div class="pesanan-nomor">
                                <i class="fa-solid fa-receipt" style="color:#34754a;"></i>
                                {{ $order->order_number }}
                            </div>
                            @php
                                $statusMap = [
                                    'pending'     => ['class' => 'status-pending',     'icon' => '⏳', 'label' => 'Menunggu Pembayaran'],
                                    'diproses'    => ['class' => 'status-diproses',    'icon' => '⚙️', 'label' => 'Diproses'],
                                    'dikirim'     => ['class' => 'status-dikirim',     'icon' => '🚚', 'label' => 'Dikirim'],
                                    'selesai'     => ['class' => 'status-selesai',     'icon' => '✅', 'label' => 'Selesai'],
                                    'dibatalkan'  => ['class' => 'status-dibatalkan',  'icon' => '❌', 'label' => 'Dibatalkan'],
                                ];
                                $st = $statusMap[$order->status] ?? ['class' => 'status-pending', 'icon' => '•', 'label' => ucfirst($order->status)];
                            @endphp
                            <span class="status-badge {{ $st['class'] }}">
                                {{ $st['icon'] }} {{ $st['label'] }}
                            </span>
                        </div>

                        <div class="pesanan-meta">
                            <span>
                                <i class="fa-regular fa-calendar"></i>
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </span>
                            <span>
                                <i class="fa-solid fa-user"></i>
                                {{ $order->customer_name }}
                            </span>
                            @if($order->customer_phone)
                            <span>
                                <i class="fa-solid fa-phone"></i>
                                {{ $order->customer_phone }}
                            </span>
                            @endif
                            <span class="pesanan-total" style="margin-left:auto;">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </span>
                        </div>

                        @if($order->items && $order->items->count() > 0)
                            <div style="margin-top:0.9rem;padding-top:0.9rem;border-top:1px solid #f0f4f2;">
                                <p style="font-size:0.8rem;color:#9db8a8;margin:0 0 0.5rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Item Pesanan</p>
                                @foreach($order->items as $item)
                                    <div style="font-size:0.88rem;color:#3a5a4a;display:flex;justify-content:space-between;padding:0.2rem 0;">
                                        <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                                        <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif

        </div>
    </main>

    @include('partials.footer')
</body>
</html>
