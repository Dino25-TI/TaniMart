@php
    $cartItems = session('keranjang', []);
    $cartTotalQty = 0;
    foreach ($cartItems as $item) {
        $cartTotalQty += ($item['jumlah'] ?? 1);
    }
@endphp

<header class="tm-navbar-wrapper">
    <nav class="tm-navbar">
        <!-- Logo & Brand -->
        <a href="/" class="tm-navbar-brand">
            <span class="tm-brand-icon">🌱</span>
            <span class="tm-brand-name">Tani<span>Mart</span></span>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="tm-mobile-toggle" type="button" aria-label="Toggle navigasi" onclick="toggleMobileNav(event)">
            <span class="toggle-bar"></span>
            <span class="toggle-bar"></span>
            <span class="toggle-bar"></span>
        </button>

        <!-- Navigation Links Container -->
        <div class="tm-navbar-collapse" id="tmNavbarMenu">
            <div class="tm-nav-main">
                <a href="/" class="tm-nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
                <a href="/#kategori" class="tm-nav-link">
                    <i class="fa-solid fa-shapes"></i> Kategori
                </a>
                <a href="/#produk" class="tm-nav-link">
                    <i class="fa-solid fa-basket-shopping"></i> Produk Pasar
                </a>
                <a href="/konsultasi" class="tm-nav-link tm-nav-ai {{ request()->is('konsultasi*') ? 'active' : '' }}">
                    <span class="ai-sparkle">✨</span> Tanya AI
                    <span class="ai-badge-chip">Gemini</span>
                </a>

                @auth
                    <a href="{{ route('products.create') }}" class="tm-nav-link tm-nav-sell {{ request()->is('jual-produk*') ? 'active' : '' }}">
                        <i class="fa-solid fa-circle-plus"></i> Jual Produk
                    </a>
                    <a href="{{ route('products.my') }}" class="tm-nav-link {{ request()->is('produk-saya*') ? 'active' : '' }}">
                        <i class="fa-solid fa-box-archive"></i> Produk Saya
                    </a>
                @endauth
            </div>

            <div class="tm-nav-actions">
                <!-- Cart Button -->
                <a href="/keranjang" class="tm-nav-cart {{ request()->is('keranjang*') || request()->is('checkout*') ? 'active' : '' }}" title="Keranjang Belanja">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-label">Keranjang</span>
                    @if($cartTotalQty > 0)
                        <span class="tm-cart-badge">{{ $cartTotalQty > 99 ? '99+' : $cartTotalQty }}</span>
                    @endif
                </a>

                <!-- Chat Button (Shopee Style) -->
                @auth
                    @php
                        $unreadChatCount = auth()->user()->unreadMessagesCount();
                    @endphp
                    <a href="{{ route('chat.index') }}" class="tm-nav-cart {{ request()->is('pesan*') || request()->is('chat*') ? 'active' : '' }}" title="Obrolan Pesan" style="border-color: #cbd5e1;">
                        <i class="fa-solid fa-comments" style="color: #2d6a4f;"></i>
                        <span class="cart-label">Pesan</span>
                        @if($unreadChatCount > 0)
                            <span class="tm-cart-badge" style="background: #16a34a;">{{ $unreadChatCount > 99 ? '99+' : $unreadChatCount }}</span>
                        @endif
                    </a>
                @endauth

                <!-- User / Auth Section -->
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="tm-admin-pill {{ request()->is('admin*') ? 'active' : '' }}" title="Dashboard Administrator">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Admin</span>
                        </a>
                    @endif

                    <!-- Unified Account Capsule: Avatar + Name + Divider + Logout -->
                    <div class="tm-account-capsule">
                        <!-- User Dropdown Trigger -->
                        <div class="tm-user-dropdown" id="tmUserDropdownContainer">
                            <button type="button" class="tm-user-trigger" onclick="toggleUserDropdown(event)" aria-label="Menu Akun Saya">
                                <div class="tm-avatar-circle">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="tm-user-name">{{ Str::limit(auth()->user()->name, 11) }}</span>
                                <i class="fa-solid fa-chevron-down tm-chevron" id="tmDropdownChevron"></i>
                            </button>

                            <!-- Dropdown Menu Floating Card -->
                            <div class="tm-dropdown-menu" id="tmDropdownMenu">
                                <div class="tm-dropdown-header">
                                    <div class="tm-dropdown-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                                    <div class="tm-dropdown-info">
                                        <strong>{{ auth()->user()->name }}</strong>
                                        <small>{{ auth()->user()->email }}</small>
                                        @if(auth()->user()->isAdmin())
                                            <span class="tm-role-tag tm-role-admin">🛡️ Administrator</span>
                                        @else
                                            <span class="tm-role-tag tm-role-user">🌱 Petani / Pembeli</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="tm-dropdown-divider"></div>

                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="tm-dropdown-item tm-item-admin">
                                        <i class="fa-solid fa-shield-halved"></i>
                                        <span>Dashboard Admin</span>
                                    </a>
                                @endif

                                <a href="{{ route('products.create') }}" class="tm-dropdown-item">
                                    <i class="fa-solid fa-circle-plus"></i>
                                    <span>Jual Produk Baru</span>
                                </a>

                                <a href="{{ route('products.my') }}" class="tm-dropdown-item">
                                    <i class="fa-solid fa-box-archive"></i>
                                    <span>Kelola Produk Saya</span>
                                </a>

                                <a href="{{ route('chat.index') }}" class="tm-dropdown-item">
                                    <i class="fa-solid fa-comments"></i>
                                    <span>Obrolan &amp; Pesan</span>
                                    @if(isset($unreadChatCount) && $unreadChatCount > 0)
                                        <span class="tm-dropdown-badge">{{ $unreadChatCount }}</span>
                                    @endif
                                </a>

                                <div class="tm-dropdown-divider"></div>

                                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="tm-dropdown-logout-btn">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                        <span>Keluar dari Akun</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Capsule Divider -->
                        <div class="tm-capsule-sep"></div>

                        <!-- Logout Button — nestled inside capsule -->
                        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="tm-capsule-logout" title="Keluar dari akun">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span class="tm-logout-label">Keluar</span>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="tm-btn-login">
                        <i class="fa-solid fa-right-to-bracket"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="tm-btn-register">
                        Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </nav>
</header>

<script>
    function toggleMobileNav(event) {
        event.stopPropagation();
        const menu = document.getElementById('tmNavbarMenu');
        if (menu) {
            menu.classList.toggle('show');
        }
    }

    function toggleUserDropdown(event) {
        event.stopPropagation();
        const menu = document.getElementById('tmDropdownMenu');
        const container = document.getElementById('tmUserDropdownContainer');
        if (menu) {
            menu.classList.toggle('show');
            if (container) {
                container.classList.toggle('active');
            }
        }
    }

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('tmDropdownMenu');
        const container = document.getElementById('tmUserDropdownContainer');
        if (dropdown && dropdown.classList.contains('show')) {
            if (!container || !container.contains(event.target)) {
                dropdown.classList.remove('show');
                if (container) container.classList.remove('active');
            }
        }
    });

    // Tutup dropdown saat tekan tombol Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const dropdown = document.getElementById('tmDropdownMenu');
            const container = document.getElementById('tmUserDropdownContainer');
            if (dropdown) dropdown.classList.remove('show');
            if (container) container.classList.remove('active');
        }
    });
</script>
