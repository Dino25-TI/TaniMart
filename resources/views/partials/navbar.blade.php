
@php
    // Keranjang berbasis database per akun.
    $cartTotalQty = auth()->check()
        ? \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity')
        : 0;

    // Filter navbar mengikuti pilihan aktif hanya di beranda.
    $navIsHome = request()->path() === '/';

    $navQuery = $navIsHome && is_string(request()->query('q', ''))
        ? trim(request()->query('q', ''))
        : '';

    $navCategory = $navIsHome && is_string(request()->query('kategori', ''))
        ? trim(request()->query('kategori', ''))
        : '';

    $navStockRaw = $navIsHome ? request()->query('stok', '') : '';

    $navStock = is_string($navStockRaw) &&
        in_array($navStockRaw, ['tersedia', 'habis'], true)
            ? $navStockRaw
            : '';

    $navSortRaw = $navIsHome
        ? request()->query('sort', 'terbaru')
        : 'terbaru';

    $navSort = is_string($navSortRaw) &&
        in_array($navSortRaw, ['terbaru', 'termurah', 'termahal'], true)
            ? $navSortRaw
            : 'terbaru';

    $navHasFilter = $navQuery !== '' ||
        $navCategory !== '' ||
        $navStock !== '' ||
        $navSort !== 'terbaru';
@endphp

<style>
    /* Tombol search tidak menyusut di navbar */
    .tm-navbar .tm-search-open {
        flex: 0 0 42px !important;
        width: 42px !important;
        min-width: 42px !important;
        max-width: 42px !important;
        height: 40px !important;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        border: 1px solid #cfe5d5;
        border-radius: 12px;
        background: #edf7f0;
        color: #24583b;
        cursor: pointer;
        font-size: 17px;
        position: relative;
        z-index: 2;
        padding: 0;
        box-sizing: border-box;
    }

    .tm-navbar .tm-search-open:hover,
    .tm-navbar .tm-search-open:focus-visible {
        background: #dff1e5;
        border-color: #78b88c;
        outline: none;
    }

    .tm-navbar .tm-search-open.has-query::after {
        content: '';
        position: absolute;
        right: 5px;
        top: 5px;
        height: 6px;
        width: 6px;
        border-radius: 50%;
        background: #16a34a;
    }

    /* Popup berada di luar header navbar */
    .tm-search-backdrop {
        position: fixed;
        inset: 0;
        z-index: 99980;
        background: rgba(15, 23, 42, 0.22);
        cursor: default;
    }

    .tm-search-overlay {
        position: fixed;
        top: 105px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 99981;
        width: min(640px, calc(100vw - 24px));
        max-height: calc(100dvh - 125px);
        overflow-y: auto;
        background: #fff;
        border: 1px solid #dce8df;
        border-radius: 18px;
        padding: 16px;
        box-shadow: 0 20px 65px rgba(15, 23, 42, .22);
        box-sizing: border-box;
    }

    .tm-search-backdrop[hidden],
    .tm-search-overlay[hidden],
    .tm-search-suggestions[hidden],
    .tm-search-clear[hidden] {
        display: none !important;
    }

    .tm-search-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 12px;
        color: #1e3a29;
        font-size: 15px;
    }

    .tm-search-close {
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        border: 0;
        border-radius: 9px;
        background: #f1f5f9;
        color: #475569;
        cursor: pointer;
    }

    .tm-search-close:hover {
        background: #e2e8f0;
    }

    .tm-search-overlay-form {
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1.5px solid #a7d1b4;
        border-radius: 12px;
        padding: 7px 8px 7px 12px;
        background: #fff;
    }

    .tm-search-overlay-form > .tm-search-leading {
        color: #34754a;
    }

    .tm-search-overlay-input {
        display: block !important;
        flex: 1 1 auto !important;
        min-width: 0 !important;
        width: 100% !important;
        max-width: none !important;
        padding: 8px 2px !important;
        border: 0 !important;
        outline: none !important;
        box-shadow: none !important;
        background: transparent !important;
        color: #1e293b !important;
        font: inherit;
        font-size: 15px !important;
    }

    .tm-search-clear {
        flex-shrink: 0;
        border: 0;
        background: #f1f5f9;
        color: #64748b;
        cursor: pointer;
        width: 26px;
        height: 26px;
        border-radius: 50%;
    }

    .tm-search-submit {
        flex-shrink: 0;
        padding: 10px 14px;
        border: 0;
        border-radius: 9px;
        background: #34754a;
        color: #fff;
        cursor: pointer;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }

    .tm-search-submit:hover {
        background: #24583b;
    }

    .tm-search-help {
        font-size: 12px;
        color: #64748b;
        margin: 11px 2px 0;
    }

    /* Daftar saran produk */
    .tm-search-suggestions {
        margin-top: 11px;
        border-top: 1px solid #f1f5f9;
        padding-top: 7px;
    }

    .tm-search-result-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        padding: 5px 7px 8px;
    }

    .tm-search-result {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 9px 8px;
        border-radius: 10px;
        text-decoration: none;
        color: #1e293b;
    }

    .tm-search-result:hover,
    .tm-search-result.is-active {
        background: #f0fdf4;
    }

    .tm-search-thumb {
        width: 46px;
        height: 46px;
        flex-shrink: 0;
        background: #f0fdf4;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        font-size: 24px;
    }

    .tm-search-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .tm-search-result-text {
        display: flex;
        flex: 1;
        min-width: 0;
        flex-direction: column;
        gap: 3px;
    }

    .tm-search-result-name {
        font-size: 13px;
        font-weight: 700;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .tm-search-result-detail {
        font-size: 11px;
        color: #64748b;
    }

    .tm-search-result-stock {
        font-size: 11px;
        color: #15803d;
        font-weight: 700;
    }

    .tm-search-result-stock.empty {
        color: #b91c1c;
    }

    .tm-search-see-all {
        display: block;
        border-radius: 9px;
        padding: 11px;
        margin-top: 6px;
        background: #ecfdf3;
        color: #166534;
        font-weight: 700;
        font-size: 12px;
        text-align: center;
        text-decoration: none;
    }

    .tm-search-see-all:hover {
        background: #dcfce7;
    }

    .tm-search-empty {
        padding: 14px 9px;
        color: #64748b;
        font-size: 13px;
    }

    @media (max-width: 640px) {
        .tm-search-overlay {
            padding: 12px;
            border-radius: 14px;
        }

        .tm-search-submit {
            padding: 10px 11px;
        }
    }
</style>

<header class="tm-navbar-wrapper">
    <nav class="tm-navbar" aria-label="Navigasi utama TaniMart">

        <!-- Logo & Brand -->
        <a href="/" class="tm-navbar-brand">
            <span class="tm-brand-icon">🌱</span>
            <span class="tm-brand-name">
                Tani<span>Mart</span>
            </span>
        </a>

        <!-- Mobile Toggle -->
        <button
            class="tm-mobile-toggle"
            type="button"
            aria-label="Buka navigasi"
            aria-controls="tmNavbarMenu"
            aria-expanded="false"
            onclick="toggleMobileNav(event)"
        >
            <span class="toggle-bar"></span>
            <span class="toggle-bar"></span>
            <span class="toggle-bar"></span>
        </button>

        <div class="tm-navbar-collapse" id="tmNavbarMenu">

            <!-- Menu Utama -->
            <div class="tm-nav-main">

                <a
                    href="/"
                    class="tm-nav-link {{ $navIsHome && !$navHasFilter ? 'active' : '' }}"
                >
                    <i class="fa-solid fa-house"></i>
                    Beranda
                </a>

                <a
                    href="/#kategori"
                    class="tm-nav-link {{ $navIsHome && $navCategory !== '' ? 'active' : '' }}"
                >
                    <i class="fa-solid fa-shapes"></i>
                    Kategori
                </a>

                <a
                    href="/#produk"
                    class="tm-nav-link {{ $navIsHome && $navHasFilter ? 'active' : '' }}"
                >
                    <i class="fa-solid fa-basket-shopping"></i>
                    Produk Pasar
                </a>

                <a
                    href="/konsultasi"
                    class="tm-nav-link tm-nav-ai {{ request()->is('konsultasi*') ? 'active' : '' }}"
                >
                    <span class="ai-sparkle">✨</span>
                    Tanya AI

                    <span class="ai-badge-chip">Gemini</span>
                </a>

                @auth

                    <!-- Pesanan Saya -->
                    <a
                        href="{{ route('pesanan.saya') }}"
                        class="tm-nav-link {{ request()->is('pesanan-saya', 'riwayat-pesanan') ? 'active' : '' }}"
                        title="Pantau Pesanan Saya"
                    >
                        <i
                            class="fa-solid fa-bag-shopping"
                            style="color:#34754a;"
                        ></i>
                        Pesanan Saya
                    </a>

                    <!-- Pesanan Masuk Seller -->
                    @if(auth()->user()->products()->exists())
                        <a
                            href="{{ route('pesanan.penjual') }}"
                            class="tm-nav-link {{ request()->is('pesanan-masuk*') ? 'active' : '' }}"
                            title="Kelola Pesanan Masuk Toko"
                        >
                            <i
                                class="fa-solid fa-store"
                                style="color:#0284c7;"
                            ></i>
                            Pesanan Masuk
                        </a>
                    @endif

                    <!-- Jual Produk -->
                    <a
                        href="{{ route('products.create') }}"
                        class="tm-nav-link tm-nav-sell {{ request()->is('jual-produk*') ? 'active' : '' }}"
                    >
                        <i class="fa-solid fa-circle-plus"></i>
                        Jual Produk
                    </a>

                @endauth

            </div>

            <!-- Tombol Pencarian -->
            <button
                id="tmSearchOpen"
                type="button"
                class="tm-search-open {{ $navQuery !== '' ? 'has-query' : '' }}"
                aria-controls="tmSearchOverlay"
                aria-expanded="false"
                aria-label="Buka pencarian produk"
                title="Cari produk"
            >
                <i
                    class="fa-solid fa-magnifying-glass"
                    aria-hidden="true"
                ></i>
            </button>

            <!-- Navbar Actions -->
            <div class="tm-nav-actions">

                <!-- Keranjang -->
                <a
                    href="/keranjang"
                    class="tm-nav-cart {{ request()->is('keranjang*') || request()->is('checkout*') ? 'active' : '' }}"
                    title="Keranjang Belanja"
                >
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-label">Keranjang</span>

                    @if($cartTotalQty > 0)
                        <span class="tm-cart-badge">
                            {{ $cartTotalQty > 99 ? '99+' : $cartTotalQty }}
                        </span>
                    @endif
                </a>

                <!-- Chat -->
                @auth
                    @php
                        $unreadChatCount = auth()->user()->unreadMessagesCount();
                    @endphp

                    <a
                        href="{{ route('chat.index') }}"
                        class="tm-nav-cart {{ request()->is('pesan*') || request()->is('chat*') ? 'active' : '' }}"
                        title="Obrolan Pesan"
                        style="border-color:#cbd5e1;"
                    >
                        <i
                            class="fa-solid fa-comments"
                            style="color:#2d6a4f;"
                        ></i>
                        <span class="cart-label">Pesan</span>

                        @if($unreadChatCount > 0)
                            <span
                                class="tm-cart-badge"
                                style="background:#16a34a;"
                            >
                                {{ $unreadChatCount > 99 ? '99+' : $unreadChatCount }}
                            </span>
                        @endif
                    </a>
                @endauth

                <!-- User / Auth -->
                @auth

                    <!-- Admin -->
                    @if(auth()->user()->isAdmin())
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="tm-admin-pill {{ request()->is('admin*') ? 'active' : '' }}"
                            title="Dashboard Administrator"
                        >
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Admin</span>
                        </a>
                    @endif

                    <!-- Account Capsule -->
                    <div class="tm-account-capsule">

                        <div
                            class="tm-user-dropdown"
                            id="tmUserDropdownContainer"
                        >
                            <button
                                type="button"
                                class="tm-user-trigger"
                                id="tmUserTrigger"
                                onclick="toggleUserDropdown(event)"
                                aria-label="Menu Akun Saya"
                                aria-expanded="false"
                            >
                                <div class="tm-avatar-circle">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>

                                <span class="tm-user-name">
                                    {{ Str::limit(auth()->user()->name, 11) }}
                                </span>

                                <i
                                    class="fa-solid fa-chevron-down tm-chevron"
                                    id="tmDropdownChevron"
                                ></i>
                            </button>

                            <!-- Account Dropdown -->
                            <div
                                class="tm-dropdown-menu"
                                id="tmDropdownMenu"
                            >
                                <div class="tm-dropdown-header">

                                    <div class="tm-dropdown-avatar">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>

                                    <div class="tm-dropdown-info">
                                        <strong>
                                            {{ auth()->user()->name }}
                                        </strong>

                                        <small>
                                            {{ auth()->user()->email }}
                                        </small>

                                        @if(auth()->user()->isAdmin())
                                            <span class="tm-role-tag tm-role-admin">
                                                🛡️ Administrator
                                            </span>
                                        @else
                                            <span class="tm-role-tag tm-role-user">
                                                🌱 Petani / Pembeli
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="tm-dropdown-divider"></div>

                                <!-- Admin Dashboard -->
                                @if(auth()->user()->isAdmin())
                                    <a
                                        href="{{ route('admin.dashboard') }}"
                                        class="tm-dropdown-item tm-item-admin"
                                    >
                                        <i class="fa-solid fa-shield-halved"></i>
                                        <span>Dashboard Admin</span>
                                    </a>
                                @endif

                                <!-- Pesanan Saya -->
                                <a
                                    href="{{ route('pesanan.saya') }}"
                                    class="tm-dropdown-item"
                                    style="color:#166534;font-weight:700;"
                                >
                                    <i
                                        class="fa-solid fa-bag-shopping"
                                        style="color:#34754a;"
                                    ></i>
                                    <span>Pesanan Saya (Shopee)</span>
                                </a>

                                <!-- Pesanan Masuk -->
                                @if(auth()->user()->products()->exists())
                                    <a
                                        href="{{ route('pesanan.penjual') }}"
                                        class="tm-dropdown-item"
                                        style="color:#0369a1;font-weight:700;"
                                    >
                                        <i
                                            class="fa-solid fa-store"
                                            style="color:#0284c7;"
                                        ></i>
                                        <span>Pesanan Masuk Toko</span>
                                    </a>
                                @endif

                                <!-- Profil -->
                                <a
                                    href="{{ route('profil') }}"
                                    class="tm-dropdown-item"
                                >
                                    <i class="fa-solid fa-user-gear"></i>
                                    <span>Profil Saya</span>
                                </a>

                                <!-- Produk Saya -->
                                <a
                                    href="{{ route('products.my') }}"
                                    class="tm-dropdown-item"
                                >
                                    <i class="fa-solid fa-box-archive"></i>
                                    <span>Kelola Produk Saya</span>
                                </a>

                                <!-- Chat -->
                                <a
                                    href="{{ route('chat.index') }}"
                                    class="tm-dropdown-item"
                                >
                                    <i class="fa-solid fa-comments"></i>
                                    <span>Obrolan &amp; Pesan</span>

                                    @if(isset($unreadChatCount) && $unreadChatCount > 0)
                                        <span class="tm-dropdown-badge">
                                            {{ $unreadChatCount }}
                                        </span>
                                    @endif
                                </a>

                                <div class="tm-dropdown-divider"></div>

                                <!-- Logout Dropdown -->
                                <form
                                    action="{{ route('logout') }}"
                                    method="POST"
                                    style="margin:0;"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="tm-dropdown-logout-btn"
                                    >
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                        <span>Keluar dari Akun</span>
                                    </button>
                                </form>

                            </div>
                        </div>

                        <div class="tm-capsule-sep"></div>

                        <!-- Quick Logout -->
                        <form
                            action="{{ route('logout') }}"
                            method="POST"
                            style="margin:0;"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="tm-capsule-logout"
                                title="Keluar dari akun"
                            >
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span class="tm-logout-label">Keluar</span>
                            </button>
                        </form>

                    </div>

                @else

                    <!-- Guest Login/Register -->
                    <a
                        href="{{ route('login') }}"
                        class="tm-btn-login"
                    >
                        <i class="fa-solid fa-right-to-bracket"></i>
                        Masuk
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="tm-btn-register"
                    >
                        Daftar Akun
                    </a>

                @endauth
            </div>
        </div>
    </nav>
</header>

<!-- SEARCH POPUP BERADA DI LUAR HEADER -->
<div
    id="tmSearchBackdrop"
    class="tm-search-backdrop"
    hidden
></div>

<section
    id="tmSearchOverlay"
    class="tm-search-overlay"
    role="dialog"
    aria-modal="true"
    aria-label="Pencarian produk TaniMart"
    hidden
>
    <div class="tm-search-head">
        <strong>
            <i
                class="fa-solid fa-magnifying-glass"
                style="color:#34754a;"
            ></i>
            Cari Produk TaniMart
        </strong>

        <button
            id="tmSearchClose"
            class="tm-search-close"
            type="button"
            aria-label="Tutup pencarian"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <form
        id="tmSearchForm"
        class="tm-search-overlay-form"
        action="{{ url('/') }}#produk"
        method="GET"
        data-suggestions-url="{{ route('products.suggestions') }}"
        role="search"
    >
        <i
            class="fa-solid fa-magnifying-glass tm-search-leading"
            aria-hidden="true"
        ></i>

        <input
            id="tmSearchInput"
            class="tm-search-overlay-input"
            type="search"
            name="q"
            placeholder="Ketik nama bibit, pupuk, alat tani..."
            value="{{ $navQuery }}"
            maxlength="100"
            autocomplete="off"
            aria-label="Kata kunci pencarian produk"
            aria-controls="tmSearchResults"
            aria-expanded="false"
            aria-autocomplete="list"
        >

        <!-- Pertahankan filter dari halaman beranda -->
        <input
            type="hidden"
            name="kategori"
            value="{{ $navCategory }}"
        >

        <input
            type="hidden"
            name="stok"
            value="{{ $navStock }}"
        >

        <input
            type="hidden"
            name="sort"
            value="{{ $navSort }}"
        >

        <button
            id="tmSearchClear"
            class="tm-search-clear"
            type="button"
            aria-label="Hapus kata kunci"
            title="Hapus kata kunci"
            {{ $navQuery === '' ? 'hidden' : '' }}
        >
            <i class="fa-solid fa-xmark"></i>
        </button>

        <button type="submit" class="tm-search-submit">
            Cari <i class="fa-solid fa-arrow-right"></i>
        </button>
    </form>

    <p class="tm-search-help">
        Ketik minimal 2 huruf untuk melihat saran produk.
        Tekan Enter untuk mencari semua hasil.
    </p>

    <div
        id="tmSearchResults"
        class="tm-search-suggestions"
        role="listbox"
        aria-label="Saran produk"
        hidden
    ></div>
</section>

<script>
    /*
    |--------------------------------------------------------------------------
    | NAVBAR MOBILE
    |--------------------------------------------------------------------------
    */

    function toggleMobileNav(event) {
        event.stopPropagation();

        const menu = document.getElementById('tmNavbarMenu');

        if (!menu) return;

        const isOpen = menu.classList.toggle('show');

        event.currentTarget.setAttribute(
            'aria-expanded',
            isOpen ? 'true' : 'false'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DROPDOWN AKUN
    |--------------------------------------------------------------------------
    */

    function toggleUserDropdown(event) {
        event.stopPropagation();

        const menu = document.getElementById('tmDropdownMenu');
        const container = document.getElementById('tmUserDropdownContainer');
        const trigger = document.getElementById('tmUserTrigger');

        if (!menu) return;

        const opened = menu.classList.toggle('show');

        if (container) {
            container.classList.toggle('active', opened);
        }

        if (trigger) {
            trigger.setAttribute(
                'aria-expanded',
                opened ? 'true' : 'false'
            );
        }
    }

    document.addEventListener('click', function(event) {
        const container = document.getElementById('tmUserDropdownContainer');
        const dropdown = document.getElementById('tmDropdownMenu');

        if (
            dropdown &&
            dropdown.classList.contains('show') &&
            (!container || !container.contains(event.target))
        ) {
            dropdown.classList.remove('show');

            if (container) {
                container.classList.remove('active');
            }

            const trigger = document.getElementById('tmUserTrigger');

            if (trigger) {
                trigger.setAttribute('aria-expanded', 'false');
            }
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key !== 'Escape') return;

        const dropdown = document.getElementById('tmDropdownMenu');
        const container = document.getElementById('tmUserDropdownContainer');
        const trigger = document.getElementById('tmUserTrigger');

        if (dropdown) dropdown.classList.remove('show');
        if (container) container.classList.remove('active');
        if (trigger) trigger.setAttribute('aria-expanded', 'false');
    });

    /*
    |--------------------------------------------------------------------------
    | SMART SEARCH & AUTOCOMPLETE
    |--------------------------------------------------------------------------
    */

    (function () {
        const openBtn = document.getElementById('tmSearchOpen');
        const closeBtn = document.getElementById('tmSearchClose');
        const backdrop = document.getElementById('tmSearchBackdrop');
        const overlay = document.getElementById('tmSearchOverlay');
        const form = document.getElementById('tmSearchForm');
        const input = document.getElementById('tmSearchInput');
        const clearBtn = document.getElementById('tmSearchClear');
        const results = document.getElementById('tmSearchResults');

        if (
            !openBtn ||
            !closeBtn ||
            !backdrop ||
            !overlay ||
            !form ||
            !input ||
            !results
        ) {
            return;
        }

        let timer = null;
        let controller = null;
        let version = 0;
        let selectedIndex = -1;
        let links = [];

        // Pembuatan HTML aman menggunakan textContent.
        function el(tag, cls, content) {
            const node = document.createElement(tag);

            if (cls) {
                node.className = cls;
            }

            if (content !== undefined) {
                node.textContent = content;
            }

            return node;
        }

        function updateClear() {
            clearBtn.hidden = input.value.trim() === '';
        }

        function hideResults() {
            results.hidden = true;
            results.replaceChildren();
            links = [];
            selectedIndex = -1;

            input.setAttribute('aria-expanded', 'false');
        }

        function cancelLookup() {
            clearTimeout(timer);
            version++;

            if (controller) {
                controller.abort();
            }

            controller = null;
        }

        function closeSearch() {
            cancelLookup();
            hideResults();

            overlay.hidden = true;
            backdrop.hidden = true;

            openBtn.setAttribute('aria-expanded', 'false');
            openBtn.focus();
        }

        function positionSearch() {
            const navbar = document.querySelector('.tm-navbar-wrapper');

            const bottom = navbar
                ? navbar.getBoundingClientRect().bottom
                : 90;

            const top = Math.max(
                10,
                Math.min(window.innerHeight - 140, bottom + 10)
            );

            overlay.style.top = top + 'px';

            overlay.style.maxHeight =
                'calc(100dvh - ' + (top + 12) + 'px)';
        }

        function openSearch() {
            positionSearch();

            backdrop.hidden = false;
            overlay.hidden = false;

            openBtn.setAttribute('aria-expanded', 'true');

            input.focus();
            input.select();

            if (input.value.trim().length >= 2) {
                scheduleLookup();
            }
        }

        // Klik tombol kaca pembesar.
        openBtn.addEventListener('click', openSearch);

        // Tutup popup.
        closeBtn.addEventListener('click', closeSearch);
        backdrop.addEventListener('click', closeSearch);

        window.addEventListener('resize', function() {
            if (!overlay.hidden) {
                positionSearch();
            }
        });

        // URL menuju seluruh hasil pencarian.
        function allResultsUrl() {
            return form.action.split('#')[0] +
                '?' +
                new URLSearchParams(new FormData(form)).toString() +
                '#produk';
        }

        function appendFooter(query) {
            const footer = el(
                'a',
                'tm-search-see-all',
                'Lihat semua hasil untuk "' + query + '" →'
            );

            footer.href = allResultsUrl();

            results.appendChild(footer);
        }

        /*
         * Tampilkan saran dari MySQL.
         */
        function render(items, keyword) {
            results.replaceChildren();

            links = [];
            selectedIndex = -1;

            if (!items.length) {
                results.appendChild(
                    el(
                        'div',
                        'tm-search-empty',
                        'Tidak ada saran yang cocok. Coba lihat semua hasil pencarian.'
                    )
                );
            } else {
                results.appendChild(
                    el(
                        'div',
                        'tm-search-result-label',
                        'SARAN PRODUK'
                    )
                );

                items.forEach(function(p, i) {
                    const url = new URL(p.url, window.location.origin);

                    // Batasi tautan ke domain TaniMart sendiri.
                    if (url.origin !== window.location.origin) {
                        return;
                    }

                    const link = el('a', 'tm-search-result');

                    link.href = url.href;
                    link.id = 'tm-search-option-' + i;

                    link.setAttribute('role', 'option');
                    link.setAttribute('aria-selected', 'false');

                    // Foto atau emoji.
                    const thumb = el('span', 'tm-search-thumb');

                    if (p.image) {
                        const img = document.createElement('img');

                        img.src = p.image;
                        img.alt = '';
                        img.loading = 'lazy';

                        thumb.appendChild(img);
                    } else {
                        thumb.textContent = p.icon || '🌱';
                    }

                    // Data produk.
                    const detail = el('span', 'tm-search-result-text');

                    detail.appendChild(
                        el(
                            'span',
                            'tm-search-result-name',
                            p.name || 'Produk'
                        )
                    );

                    detail.appendChild(
                        el(
                            'span',
                            'tm-search-result-detail',
                            (p.category || 'Produk') +
                                ' · ' +
                                (p.price || '')
                        )
                    );

                    detail.appendChild(
                        el(
                            'span',
                            'tm-search-result-stock' +
                                (Number(p.stock) <= 0 ? ' empty' : ''),
                            Number(p.stock) <= 0
                                ? 'Stok habis'
                                : 'Stok ' + p.stock
                        )
                    );

                    link.appendChild(thumb);
                    link.appendChild(detail);

                    results.appendChild(link);
                    links.push(link);
                });
            }

            appendFooter(keyword);

            results.hidden = false;
            input.setAttribute('aria-expanded', 'true');
        }

        /*
         * Query autocomplete melalui endpoint Laravel.
         */
        async function lookup() {
            const keyword = input.value.trim();

            cancelLookup();

            const id = version;

            if (keyword.length < 2 || overlay.hidden) {
                hideResults();
                return;
            }

            results.replaceChildren(
                el('div', 'tm-search-empty', 'Mencari produk...')
            );

            results.hidden = false;
            input.setAttribute('aria-expanded', 'true');

            const qs = new URLSearchParams();

            qs.set('q', keyword);

            const category = form.querySelector('[name="kategori"]').value;
            const stock = form.querySelector('[name="stok"]').value;

            if (category) {
                qs.set('kategori', category);
            }

            if (stock) {
                qs.set('stok', stock);
            }

            controller = new AbortController();

            try {
                const response = await fetch(
                    form.dataset.suggestionsUrl +
                        '?' +
                        qs.toString(),
                    {
                        signal: controller.signal,
                        headers: {
                            Accept: 'application/json'
                        }
                    }
                );

                if (!response.ok) {
                    throw new Error('Pencarian gagal');
                }

                const data = await response.json();

                // Abaikan hasil pencarian lama.
                if (
                    id !== version ||
                    overlay.hidden ||
                    keyword !== input.value.trim()
                ) {
                    return;
                }

                render(
                    Array.isArray(data.suggestions)
                        ? data.suggestions
                        : [],
                    keyword
                );

            } catch (error) {
                if (
                    error.name !== 'AbortError' &&
                    id === version
                ) {
                    results.replaceChildren(
                        el(
                            'div',
                            'tm-search-empty',
                            'Saran tidak dapat dimuat. Tekan Cari untuk melihat hasil lengkap.'
                        )
                    );

                    appendFooter(keyword);
                    results.hidden = false;
                }
            }
        }

        /*
         * Debounce agar tidak memanggil server
         * setiap kali pengguna mengetik huruf.
         */
        function scheduleLookup() {
            cancelLookup();
            hideResults();

            if (input.value.trim().length >= 2) {
                timer = setTimeout(lookup, 280);
            }
        }

        input.addEventListener('input', function() {
            updateClear();
            scheduleLookup();
        });

        clearBtn.addEventListener('click', function() {
            input.value = '';

            updateClear();
            cancelLookup();
            hideResults();

            input.focus();
        });

        /*
         * Navigasi keyboard pada autocomplete.
         */
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                e.preventDefault();
                closeSearch();
                return;
            }

            if (results.hidden || !links.length) {
                return;
            }

            if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                e.preventDefault();

                selectedIndex = e.key === 'ArrowDown'
                    ? (selectedIndex + 1) % links.length
                    : (
                        selectedIndex <= 0
                            ? links.length - 1
                            : selectedIndex - 1
                    );

                links.forEach(function(link, i) {
                    const active = i === selectedIndex;

                    link.classList.toggle('is-active', active);

                    link.setAttribute(
                        'aria-selected',
                        active ? 'true' : 'false'
                    );
                });

            } else if (e.key === 'Enter' && selectedIndex >= 0) {
                e.preventDefault();

                window.location.assign(
                    links[selectedIndex].href
                );
            }
        });

        // Escape juga bekerja saat fokus berada di luar input.
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !overlay.hidden) {
                e.preventDefault();
                closeSearch();
            }
        });

        form.addEventListener('submit', cancelLookup);

        updateClear();
    })();
</script>
