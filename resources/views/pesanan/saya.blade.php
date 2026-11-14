<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya | TaniMart</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .shopee-orders-wrapper {
            max-width: 960px;
            margin: 2rem auto 4rem;
            padding: 0 1rem;
        }

        .shopee-page-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1e3a2b;
            margin-bottom: 0.35rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .shopee-page-desc {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }

        /* Shopee Navigation Tabs Bar */
        .shopee-tabs-nav {
            display: flex;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            border: 1px solid #e2e8f0;
            overflow-x: auto;
            margin-bottom: 1.5rem;
            scrollbar-width: none;
        }

        .shopee-tabs-nav::-webkit-scrollbar {
            display: none;
        }

        .shopee-tab-btn {
            flex: 1;
            min-width: 130px;
            padding: 1rem 0.75rem;
            text-align: center;
            font-size: 0.92rem;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border-bottom: 3px solid transparent;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .shopee-tab-btn:hover {
            color: #24583b;
            background: #fbfdfb;
        }

        .shopee-tab-btn.active {
            color: #24583b;
            font-weight: 700;
            border-bottom-color: #34754a;
            background: #f7faf7;
        }

        .tab-badge {
            background: #ef4444;
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 999px;
        }

        .tab-badge-dim {
            background: #e2e8f0;
            color: #475569;
        }

        /* Shopee Order Card */
        .shopee-order-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: box-shadow 0.2s;
        }

        .shopee-order-card:hover {
            box-shadow: 0 8px 24px rgba(36, 88, 59, 0.08);
        }

        /* Card Header */
        .shopee-card-header {
            padding: 1rem 1.4rem;
            background: #fafbfa;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .shopee-seller-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            color: #1e3a29;
            font-size: 0.95rem;
        }

        .shopee-seller-brand i {
            color: #34754a;
        }

        .btn-chat-store {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.15s;
        }

        .btn-chat-store:hover {
            background: #dcfce7;
        }

        .shopee-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Card Items */
        .shopee-items-container {
            padding: 1.25rem 1.4rem;
        }

        .shopee-item-row {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            padding: 0.85rem 0;
            border-bottom: 1px dashed #f1f5f9;
        }

        .shopee-item-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .shopee-item-row:first-child {
            padding-top: 0;
        }

        .shopee-item-thumb {
            width: 64px;
            height: 64px;
            border-radius: 12px;
            background: #f4f8f3;
            border: 1px solid #e2ece4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            flex-shrink: 0;
            overflow: hidden;
        }

        .shopee-item-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .shopee-item-info {
            flex: 1;
            min-width: 0;
        }

        .shopee-item-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
            display: block;
            text-decoration: none;
        }

        .shopee-item-name:hover {
            color: #34754a;
        }

        .shopee-item-sub {
            font-size: 0.82rem;
            color: #64748b;
        }

        .shopee-item-pricing {
            text-align: right;
            flex-shrink: 0;
        }

        .shopee-item-price {
            font-size: 0.92rem;
            font-weight: 700;
            color: #1e293b;
        }

        .shopee-item-qty {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        /* Review snippet if already reviewed */
        .shopee-reviewed-box {
            background: #fefce8;
            border: 1px solid #fef08a;
            border-radius: 10px;
            padding: 8px 12px;
            margin-top: 8px;
            font-size: 0.82rem;
            color: #713f12;
            display: flex;
            align-items: flex-start;
            gap: 6px;
        }

        .shopee-star-rating {
            color: #eab308;
            font-size: 0.9rem;
        }

        /* Card Footer */
        .shopee-card-footer {
            padding: 1.1rem 1.4rem;
            background: #fbfcfb;
            border-top: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .shopee-meta-info {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .shopee-order-num {
            font-size: 0.82rem;
            color: #64748b;
            font-weight: 600;
        }

        .shopee-courier-tag {
            font-size: 0.8rem;
            color: #0369a1;
            background: #e0f2fe;
            padding: 2px 8px;
            border-radius: 6px;
            display: inline-block;
            width: fit-content;
            font-weight: 600;
        }

        .shopee-total-box {
            text-align: right;
        }

        .shopee-total-label {
            font-size: 0.85rem;
            color: #64748b;
            margin-right: 6px;
        }

        .shopee-total-val {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1e3a29;
        }

        .shopee-actions-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .shopee-btn-pay {
            background: #ea580c;
            color: #ffffff;
            border: none;
            padding: 0.55rem 1.2rem;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .shopee-btn-pay:hover {
            background: #c2410c;
            transform: translateY(-1px);
        }

        .shopee-btn-cancel {
            background: #ffffff;
            color: #64748b;
            border: 1px solid #cbd5e1;
            padding: 0.55rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .shopee-btn-cancel:hover {
            color: #dc2626;
            border-color: #fca5a5;
            background: #fef2f2;
        }

        .shopee-btn-receive {
            background: #16a34a;
            color: #ffffff;
            border: none;
            padding: 0.55rem 1.2rem;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .shopee-btn-receive:hover {
            background: #15803d;
            transform: translateY(-1px);
        }

        .shopee-btn-rate {
            background: #fef08a;
            color: #854d0e;
            border: 1px solid #fde047;
            padding: 0.55rem 1.1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .shopee-btn-rate:hover {
            background: #fde047;
            color: #713f12;
        }

        /* Review Modal */
        .rating-modal-backdrop {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .rating-modal-backdrop.show {
            display: flex;
        }

        .rating-modal-card {
            background: #ffffff;
            border-radius: 20px;
            width: 100%;
            max-width: 480px;
            padding: 1.75rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            animation: modalFadeIn 0.25s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .star-picker {
            display: flex;
            gap: 8px;
            font-size: 2rem;
            color: #cbd5e1;
            cursor: pointer;
            margin: 1rem 0;
            justify-content: center;
        }

        .star-picker i {
            transition: color 0.15s, transform 0.15s;
        }

        .star-picker i:hover,
        .star-picker i.selected {
            color: #eab308;
            transform: scale(1.15);
        }

        /* Empty State */
        .shopee-empty-state {
            text-align: center;
            padding: 4rem 1.5rem;
            background: #ffffff;
            border-radius: 20px;
            border: 1px dashed #cbdad0;
        }

        .shopee-empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            display: block;
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <main class="shopee-orders-wrapper">

        {{-- Flash Messages --}}
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

        {{-- Page Heading --}}
        <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
            <div>
                <h1 class="shopee-page-title">
                    <i class="fa-solid fa-bag-shopping" style="color: #34754a;"></i>
                    Pesanan Saya
                </h1>
                <p class="shopee-page-desc">Pantau status pembayaran, proses pengemasan, pelacakan kurir, dan beri ulasan.</p>
            </div>

            {{-- Jika user juga punya produk/menjual produk, tampilkan tombol ke Pesanan Masuk Toko --}}
            @if(auth()->user()->products()->count() > 0)
                <a href="{{ route('pesanan.penjual') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.65rem 1.2rem; background: #e8f5ed; color: #166534; border: 1.5px solid #a3d9b4; border-radius: 12px; font-weight: 700; font-size: 0.88rem; text-decoration: none;">
                    <i class="fa-solid fa-store"></i> Buka Pesanan Masuk Toko Saya →
                </a>
            @endif
        </div>

        {{-- Shopee Navigation Tabs Bar --}}
        <div class="shopee-tabs-nav">
            <a href="{{ route('pesanan.saya', ['tab' => 'semua']) }}" class="shopee-tab-btn {{ $statusTab === 'semua' ? 'active' : '' }}">
                <span>Semua</span>
                @if(($counts['semua'] ?? 0) > 0)
                    <span class="tab-badge tab-badge-dim">{{ $counts['semua'] }}</span>
                @endif
            </a>

            <a href="{{ route('pesanan.saya', ['tab' => 'belum_bayar']) }}" class="shopee-tab-btn {{ $statusTab === 'belum_bayar' ? 'active' : '' }}">
                <span>Belum Bayar</span>
                @if(($counts['belum_bayar'] ?? 0) > 0)
                    <span class="tab-badge">{{ $counts['belum_bayar'] }}</span>
                @endif
            </a>

            <a href="{{ route('pesanan.saya', ['tab' => 'dikemas']) }}" class="shopee-tab-btn {{ $statusTab === 'dikemas' ? 'active' : '' }}">
                <span>Dikemas</span>
                @if(($counts['dikemas'] ?? 0) > 0)
                    <span class="tab-badge" style="background:#2563eb;">{{ $counts['dikemas'] }}</span>
                @endif
            </a>

            <a href="{{ route('pesanan.saya', ['tab' => 'dikirim']) }}" class="shopee-tab-btn {{ $statusTab === 'dikirim' ? 'active' : '' }}">
                <span>Dikirim</span>
                @if(($counts['dikirim'] ?? 0) > 0)
                    <span class="tab-badge" style="background:#0284c7;">{{ $counts['dikirim'] }}</span>
                @endif
            </a>

            <a href="{{ route('pesanan.saya', ['tab' => 'selesai']) }}" class="shopee-tab-btn {{ $statusTab === 'selesai' ? 'active' : '' }}">
                <span>Selesai</span>
                @if(($counts['selesai'] ?? 0) > 0)
                    <span class="tab-badge" style="background:#16a34a;">{{ $counts['selesai'] }}</span>
                @endif
            </a>

            <a href="{{ route('pesanan.saya', ['tab' => 'dibatalkan']) }}" class="shopee-tab-btn {{ $statusTab === 'dibatalkan' ? 'active' : '' }}">
                <span>Dibatalkan</span>
                @if(($counts['dibatalkan'] ?? 0) > 0)
                    <span class="tab-badge tab-badge-dim">{{ $counts['dibatalkan'] }}</span>
                @endif
            </a>
        </div>

        {{-- Order Cards List --}}
        @forelse($orders as $order)
            @php
                $stInfo = $order->status_info;
                // Ambil penjual dari item pertama jika ada
                $firstItem = $order->items->first();
                $seller = $firstItem && $firstItem->seller ? $firstItem->seller : ($firstItem && $firstItem->product ? $firstItem->product->user : null);
            @endphp

            <div class="shopee-order-card">
                
                {{-- Card Header: Nama Toko / Penjual + Status --}}
                <div class="shopee-card-header">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div class="shopee-seller-brand">
                            <i class="fa-solid fa-shop"></i>
                            <span>{{ $seller ? $seller->name : 'TaniMart Mitra' }}</span>
                        </div>

                        @if($seller && $seller->id !== auth()->id())
                            <a href="{{ route('chat.index', ['user_id' => $seller->id]) }}" class="btn-chat-store" title="Hubungi penjual pesanan ini">
                                <i class="fa-solid fa-comments"></i> Chat Penjual
                            </a>
                        @endif
                    </div>

                    <span class="shopee-status-pill" style="color: {{ $stInfo['color'] }}; background: {{ $stInfo['bg'] }};">
                        <i class="{{ $stInfo['icon'] }}"></i>
                        {{ $stInfo['label'] }}
                    </span>
                </div>

                {{-- Card Items List --}}
                <div class="shopee-items-container">
                    @foreach($order->items as $item)
                        <div class="shopee-item-row">
                            <div class="shopee-item-thumb">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset($item->product->image) }}" alt="{{ $item->product_name }}">
                                @else
                                    <span>{{ $item->product->icon ?? '🌱' }}</span>
                                @endif
                            </div>

                            <div class="shopee-item-info">
                                @if($item->product && $item->product->slug)
                                    <a href="{{ route('products.show', $item->product->slug) }}" class="shopee-item-name">
                                        {{ $item->product_name }}
                                    </a>
                                @else
                                    <span class="shopee-item-name">{{ $item->product_name }}</span>
                                @endif

                                <div class="shopee-item-sub">
                                    {{ $item->product->category ?? 'Produk Pertanian' }}
                                    @if($item->product && $item->product->unit)
                                        • {{ $item->product->unit }}
                                    @endif
                                </div>

                                {{-- Jika produk ini sudah diberi penilaian --}}
                                @if($item->rating)
                                    <div class="shopee-reviewed-box">
                                        <div class="shopee-star-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star" style="color: {{ $i <= $item->rating ? '#eab308' : '#cbd5e1' }};"></i>
                                            @endfor
                                        </div>
                                        <div>
                                            <strong>Penilaian Anda:</strong> {{ $item->review ?? 'Sangat puas!' }}
                                        </div>
                                    </div>
                                @elseif($order->shopee_status === 'selesai')
                                    <div style="margin-top: 6px;">
                                        <button type="button" class="shopee-btn-rate" onclick="openRatingModal({{ $item->id }}, '{{ addslashes($item->product_name) }}')">
                                            <i class="fa-solid fa-star"></i> Beri Penilaian Produk Ini
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <div class="shopee-item-pricing">
                                <div class="shopee-item-price">Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                                <div class="shopee-item-qty">x{{ $item->quantity }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Card Footer: Info Resi, Total Harga, & Action Buttons --}}
                <div class="shopee-card-footer">
                    <div class="shopee-meta-info">
                        <span class="shopee-order-num">No. Pesanan: <strong>{{ $order->order_number }}</strong></span>
                        <span style="font-size: 0.8rem; color: #94a3b8;">
                            {{ $order->created_at->format('d M Y, H:i') }} • Metode: <strong>{{ $order->payment_method ?? 'Transfer' }}</strong>
                        </span>

                        @if($order->tracking_number)
                            <div style="margin-top: 4px;">
                                <span class="shopee-courier-tag">
                                    <i class="fa-solid fa-truck"></i> {{ $order->shipping_courier ?? 'Kurir' }}: <strong>{{ $order->tracking_number }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>

                    <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
                        <div class="shopee-total-box">
                            <span class="shopee-total-label">Total Pesanan:</span>
                            <span class="shopee-total-val">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>

                        <div class="shopee-actions-bar">
                            {{-- Action Belum Bayar --}}
                            @if($order->shopee_status === 'belum_bayar')
                                <form action="{{ route('pesanan.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                    @csrf
                                    <button type="submit" class="shopee-btn-cancel">Batalkan</button>
                                </form>

                                <form action="{{ route('pesanan.pay', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="shopee-btn-pay">
                                        <i class="fa-solid fa-credit-card"></i> Bayar Sekarang
                                    </button>
                                </form>
                            @endif

                            {{-- Action Dikemas --}}
                            @if($order->shopee_status === 'dikemas')
                                @if($seller && $seller->id !== auth()->id())
                                    <a href="{{ route('chat.index', ['user_id' => $seller->id]) }}" class="shopee-btn-cancel" style="text-decoration:none;">
                                        <i class="fa-solid fa-comment-dots"></i> Tanya Penjual
                                    </a>
                                @endif
                                <span style="font-size: 0.82rem; color: #2563eb; font-weight: 600;">
                                    <i class="fa-solid fa-clock"></i> Sedang dikemas oleh penjual
                                </span>
                            @endif

                            {{-- Action Dikirim --}}
                            @if($order->shopee_status === 'dikirim')
                                @if($seller && $seller->id !== auth()->id())
                                    <a href="{{ route('chat.index', ['user_id' => $seller->id]) }}" class="shopee-btn-cancel" style="text-decoration:none;">
                                        <i class="fa-solid fa-comment-dots"></i> Chat Penjual
                                    </a>
                                @endif

                                <form action="{{ route('pesanan.confirm', $order->id) }}" method="POST" onsubmit="return confirm('Pastikan barang sudah Anda terima dengan baik sebelum konfirmasi!')">
                                    @csrf
                                    <button type="submit" class="shopee-btn-receive">
                                        <i class="fa-solid fa-circle-check"></i> Pesanan Diterima
                                    </button>
                                </form>
                            @endif

                            {{-- Action Selesai --}}
                            @if($order->shopee_status === 'selesai')
                                <a href="/#produk" class="shopee-btn-cancel" style="text-decoration:none; color:#166534; border-color:#bbf7d0; background:#f0fdf4;">
                                    <i class="fa-solid fa-rotate-right"></i> Beli Lagi
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        @empty
            <div class="shopee-empty-state">
                <span class="shopee-empty-icon">📦</span>
                <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e3a29; margin-bottom: 0.5rem;">
                    Belum Ada Pesanan di Tab "{{ ucfirst(str_replace('_', ' ', $statusTab)) }}"
                </h3>
                <p style="color: #64748b; font-size: 0.95rem; max-width: 420px; margin: 0 auto 1.5rem;">
                    Yuk jelajahi berbagai produk pertanian, bibit tanaman, pupuk organik, dan alat tani di TaniMart!
                </p>
                <a href="/#produk" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-basket-shopping"></i> Mulai Belanja Sekarang →
                </a>
            </div>
        @endforelse

    </main>

    {{-- Rating & Review Modal --}}
    <div class="rating-modal-backdrop" id="ratingModal">
        <div class="rating-modal-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3 style="margin: 0; font-size: 1.2rem; color: #1e293b;">
                    <i class="fa-solid fa-star" style="color: #eab308;"></i> Beri Penilaian
                </h3>
                <span style="cursor: pointer; font-size: 1.2rem; color: #94a3b8;" onclick="closeRatingModal()">✕</span>
            </div>

            <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 0.5rem;">
                Produk: <strong id="modalProductName" style="color: #1e293b;">-</strong>
            </p>

            <form id="ratingForm" action="" method="POST">
                @csrf
                <input type="hidden" name="rating" id="ratingInput" value="5">

                <div class="star-picker" id="starPicker">
                    <i class="fa-solid fa-star selected" data-val="1"></i>
                    <i class="fa-solid fa-star selected" data-val="2"></i>
                    <i class="fa-solid fa-star selected" data-val="3"></i>
                    <i class="fa-solid fa-star selected" data-val="4"></i>
                    <i class="fa-solid fa-star selected" data-val="5"></i>
                </div>
                <p id="starDesc" style="text-align: center; font-size: 0.88rem; font-weight: 700; color: #eab308; margin-bottom: 1.2rem;">
                    ⭐⭐⭐⭐⭐ Sangat Puas!
                </p>

                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #334155; margin-bottom: 0.4rem;">
                        Tulis Ulasan untuk Penjual:
                    </label>
                    <textarea 
                        name="review" 
                        rows="3" 
                        class="form-control" 
                        placeholder="Bagikan pengalamanmu mengenai kualitas produk, kecepatan pengemasan, dan respon penjual..." 
                        style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 0.75rem; font-size: 0.9rem; box-sizing: border-box; resize: none;"
                    ></textarea>
                </div>

                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                    <button type="button" class="btn btn-secondary" onclick="closeRatingModal()">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background: #34754a;">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Penilaian
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.footer')

    <script>
        function openRatingModal(itemId, productName) {
            document.getElementById('modalProductName').textContent = productName;
            document.getElementById('ratingForm').action = '/pesanan/item/' + itemId + '/nilai';
            document.getElementById('ratingModal').classList.add('show');
            setRating(5);
        }

        function closeRatingModal() {
            document.getElementById('ratingModal').classList.remove('show');
        }

        const starDescMap = {
            1: '⭐ Sangat Mengecewakan',
            2: '⭐⭐ Kurang Memuaskan',
            3: '⭐⭐⭐ Cukup Baik',
            4: '⭐⭐⭐⭐ Bagus & Sesuai',
            5: '⭐⭐⭐⭐⭐ Sangat Puas!'
        };

        function setRating(val) {
            document.getElementById('ratingInput').value = val;
            const stars = document.querySelectorAll('#starPicker i');
            stars.forEach((star, index) => {
                if (index < val) {
                    star.classList.add('selected');
                } else {
                    star.classList.remove('selected');
                }
            });
            document.getElementById('starDesc').textContent = starDescMap[val] || '';
        }

        document.querySelectorAll('#starPicker i').forEach(star => {
            star.addEventListener('click', function() {
                const val = parseInt(this.getAttribute('data-val'));
                setRating(val);
            });
        });
    </script>

</body>
</html>
