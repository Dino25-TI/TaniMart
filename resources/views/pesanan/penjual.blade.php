<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Masuk Toko | TaniMart</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .seller-orders-wrapper {
            max-width: 1050px;
            margin: 2rem auto 4rem;
            padding: 0 1.25rem;
        }

        .seller-header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .seller-title {
            font-size: 1.65rem;
            font-weight: 800;
            color: #1e3a29;
            margin: 0 0 0.35rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .seller-subtitle {
            color: #64748b;
            font-size: 0.95rem;
            margin: 0;
        }

        /* Tabs */
        .seller-tabs {
            display: flex;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            border: 1px solid #e2e8f0;
            overflow-x: auto;
            margin-bottom: 1.5rem;
        }

        .seller-tab-btn {
            flex: 1;
            min-width: 140px;
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
            transition: all 0.2s;
            white-space: nowrap;
        }

        .seller-tab-btn:hover {
            color: #24583b;
            background: #fbfdfb;
        }

        .seller-tab-btn.active {
            color: #24583b;
            font-weight: 700;
            border-bottom-color: #34754a;
            background: #f7faf7;
        }

        /* Order Card */
        .seller-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .seller-card-top {
            padding: 1rem 1.4rem;
            background: #f8faf8;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .seller-card-body {
            padding: 1.25rem 1.4rem;
        }

        .buyer-info-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 0.85rem 1.1rem;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .buyer-details {
            font-size: 0.9rem;
            color: #166534;
        }

        .buyer-details strong {
            color: #14532d;
            font-size: 0.95rem;
        }

        .buyer-details p {
            margin: 2px 0 0;
            color: #374151;
            font-size: 0.85rem;
        }

        .btn-chat-buyer {
            background: #16a34a;
            color: #ffffff;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
        }

        .btn-chat-buyer:hover {
            background: #15803d;
        }

        .seller-product-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.65rem 0;
            border-bottom: 1px dashed #f1f5f9;
        }

        .seller-product-item:last-child {
            border-bottom: none;
        }

        .seller-thumb {
            width: 52px;
            height: 52px;
            border-radius: 10px;
            background: #f1f5f2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
            overflow: hidden;
        }

        .seller-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .seller-card-bottom {
            padding: 1rem 1.4rem;
            background: #fcfdfc;
            border-top: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .ship-modal-backdrop {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .ship-modal-backdrop.show {
            display: flex;
        }

        .ship-modal-card {
            background: #ffffff;
            border-radius: 20px;
            width: 100%;
            max-width: 480px;
            padding: 1.75rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <main class="seller-orders-wrapper">

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

        <div class="seller-header-bar">
            <div>
                <h1 class="seller-title">
                    <i class="fa-solid fa-boxes-stacked" style="color: #34754a;"></i>
                    Pesanan Masuk Toko Anda
                </h1>
                <p class="seller-subtitle">Kelola pesanan produk pertanian milik toko Anda tanpa tercampur dengan penjual lain.</p>
            </div>

            <a href="{{ route('products.my') }}" class="btn btn-secondary" style="font-size: 0.88rem; text-decoration: none;">
                <i class="fa-solid fa-seedling"></i> Kelola Produk Saya
            </a>
        </div>

        {{-- Tabs --}}
        <div class="seller-tabs">
            <a href="{{ route('pesanan.penjual', ['tab' => 'semua']) }}" class="seller-tab-btn {{ $statusTab === 'semua' ? 'active' : '' }}">
                <span>Semua ({{ $counts['semua'] ?? 0 }})</span>
            </a>
            <a href="{{ route('pesanan.penjual', ['tab' => 'perlu_dikemas']) }}" class="seller-tab-btn {{ $statusTab === 'perlu_dikemas' ? 'active' : '' }}">
                <span>Perlu Dikemas</span>
                @if(($counts['perlu_dikemas'] ?? 0) > 0)
                    <span class="tab-badge" style="background: #ea580c; color:#fff; font-size:11px; padding:2px 7px; border-radius:10px;">{{ $counts['perlu_dikemas'] }}</span>
                @endif
            </a>
            <a href="{{ route('pesanan.penjual', ['tab' => 'dikirim']) }}" class="seller-tab-btn {{ $statusTab === 'dikirim' ? 'active' : '' }}">
                <span>Sedang Dikirim ({{ $counts['dikirim'] ?? 0 }})</span>
            </a>
            <a href="{{ route('pesanan.penjual', ['tab' => 'selesai']) }}" class="seller-tab-btn {{ $statusTab === 'selesai' ? 'active' : '' }}">
                <span>Selesai ({{ $counts['selesai'] ?? 0 }})</span>
            </a>
        </div>

        {{-- Order List --}}
        @forelse($orders as $order)
            @php
                $stInfo = $order->status_info;
            @endphp

            <div class="seller-card">
                <div class="seller-card-top">
                    <div>
                        <span style="font-weight: 700; color: #1e293b; font-size: 0.95rem;">
                            <i class="fa-solid fa-receipt" style="color: #34754a;"></i> {{ $order->order_number }}
                        </span>
                        <span style="font-size: 0.8rem; color: #64748b; margin-left: 8px;">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>

                    <span class="shopee-status-pill" style="color: {{ $stInfo['color'] }}; background: {{ $stInfo['bg'] }}; font-size: 0.8rem; padding: 4px 10px; border-radius: 999px; font-weight: 700;">
                        <i class="{{ $stInfo['icon'] }}"></i> {{ $stInfo['label'] }}
                    </span>
                </div>

                <div class="seller-card-body">
                    {{-- Detail Pembeli & Pengiriman --}}
                    <div class="buyer-info-box">
                        <div class="buyer-details">
                            <strong><i class="fa-solid fa-user"></i> {{ $order->customer_name }}</strong>
                            <span style="font-size: 0.85rem; color: #166534; margin-left: 6px;">({{ $order->customer_phone }})</span>
                            <p><i class="fa-solid fa-location-dot" style="color: #ef4444;"></i> Alamat: {{ $order->customer_address }}</p>
                        </div>

                        @if($order->user_id && $order->user_id !== auth()->id())
                            <a href="{{ route('chat.index', ['user_id' => $order->user_id]) }}" class="btn-chat-buyer" title="Hubungi pembeli lewat chat">
                                <i class="fa-solid fa-comment-dots"></i> Chat Pembeli
                            </a>
                        @endif
                    </div>

                    {{-- Item Produk Toko Anda --}}
                    <div style="font-size: 0.82rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">
                        Produk Toko Anda yang Dipesan:
                    </div>

                    @foreach($order->items as $item)
                        <div class="seller-product-item">
                            <div class="seller-thumb">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset($item->product->image) }}" alt="{{ $item->product_name }}">
                                @else
                                    <span>{{ $item->product->icon ?? '🌱' }}</span>
                                @endif
                            </div>

                            <div style="flex: 1;">
                                <strong style="font-size: 0.92rem; color: #1e293b; display: block;">{{ $item->product_name }}</strong>
                                <span style="font-size: 0.82rem; color: #64748b;">
                                    Harga: Rp{{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}
                                </span>

                                @if($item->rating)
                                    <div style="margin-top: 4px; font-size: 0.8rem; color: #713f12; background: #fefce8; padding: 4px 8px; border-radius: 6px; display: inline-block;">
                                        Ulasan Pembeli:
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-solid fa-star" style="color: {{ $i <= $item->rating ? '#eab308' : '#cbd5e1' }}; font-size: 11px;"></i>
                                        @endfor
                                        "{{ $item->review }}"
                                    </div>
                                @endif
                            </div>

                            <div style="font-weight: 700; color: #166534; font-size: 0.95rem;">
                                Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="seller-card-bottom">
                    <div>
                        <span style="font-size: 0.85rem; color: #64748b;">Metode: <strong>{{ $order->payment_method ?? 'Transfer' }}</strong></span>
                        @if($order->tracking_number)
                            <div style="font-size: 0.85rem; color: #0284c7; font-weight: 600; margin-top: 2px;">
                                <i class="fa-solid fa-truck"></i> {{ $order->shipping_courier }}: <strong>{{ $order->tracking_number }}</strong>
                            </div>
                        @endif
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px;">
                        @if(in_array($order->shopee_status, ['belum_bayar', 'dikemas']))
                            <button type="button" class="btn btn-primary" style="font-size: 0.88rem; padding: 0.55rem 1.2rem;" onclick="openShipModal({{ $order->id }}, '{{ $order->order_number }}')">
                                <i class="fa-solid fa-truck-fast"></i> Proses & Kirim Pesanan
                            </button>
                        @elseif($order->shopee_status === 'dikirim')
                            <span style="color: #0284c7; font-size: 0.85rem; font-weight: 700;">
                                <i class="fa-solid fa-clock"></i> Menunggu Konfirmasi Diterima Pembeli
                            </span>
                        @elseif($order->shopee_status === 'selesai')
                            <span style="color: #16a34a; font-size: 0.85rem; font-weight: 700;">
                                <i class="fa-solid fa-circle-check"></i> Pesanan Selesai
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="shopee-empty-state">
                <span class="shopee-empty-icon">🏪</span>
                <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e3a29; margin-bottom: 0.5rem;">
                    Belum Ada Pesanan Masuk
                </h3>
                <p style="color: #64748b; font-size: 0.95rem; max-width: 440px; margin: 0 auto 1.5rem;">
                    Pesanan dari pelanggan yang membeli produk dari tokomu akan tampil di sini. Pastikan produkmu aktif dan stok tersedia!
                </p>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    ➕ Pasang Produk Baru →
                </a>
            </div>
        @endforelse

    </main>

    {{-- Ship Modal --}}
    <div class="ship-modal-backdrop" id="shipModal">
        <div class="ship-modal-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem;">
                <h3 style="margin: 0; font-size: 1.2rem; color: #1e293b;">
                    <i class="fa-solid fa-truck-fast" style="color: #34754a;"></i> Kirim Pesanan
                </h3>
                <span style="cursor: pointer; font-size: 1.2rem; color: #94a3b8;" onclick="closeShipModal()">✕</span>
            </div>

            <p style="font-size: 0.88rem; color: #64748b; margin-bottom: 1.2rem;">
                Kirim pesanan <strong id="shipOrderNumber" style="color:#1e293b;">-</strong> ke alamat pembeli.
            </p>

            <form id="shipForm" action="" method="POST">
                @csrf
                <div style="margin-bottom: 1.2rem;">
                    <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #334155; margin-bottom: 0.4rem;">
                        Pilih Jasa Ekspedisi / Kurir:
                    </label>
                    <select name="shipping_courier" class="form-control" style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 0.7rem; font-size: 0.9rem;" required>
                        <option value="Kurir TaniExpress">🚜 Kurir TaniExpress (Lokal)</option>
                        <option value="J&T Express">🚚 J&T Express</option>
                        <option value="SiCepat Reguler">⚡ SiCepat Reguler</option>
                        <option value="JNE OKE/Reguler">📦 JNE Express</option>
                        <option value="Kurir Petani Mandiri">🌱 Diantar Sendiri oleh Petani</option>
                    </select>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #334155; margin-bottom: 0.4rem;">
                        Nomor Resi / Bukti Pengiriman (Opsional):
                    </label>
                    <input 
                        type="text" 
                        name="tracking_number" 
                        placeholder="Contoh: TMX-8891238472 (Biarkan kosong untuk otomatis)"
                        style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 0.7rem; font-size: 0.9rem; box-sizing: border-box;"
                    >
                </div>

                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                    <button type="button" class="btn btn-secondary" onclick="closeShipModal()">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background: #34754a;">
                        <i class="fa-solid fa-paper-plane"></i> Konfirmasi Pengiriman
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.footer')

    <script>
        function openShipModal(orderId, orderNum) {
            document.getElementById('shipOrderNumber').textContent = orderNum;
            document.getElementById('shipForm').action = '/pesanan/' + orderId + '/kirim';
            document.getElementById('shipModal').classList.add('show');
        }

        function closeShipModal() {
            document.getElementById('shipModal').classList.remove('show');
        }
    </script>

</body>
</html>
