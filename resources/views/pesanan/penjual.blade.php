
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

        .seller-tabs {
            display: flex;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 15px #0001;
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
            transition: 0.2s;
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

        .seller-card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 16px #0001;
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
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
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
            border-bottom: 0;
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

        .seller-cancel-panel {
            margin: 0 1.4rem 1rem;
            border: 1px solid #fbbf24;
            background: #fffbeb;
            border-radius: 12px;
            padding: 1rem;
        }

        .seller-cancel-panel strong {
            color: #92400e;
        }

        .seller-cancel-panel p {
            color: #78350f;
            font-size: 0.86rem;
            margin: 0.4rem 0 0.8rem;
        }

        .seller-cancel-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
        }

        .seller-cancel-actions form {
            margin: 0;
        }

        .seller-cancel-actions button {
            padding: 0.55rem 1rem;
            border-radius: 9px;
            border: 0;
            color: #fff;
            cursor: pointer;
            font-weight: 700;
        }

        .seller-cancel-actions .approve {
            background: #15803d;
        }

        .seller-cancel-actions .reject {
            background: #b91c1c;
        }

        .seller-cancel-note {
            padding: 0.5rem 1.4rem 1rem;
            font-size: 0.87rem;
            color: #92400e;
        }

        .btn-start-processing {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #24583b;
            color: white;
            border: 0;
            border-radius: 10px;
            padding: 0.65rem 1.2rem;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-start-processing:hover {
            background: #17452d;
        }

        .seller-process-note {
            color: #92400e;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 0.84rem;
            font-weight: 600;
        }

        .ship-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.55);
            z-index: 99999;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .ship-modal-backdrop.show {
            display: flex !important;
        }

        .ship-modal-card {
            background: white;
            border-radius: 20px;
            width: 100%;
            max-width: 480px;
            padding: 1.75rem;
            box-shadow: 0 20px 40px #0003;
            max-height: 90vh;
            overflow-y: auto;
        }

        .ship-form-label {
            display: block;
            font-size: 0.88rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.4rem;
        }

        .ship-form-field {
            width: 100%;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            padding: 0.7rem;
            font-size: 0.9rem;
            box-sizing: border-box;
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    <main class="seller-orders-wrapper">

        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="site-toast site-toast-success" id="toastSuccess">
                <span>✅ {{ session('success') }}</span>
                <span
                    style="cursor:pointer;opacity:.7;margin-left:8px;"
                    onclick="this.parentElement.remove()"
                >✕</span>
            </div>
        @endif

        @if(session('error'))
            <div class="site-toast site-toast-error" id="toastError">
                <span>⚠️ {{ session('error') }}</span>
                <span
                    style="cursor:pointer;opacity:.7;margin-left:8px;"
                    onclick="this.parentElement.remove()"
                >✕</span>
            </div>
        @endif

        @if($errors->any())
            <div
                class="site-toast site-toast-error"
                style="position:relative;margin-bottom:1rem;"
            >
                ⚠️ {{ $errors->first() }}
            </div>
        @endif

        {{-- HEADER --}}
        <div class="seller-header-bar">
            <div>
                <h1 class="seller-title">
                    <i
                        class="fa-solid fa-boxes-stacked"
                        style="color:#34754a;"
                    ></i>
                    Pesanan Masuk Toko Anda
                </h1>

                <p class="seller-subtitle">
                    Kelola pesanan produk pertanian milik toko Anda
                    tanpa tercampur dengan penjual lain.
                </p>
            </div>

            <a
                href="{{ route('products.my') }}"
                class="btn btn-secondary"
                style="font-size:.88rem;text-decoration:none;"
            >
                <i class="fa-solid fa-seedling"></i>
                Kelola Produk Saya
            </a>
        </div>

        {{-- TAB NAVIGASI --}}
        <div class="seller-tabs">

            <a
                href="{{ route('pesanan.penjual', ['tab' => 'semua']) }}"
                class="seller-tab-btn {{ $statusTab === 'semua' ? 'active' : '' }}"
            >
                Semua ({{ $counts['semua'] ?? 0 }})
            </a>

            <a
                href="{{ route('pesanan.penjual', ['tab' => 'perlu_dikemas']) }}"
                class="seller-tab-btn {{ $statusTab === 'perlu_dikemas' ? 'active' : '' }}"
            >
                Perlu Dikemas

                @if(($counts['perlu_dikemas'] ?? 0) > 0)
                    <span style="
                        background:#ea580c;
                        color:white;
                        font-size:11px;
                        padding:2px 7px;
                        border-radius:10px;
                    ">
                        {{ $counts['perlu_dikemas'] }}
                    </span>
                @endif
            </a>

            <a
                href="{{ route('pesanan.penjual', ['tab' => 'dikirim']) }}"
                class="seller-tab-btn {{ $statusTab === 'dikirim' ? 'active' : '' }}"
            >
                Sedang Dikirim ({{ $counts['dikirim'] ?? 0 }})
            </a>

            <a
                href="{{ route('pesanan.penjual', ['tab' => 'selesai']) }}"
                class="seller-tab-btn {{ $statusTab === 'selesai' ? 'active' : '' }}"
            >
                Selesai ({{ $counts['selesai'] ?? 0 }})
            </a>

            <a
                href="{{ route('pesanan.penjual', ['tab' => 'dibatalkan']) }}"
                class="seller-tab-btn {{ $statusTab === 'dibatalkan' ? 'active' : '' }}"
            >
                Dibatalkan ({{ $counts['dibatalkan'] ?? 0 }})
            </a>
        </div>

        {{-- DAFTAR PESANAN --}}
        @forelse($orders as $order)

            @php
                $stInfo = $order->status_info;

                $cancelRows = $order->cancellationApprovals;

                $myCancel = $cancelRows->firstWhere(
                    'seller_id',
                    auth()->id()
                );

                $cancelRejected = $cancelRows->contains(
                    'status',
                    'rejected'
                );

                $cancelPending = !$cancelRejected &&
                    $cancelRows->contains('status', 'pending');

                $cancelApprovedWaiting = !$cancelRejected &&
                    $cancelRows->contains('status', 'approved') &&
                    $cancelPending;

                $paymentReady =
                    $order->payment_method === 'COD (Bayar di Tempat)' ||
                    $order->paid_at !== null;

                // Penjual belum mulai mengerjakan pesanan.
                $canStart =
                    $order->status === 'dikemas' &&
                    $paymentReady &&
                    !$cancelPending &&
                    $order->shipped_at === null;

                // Penjual sudah memulai, boleh mengirim.
                $canShip =
                    $order->status === 'diproses' &&
                    $paymentReady &&
                    !$cancelPending &&
                    $order->shipped_at === null;
            @endphp

            <div class="seller-card">

                {{-- HEADER KARTU --}}
                <div class="seller-card-top">
                    <div>
                        <span style="
                            font-weight:700;
                            color:#1e293b;
                            font-size:.95rem;
                        ">
                            <i
                                class="fa-solid fa-receipt"
                                style="color:#34754a;"
                            ></i>
                            {{ $order->order_number }}
                        </span>

                        <span style="
                            font-size:.8rem;
                            color:#64748b;
                            margin-left:8px;
                        ">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>

                    <span
                        class="shopee-status-pill"
                        style="
                            color:{{ $stInfo['color'] }};
                            background:{{ $stInfo['bg'] }};
                            font-size:.8rem;
                            padding:4px 10px;
                            border-radius:999px;
                            font-weight:700;
                        "
                    >
                        <i class="{{ $stInfo['icon'] }}"></i>
                        {{ $stInfo['label'] }}
                    </span>
                </div>

                {{-- ISI KARTU --}}
                <div class="seller-card-body">

                    {{-- INFORMASI PEMBELI --}}
                    <div class="buyer-info-box">
                        <div class="buyer-details">

                            <strong>
                                <i class="fa-solid fa-user"></i>
                                {{ $order->customer_name }}
                            </strong>

                            <span style="
                                font-size:.85rem;
                                color:#166534;
                                margin-left:6px;
                            ">
                                ({{ $order->customer_phone }})
                            </span>

                            <p>
                                <i
                                    class="fa-solid fa-location-dot"
                                    style="color:#ef4444;"
                                ></i>
                                Alamat: {{ $order->customer_address }}
                            </p>
                        </div>

                        @if(
                            $order->user_id &&
                            (int) $order->user_id !== (int) auth()->id()
                        )
                            <a
                                href="{{ route('chat.index', ['user_id' => $order->user_id]) }}"
                                class="btn-chat-buyer"
                                title="Hubungi pembeli"
                            >
                                <i class="fa-solid fa-comment-dots"></i>
                                Chat Pembeli
                            </a>
                        @endif
                    </div>

                    {{-- DAFTAR PRODUK --}}
                    <div style="
                        font-size:.82rem;
                        font-weight:700;
                        color:#64748b;
                        text-transform:uppercase;
                        margin-bottom:6px;
                    ">
                        Produk Toko Anda yang Dipesan:
                    </div>

                    @foreach($order->items as $item)
                        <div class="seller-product-item">

                            <div class="seller-thumb">
                                @if(
                                    $item->product &&
                                    $item->product->image
                                )
                                    <img
                                        src="{{ asset($item->product->image) }}"
                                        alt="{{ $item->product_name }}"
                                    >
                                @else
                                    <span>
                                        {{ $item->product->icon ?? '🌱' }}
                                    </span>
                                @endif
                            </div>

                            <div style="flex:1;">
                                <strong style="
                                    font-size:.92rem;
                                    color:#1e293b;
                                    display:block;
                                ">
                                    {{ $item->product_name }}
                                </strong>

                                <span style="
                                    font-size:.82rem;
                                    color:#64748b;
                                ">
                                    Harga:
                                    Rp{{ number_format($item->price, 0, ',', '.') }}
                                    × {{ $item->quantity }}
                                </span>

                                {{-- ULASAN --}}
                                @if($item->rating)
                                    <div style="
                                        margin-top:4px;
                                        font-size:.8rem;
                                        color:#713f12;
                                        background:#fefce8;
                                        padding:4px 8px;
                                        border-radius:6px;
                                        display:inline-block;
                                    ">
                                        Ulasan Pembeli:

                                        @for($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fa-solid fa-star"
                                                style="
                                                    color:{{ $i <= $item->rating ? '#eab308' : '#cbd5e1' }};
                                                    font-size:11px;
                                                "
                                            ></i>
                                        @endfor

                                        "{{ $item->review }}"
                                    </div>
                                @endif
                            </div>

                            <div style="
                                font-weight:700;
                                color:#166534;
                                font-size:.95rem;
                            ">
                                Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- PERMINTAAN PEMBATALAN --}}
                @if(
                    $myCancel &&
                    $myCancel->status === 'pending' &&
                    !$cancelRejected &&
                    $order->status === 'diproses'
                )
                    <div class="seller-cancel-panel">

                        <strong>
                            <i class="fa-solid fa-circle-exclamation"></i>
                            Permintaan Pembatalan dari Pembeli
                        </strong>

                        <p>
                            Alasan:
                            {{ $order->cancellation_reason ?? 'Tidak disebutkan' }}
                        </p>

                        <p>
                            Keputusanmu hanya berlaku untuk produk tokomu.
                            Jika pesanan berisi produk beberapa seller,
                            semuanya harus menyetujui pembatalan.
                        </p>

                        <div class="seller-cancel-actions">

                            <form
                                action="{{ route('pesanan.cancel.review', $order->id) }}"
                                method="POST"
                                onsubmit="return confirm('Setujui permintaan pembatalan ini?')"
                            >
                                @csrf
                                <input
                                    type="hidden"
                                    name="decision"
                                    value="approve"
                                >

                                <button class="approve" type="submit">
                                    <i class="fa-solid fa-check"></i>
                                    Setujui
                                </button>
                            </form>

                            <form
                                action="{{ route('pesanan.cancel.review', $order->id) }}"
                                method="POST"
                                onsubmit="return confirm('Tolak permintaan pembatalan ini?')"
                            >
                                @csrf
                                <input
                                    type="hidden"
                                    name="decision"
                                    value="reject"
                                >

                                <button class="reject" type="submit">
                                    <i class="fa-solid fa-xmark"></i>
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </div>

                @elseif(
                    $cancelApprovedWaiting &&
                    $myCancel &&
                    $myCancel->status === 'approved'
                )
                    <div class="seller-cancel-note">
                        ⏳ Persetujuanmu telah dicatat.
                        Menunggu persetujuan penjual lain.
                    </div>

                @elseif($cancelRejected && $myCancel)
                    <div class="seller-cancel-note">
                        ℹ️ Pengajuan pembatalan ditolak.
                        Pesanan tetap berjalan.
                    </div>
                @endif

                {{-- FOOTER KARTU --}}
                <div class="seller-card-bottom">

                    <div>
                        <span style="
                            font-size:.85rem;
                            color:#64748b;
                        ">
                            Metode:
                            <strong>
                                {{ $order->payment_method ?? 'Transfer' }}
                            </strong>
                        </span>

                        @if($order->tracking_number)
                            <div style="
                                font-size:.85rem;
                                color:#0284c7;
                                font-weight:600;
                                margin-top:2px;
                            ">
                                <i class="fa-solid fa-truck"></i>
                                {{ $order->shipping_courier }}:

                                <strong>
                                    {{ $order->tracking_number }}
                                </strong>
                            </div>
                        @endif
                    </div>

                    <div style="
                        display:flex;
                        align-items:center;
                        gap:8px;
                        flex-wrap:wrap;
                    ">

                        {{-- MENUNGGU PEMBATALAN --}}
                        @if($cancelPending)
                            <span class="seller-process-note">
                                <i class="fa-solid fa-hourglass-half"></i>
                                Pengiriman ditahan:
                                menunggu keputusan pembatalan
                            </span>

                        {{-- MULAI PROSES --}}
                        @elseif($canStart)
                            <form
                                action="{{ route('orders.start-processing', $order->id) }}"
                                method="POST"
                                style="margin:0;"
                                onsubmit="return confirm('Mulai memproses pesanan ini? Setelah itu pembatalan perlu persetujuan seller.')"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="btn-start-processing"
                                >
                                    <i class="fa-solid fa-box-open"></i>
                                    Mulai Proses Pesanan
                                </button>
                            </form>

                        {{-- TOMBOL KIRIM: SUDAH DIPERBAIKI --}}
                        @elseif($canShip)

                            <button
                                type="button"
                                class="btn btn-primary"
                                style="
                                    font-size:.88rem;
                                    padding:.55rem 1.2rem;
                                "
                                data-order-number="{{ $order->order_number }}"
                                data-ship-url="{{ route('pesanan.ship', $order->id) }}"
                                onclick="openShipModal(this)"
                            >
                                <i class="fa-solid fa-truck-fast"></i>
                                Kirim Pesanan
                            </button>

                        {{-- BELUM DIBAYAR --}}
                        @elseif(
                            in_array(
                                $order->status,
                                ['belum_bayar', 'pending'],
                                true
                            )
                        )
                            <span class="seller-process-note">
                                <i class="fa-solid fa-wallet"></i>
                                Menunggu pembayaran pembeli
                            </span>

                        {{-- BELUM DIPROSES --}}
                        @elseif($order->status === 'dikemas')
                            <span class="seller-process-note">
                                <i class="fa-solid fa-clock"></i>
                                Menunggu proses pesanan
                            </span>

                        {{-- SEDANG DIPROSES --}}
                        @elseif($order->status === 'diproses')
                            <span class="seller-process-note">
                                <i class="fa-solid fa-box-open"></i>
                                Pesanan sedang diproses
                            </span>

                        {{-- DIKIRIM --}}
                        @elseif($order->shopee_status === 'dikirim')
                            <span style="
                                color:#0284c7;
                                font-size:.85rem;
                                font-weight:700;
                            ">
                                <i class="fa-solid fa-clock"></i>
                                Menunggu konfirmasi pembeli
                            </span>

                        {{-- SELESAI --}}
                        @elseif($order->shopee_status === 'selesai')
                            <span style="
                                color:#16a34a;
                                font-size:.85rem;
                                font-weight:700;
                            ">
                                <i class="fa-solid fa-circle-check"></i>
                                Pesanan Selesai
                            </span>

                        {{-- DIBATALKAN --}}
                        @elseif($order->shopee_status === 'dibatalkan')
                            <span style="
                                color:#dc2626;
                                font-size:.85rem;
                                font-weight:700;
                            ">
                                <i class="fa-solid fa-circle-xmark"></i>
                                Pesanan Dibatalkan
                            </span>
                        @endif
                    </div>
                </div>
            </div>

        @empty
            <div class="shopee-empty-state">
                <span class="shopee-empty-icon">🏪</span>

                <h3 style="
                    font-size:1.25rem;
                    font-weight:800;
                    color:#1e3a29;
                    margin-bottom:.5rem;
                ">
                    Belum Ada Pesanan Masuk
                </h3>

                <p style="
                    color:#64748b;
                    font-size:.95rem;
                    max-width:440px;
                    margin:0 auto 1.5rem;
                ">
                    Pesanan dari pelanggan yang membeli produk
                    dari tokomu akan tampil di sini.
                    Pastikan produkmu aktif dan stok tersedia!
                </p>

                <a
                    href="{{ route('products.create') }}"
                    class="btn btn-primary"
                >
                    ➕ Pasang Produk Baru →
                </a>
            </div>
        @endforelse
    </main>

    {{-- MODAL PENGIRIMAN --}}
    <div
        class="ship-modal-backdrop"
        id="shipModal"
        role="dialog"
        aria-modal="true"
        aria-hidden="true"
    >
        <div class="ship-modal-card">

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                margin-bottom:1.2rem;
            ">
                <h3 style="
                    margin:0;
                    font-size:1.2rem;
                    color:#1e293b;
                ">
                    <i
                        class="fa-solid fa-truck-fast"
                        style="color:#34754a;"
                    ></i>
                    Kirim Pesanan
                </h3>

                <button
                    type="button"
                    style="
                        border:0;
                        background:none;
                        cursor:pointer;
                        font-size:1.2rem;
                        color:#94a3b8;
                    "
                    onclick="closeShipModal()"
                    aria-label="Tutup"
                >✕</button>
            </div>

            <p style="
                font-size:.88rem;
                color:#64748b;
                margin-bottom:1.2rem;
            ">
                Kirim pesanan
                <strong
                    id="shipOrderNumber"
                    style="color:#1e293b;"
                >-</strong>
                ke alamat pembeli.
            </p>

            <form
                id="shipForm"
                action=""
                method="POST"
            >
                @csrf

                <div style="margin-bottom:1.2rem;">
                    <label
                        class="ship-form-label"
                        for="shippingCourier"
                    >
                        Pilih Jasa Ekspedisi / Kurir:
                    </label>

                    <select
                        id="shippingCourier"
                        name="shipping_courier"
                        class="ship-form-field"
                        required
                    >
                        <option value="Kurir TaniExpress">
                            🚜 Kurir TaniExpress (Lokal)
                        </option>

                        <option value="J&T Express">
                            🚚 J&T Express
                        </option>

                        <option value="SiCepat Reguler">
                            ⚡ SiCepat Reguler
                        </option>

                        <option value="JNE OKE/Reguler">
                            📦 JNE Express
                        </option>

                        <option value="Kurir Petani Mandiri">
                            🌱 Diantar Sendiri oleh Petani
                        </option>
                    </select>
                </div>

                <div style="margin-bottom:1.5rem;">
                    <label
                        class="ship-form-label"
                        for="trackingNumber"
                    >
                        Nomor Resi / Bukti Pengiriman (Opsional):
                    </label>

                    <input
                        id="trackingNumber"
                        type="text"
                        name="tracking_number"
                        class="ship-form-field"
                        placeholder="Kosongkan untuk nomor otomatis"
                    >
                </div>

                <div style="
                    display:flex;
                    gap:8px;
                    justify-content:flex-end;
                    flex-wrap:wrap;
                ">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="closeShipModal()"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        style="background:#34754a;"
                    >
                        <i class="fa-solid fa-paper-plane"></i>
                        Konfirmasi Pengiriman
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.footer')

    <script>
        function openShipModal(button) {
            const modal = document.getElementById('shipModal');
            const form = document.getElementById('shipForm');

            if (!modal || !form) {
                alert(
                    'Form pengiriman tidak ditemukan. ' +
                    'Periksa halaman penjual.'
                );
                return;
            }

            document.getElementById(
                'shipOrderNumber'
            ).textContent = button.dataset.orderNumber || '-';

            form.action = button.dataset.shipUrl;

            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
        }

        function closeShipModal() {
            const modal = document.getElementById('shipModal');

            if (!modal) {
                return;
            }

            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeShipModal();
            }
        });
    </script>

</body>
</html>
