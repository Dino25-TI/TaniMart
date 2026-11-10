<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan & Chat Penjual | TaniMart</title>
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tanimart-chat.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    @include('partials.navbar')

    <main class="chat-page-wrapper">
        <div class="shopee-chat-card">

            <!-- SIDEBAR: DAFTAR PERCAKAPAN -->
            <aside class="chat-sidebar">
                <div class="chat-sidebar-header">
                    <h2 class="chat-sidebar-title">
                        <i class="fa-solid fa-comments" style="color: #2d6a4f;"></i> Obrolan Saya
                    </h2>
                    <span style="font-size: 12px; color: #64748b; font-weight: 600;">
                        {{ $conversations->count() }} Kontak
                    </span>
                </div>

                <div class="chat-conv-list">
                    @forelse($conversations as $conv)
                        <a href="{{ route('chat.index', ['user_id' => $conv['user']->id]) }}" 
                           class="chat-conv-item {{ ($activeUser && $activeUser->id === $conv['user']->id) ? 'active' : '' }}">
                            
                            <div class="conv-avatar-wrap">
                                <div class="conv-avatar">
                                    {{ strtoupper(substr($conv['user']->name, 0, 1)) }}
                                </div>
                                <span class="online-dot" title="Aktif"></span>
                            </div>

                            <div class="conv-info">
                                <div class="conv-top-row">
                                    <span class="conv-name">
                                        {{ $conv['user']->name }}
                                        @if($conv['user']->isAdmin())
                                            <span class="role-badge role-admin">Admin</span>
                                        @else
                                            <span class="role-badge role-seller">Mitra Tani</span>
                                        @endif
                                    </span>
                                    <span class="conv-time">
                                        {{ $conv['last_message'] ? $conv['last_message']->created_at->format('H:i') : '' }}
                                    </span>
                                </div>

                                <div class="conv-bottom-row">
                                    <span class="conv-snippet">
                                        @if($conv['last_message'])
                                            @if($conv['last_message']->sender_id === auth()->id())
                                                <span style="color: #2d6a4f;">Anda: </span>
                                            @endif
                                            {{ Str::limit($conv['last_message']->message, 28) }}
                                        @else
                                            <em>Mulai percakapan...</em>
                                        @endif
                                    </span>

                                    @if($conv['unread_count'] > 0)
                                        <span class="conv-badge-unread">{{ $conv['unread_count'] }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="conv-empty-state">
                            <i class="fa-regular fa-message" style="font-size: 32px; margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                            Belum ada percakapan.<br>Klik tombol <strong>Chat Penjual</strong> di halaman produk untuk memulai.
                        </div>
                    @endforelse
                </div>
            </aside>

            <!-- RUANG CHAT UTAMA -->
            <section class="chat-main-room">
                @if($activeUser)
                    <!-- Header Ruang Chat -->
                    <div class="chat-room-header">
                        <div class="room-partner-info">
                            <div class="conv-avatar" style="width: 42px; height: 42px; font-size: 16px;">
                                {{ strtoupper(substr($activeUser->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="room-partner-name" style="margin: 0;">
                                    {{ $activeUser->name }}
                                    @if($activeUser->isAdmin())
                                        <span class="role-badge role-admin">Admin Toko</span>
                                    @else
                                        <span class="role-badge role-seller">Penjual / Mitra Tani</span>
                                    @endif
                                </h3>
                                <span class="room-partner-status">
                                    <span style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%; display: inline-block;"></span>
                                    Online • Siap Melayani
                                </span>
                            </div>
                        </div>

                        <div>
                            <a href="/" class="btn btn-secondary" style="font-size: 12px; padding: 6px 12px; background: #f8faf8;">
                                <i class="fa-solid fa-store"></i> Lihat Pasar
                            </a>
                        </div>
                    </div>

                    <!-- Pinned Product Card (Gaya Shopee: Lampiran Produk yang Ditanyakan) -->
                    @if($product)
                        <div class="chat-pinned-product">
                            <div class="pinned-prod-content">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="pinned-prod-thumb">
                                @else
                                    <div class="pinned-prod-thumb">{{ $product->icon ?? '🌱' }}</div>
                                @endif
                                <div style="min-width: 0;">
                                    <div class="pinned-prod-title">{{ $product->name }}</div>
                                    <div class="pinned-prod-price">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                        <span style="font-size: 11px; font-weight: normal; color: #64748b;">/ {{ $product->unit }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pinned-prod-actions">
                                <button type="button" class="btn-ask-prod" onclick="fillTemplate('Halo, apakah produk {{ addslashes($product->name) }} ini masih tersedia stoknya?')">
                                    <i class="fa-solid fa-paper-plane"></i> Tanyakan Produk
                                </button>
                                <form action="{{ url('/keranjang/tambah/' . $product->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">
                                        + Beli
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Area Pesan (Scrollable) -->
                    <div class="chat-messages-container" id="chatMessageList">
                        @forelse($messages as $msg)
                            @php
                                $isMe = ($msg->sender_id === auth()->id());
                            @endphp

                            <div class="chat-bubble-row {{ $isMe ? 'chat-row-sent' : 'chat-row-received' }}">
                                @if(!$isMe)
                                    <div class="conv-avatar" style="width: 32px; height: 32px; font-size: 12px; flex-shrink: 0;">
                                        {{ strtoupper(substr($msg->sender->name, 0, 1)) }}
                                    </div>
                                @endif

                                <div class="chat-bubble {{ $isMe ? 'bubble-sent' : 'bubble-received' }}">
                                    <!-- Jika pesan menyertakan rujukan produk (Shopee Style) -->
                                    @if($msg->product)
                                        <div class="chat-bubble-product-snippet">
                                            <span style="font-size: 20px;">{{ $msg->product->icon ?? '🌱' }}</span>
                                            <div>
                                                <strong style="font-size: 12px; display: block;">{{ $msg->product->name }}</strong>
                                                <span style="font-size: 11px; font-weight: 700;">Rp{{ number_format($msg->product->price, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    <div>{!! nl2br(e($msg->message)) !!}</div>

                                    <div class="bubble-meta">
                                        <span>{{ $msg->created_at->format('H:i') }}</span>
                                        @if($isMe)
                                            <i class="fa-solid fa-check-double" style="color: {{ $msg->is_read ? '#67e8f9' : 'rgba(255,255,255,0.6)' }};" title="{{ $msg->is_read ? 'Sudah dibaca' : 'Terkirim' }}"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="chat-room-empty">
                                <div class="chat-room-empty-icon">💬</div>
                                <h4 style="color: #475569; margin-bottom: 6px;">Mulai Obrolan dengan {{ $activeUser->name }}</h4>
                                <p style="font-size: 13px; max-width: 380px;">
                                    Tanyakan detail produk pertanian, negosiasi, atau kesiapan stok pengiriman langsung kepada penjual.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Template Pertanyaan Cepat (Gaya Shopee) -->
                    <div class="chat-quick-templates">
                        <span style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Cepat:</span>
                        <button type="button" class="quick-pill" onclick="fillTemplate('Halo, apakah barang ini masih ready?')">
                            Ready?
                        </button>
                        <button type="button" class="quick-pill" onclick="fillTemplate('Bisa dikirim hari ini?')">
                            Bisa kirim hari ini?
                        </button>
                        <button type="button" class="quick-pill" onclick="fillTemplate('Apakah ada diskon untuk pembelian dalam jumlah banyak?')">
                            Grosir/Diskon?
                        </button>
                        <button type="button" class="quick-pill" onclick="fillTemplate('Kira-kira berapa hari sampai ke lokasi saya?')">
                            Estimasi kirim?
                        </button>
                    </div>

                    <!-- Form Input Pesan -->
                    <form action="{{ route('chat.store', $activeUser->id) }}" method="POST" class="chat-input-bar" id="chatInputForm">
                        @csrf
                        @if($product)
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        @endif

                        <textarea name="message" 
                                  id="chatInputText" 
                                  class="chat-textarea" 
                                  placeholder="Tulis pesan untuk {{ $activeUser->name }}..." 
                                  rows="1" 
                                  required></textarea>

                        <button type="submit" class="btn-chat-send" title="Kirim Pesan">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </form>

                @else
                    <!-- Tampilan saat belum memilih percakapan -->
                    <div class="chat-room-empty">
                        <div class="chat-room-empty-icon">🌱</div>
                        <h3 style="color: #1e3a29; margin-bottom: 8px;">Pusat Pesan TaniMart</h3>
                        <p style="font-size: 14px; max-width: 420px; line-height: 1.6;">
                            Pilih salah satu kontak di sebelah kiri untuk melihat riwayat obrolan, atau kunjungi katalog pasar dan klik <strong>Chat Penjual</strong> untuk menanyakan produk.
                        </p>
                    </div>
                @endif
            </section>

        </div>
    </main>

    <script>
        // Auto scroll ke pesan paling bawah
        function scrollToBottom() {
            const container = document.getElementById('chatMessageList');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }

        window.addEventListener('DOMContentLoaded', scrollToBottom);

        // Isi template pertanyaan cepat
        function fillTemplate(text) {
            const input = document.getElementById('chatInputText');
            if (input) {
                input.value = text;
                input.focus();
            }
        }

        // Kirim dengan tombol Enter (Shift+Enter untuk baris baru)
        const textarea = document.getElementById('chatInputText');
        if (textarea) {
            textarea.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    document.getElementById('chatInputForm').submit();
                }
            });
        }
    </script>

</body>
</html>
