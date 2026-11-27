<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Keranjang Belanja | TaniMart</title>

    <link rel="icon"
          href="{{ asset('favicon.svg') }}"
          type="image/svg+xml">

    <meta name="description"
          content="Keranjang belanja produk pertanian di TaniMart.">

    <meta name="theme-color" content="#34754a">

    <link rel="stylesheet"
          href="{{ asset('css/tanimart.css') }}">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .tm-selection-panel {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            padding: 16px;
            margin-bottom: 16px;
            background: #f1f8f2;
            border: 1px solid #d4e8d8;
            border-radius: 12px;
        }

        .tm-selection-label {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            cursor: pointer;
            font-weight: 700;
            color: #24583b;
        }

        .tm-cart-checkbox {
            width: 20px;
            height: 20px;
            min-width: 20px;
            accent-color: #24583b;
            cursor: pointer;
        }

        .tm-cart-checkbox:disabled {
            cursor: not-allowed;
            opacity: .45;
        }

        .tm-select-count {
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
        }

        .tm-cart-item {
            position: relative;
        }

        .tm-cart-item.is-unavailable {
            background: #fafafa;
        }

        .tm-stock-info {
            font-size: 12px;
            font-weight: 600;
            margin: 6px 0;
        }

        .tm-stock-info.available {
            color: #15803d;
        }

        .tm-stock-info.unavailable {
            color: #b42318;
        }

        .tm-summary-note {
            font-size: 12px;
            color: #64748b;
            margin-top: 5px;
        }

        .tm-checkout-actions {
            display: flex;
            gap: 1rem;
            margin-top: 20px;
            flex-wrap: wrap;
            align-items: center;
        }

        .tm-checkout-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #24583b;
            color: white;
            padding: 14px 24px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .tm-checkout-btn:hover:not(:disabled) {
            background: #183d29;
            transform: translateY(-1px);
        }

        .tm-checkout-btn:disabled {
            background: #cbd5e1;
            color: #64748b;
            cursor: not-allowed;
            transform: none;
        }

        .tm-cart-warning {
            padding: 11px 14px;
            border-radius: 9px;
            background: #fff5eb;
            border: 1px solid #fed7aa;
            color: #9a3412;
            font-size: 13px;
            margin: 12px 0;
        }

        .tm-cart-alert {
            padding: 13px 16px;
            background: #fff1f0;
            border: 1px solid #fecdca;
            border-radius: 10px;
            color: #b42318;
            margin-bottom: 18px;
        }

        .tm-total-value {
            color: #24583b;
        }

        @media (max-width: 680px) {
            .tm-selection-panel {
                align-items: flex-start;
            }

            .tm-cart-item {
                flex-wrap: wrap;
            }

            .tm-checkout-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .tm-checkout-btn,
            .tm-checkout-actions > a {
                width: 100%;
                text-align: center;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    <main class="section">

        {{-- NOTIFIKASI ERROR --}}
        @if(session('error'))
            <div class="site-toast site-toast-error"
                 id="cartErrorToast"
                 role="alert">
                <span>⚠️ {{ session('error') }}</span>

                <span
                    style="cursor:pointer; opacity:.7; margin-left:8px;"
                    onclick="this.parentElement.remove()">
                    ✕
                </span>
            </div>
        @endif

        {{-- NOTIFIKASI SUKSES --}}
        @if(session('success'))
            <div class="site-toast site-toast-success"
                 id="cartSuccessToast"
                 role="status">
                <span>✅ {{ session('success') }}</span>

                <span
                    style="cursor:pointer; opacity:.7; margin-left:8px;"
                    onclick="this.parentElement.remove()">
                    ✕
                </span>
            </div>
        @endif

        {{-- ERROR VALIDASI LARAVEL --}}
        @if($errors->any())
            <div class="tm-cart-alert" role="alert">
                <strong>
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Periksa kembali keranjangmu:
                </strong>

                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <span class="product-eyebrow">
            BELANJA LEBIH MUDAH
        </span>

        <h1>Keranjang Belanja</h1>

        <p class="section-description">
            Pilih produk yang ingin kamu checkout.
            Produk lainnya tetap tersimpan dalam keranjang.
        </p>

        @if(count($keranjang) > 0)

            @php
                $selectableCount = 0;
                $initialTotal = 0;

                foreach ($keranjang as $item) {
                    $stok = array_key_exists('stok', $item)
                        ? (int) $item['stok']
                        : null;

                    $jumlah = (int) $item['jumlah'];

                    $bisaDipilih = (bool) (
                        $item['bisa_dibeli'] ?? true
                    );

                    if (
                        $stok !== null &&
                        ($stok <= 0 || $jumlah > $stok)
                    ) {
                        $bisaDipilih = false;
                    }

                    if ($bisaDipilih) {
                        $selectableCount++;
                        $initialTotal +=
                            (int) $item['harga'] * $jumlah;
                    }
                }
            @endphp

            <div class="cart-list">

                {{-- PILIH SEMUA --}}
                <div class="tm-selection-panel">

                    <label class="tm-selection-label">
                        <input
                            type="checkbox"
                            id="tmSelectAll"
                            class="tm-cart-checkbox"
                            @checked($selectableCount > 0)
                            @disabled($selectableCount === 0)
                        >

                        <span>
                            <i class="fa-solid fa-check-double"></i>
                            Pilih Semua Produk
                        </span>
                    </label>

                    <span class="tm-select-count"
                          id="tmSelectedCount">
                        {{ $selectableCount }}
                        dari {{ count($keranjang) }} produk dipilih
                    </span>
                </div>

                {{-- DAFTAR PRODUK --}}
                @foreach($keranjang as $id => $item)

                    @php
                        $jumlah = (int) $item['jumlah'];
                        $harga = (int) $item['harga'];

                        $stok = array_key_exists('stok', $item)
                            ? (int) $item['stok']
                            : null;

                        $bisaDipilih = (bool) (
                            $item['bisa_dibeli'] ?? true
                        );

                        if (
                            $stok !== null &&
                            ($stok <= 0 || $jumlah > $stok)
                        ) {
                            $bisaDipilih = false;
                        }

                        $subtotal = $harga * $jumlah;
                    @endphp

                    <div
                        class="cart-item tm-cart-item {{ !$bisaDipilih ? 'is-unavailable' : '' }}"
                        data-cart-product="{{ $id }}"
                        data-price="{{ $harga }}"
                        data-quantity="{{ $jumlah }}"
                    >

                        {{-- CHECKBOX PRODUK --}}
                        <input
                            type="checkbox"
                            class="tm-cart-checkbox tm-item-checkbox"
                            id="tmItem{{ $id }}"
                            name="selected_items[]"
                            value="{{ $id }}"
                            form="checkoutSelectionForm"
                            aria-label="Pilih {{ $item['nama'] }}"
                            @checked($bisaDipilih)
                            @disabled(!$bisaDipilih)
                        >

                        {{-- IKON PRODUK --}}
                        <div class="cart-item-icon">
                            {{ $item['icon'] ?? '🌱' }}
                        </div>

                        {{-- INFORMASI PRODUK --}}
                        <div class="cart-item-info">

                            <label for="tmItem{{ $id }}"
                                   style="cursor:pointer;">
                                <h3>{{ $item['nama'] }}</h3>
                            </label>

                            <p>
                                Rp{{ number_format($harga, 0, ',', '.') }}
                                / {{ $item['satuan'] ?? 'pcs' }}
                            </p>

                            <p style="
                                color:#24583b;
                                font-size:.85rem;
                                margin:.2rem 0;
                                font-weight:600;
                            ">
                                <i class="fa-solid fa-store"></i>

                                Penjual:
                                {{ $item['penjual'] ?? 'Mitra Tani' }}
                            </p>

                            {{-- STATUS STOK --}}
                            @if($stok !== null)

                                @if($stok <= 0)
                                    <p class="tm-stock-info unavailable">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                        Stok Habis
                                    </p>

                                @elseif($jumlah > $stok)
                                    <p class="tm-stock-info unavailable">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        Jumlah melebihi stok tersedia
                                        ({{ $stok }})
                                    </p>

                                @elseif($stok <= 10)
                                    <p class="tm-stock-info available">
                                        <i class="fa-solid fa-box"></i>
                                        Stok Terbatas:
                                        {{ $stok }}
                                    </p>

                                @else
                                    <p class="tm-stock-info available">
                                        <i class="fa-solid fa-circle-check"></i>
                                        Stok tersedia:
                                        {{ $stok }}
                                    </p>
                                @endif

                            @elseif(!$bisaDipilih)

                                <p class="tm-stock-info unavailable">
                                    Produk tidak tersedia
                                </p>

                            @endif

                            {{-- TOMBOL JUMLAH --}}
                            <div class="quantity-controls">

                                <form
                                    action="{{ url('/keranjang/ubah/' . $id) }}"
                                    method="POST">
                                    @csrf

                                    <input type="hidden"
                                           name="aksi"
                                           value="kurang">

                                    <button type="submit"
                                            class="quantity-btn"
                                            aria-label="Kurangi jumlah">
                                        −
                                    </button>
                                </form>

                                <span class="quantity-number">
                                    {{ $jumlah }}
                                </span>

                                <form
                                    action="{{ url('/keranjang/ubah/' . $id) }}"
                                    method="POST">
                                    @csrf

                                    <input type="hidden"
                                           name="aksi"
                                           value="tambah">

                                    <button
                                        type="submit"
                                        class="quantity-btn"
                                        aria-label="Tambah jumlah"
                                        @disabled(
                                            !$bisaDipilih ||
                                            ($stok !== null && $jumlah >= $stok)
                                        )>
                                        +
                                    </button>
                                </form>

                            </div>

                            @if(!$bisaDipilih)
                                <div class="tm-cart-warning">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    Produk ini tidak bisa dipilih untuk
                                    checkout saat ini.
                                </div>
                            @endif

                        </div>

                        {{-- SUBTOTAL PRODUK --}}
                        <p class="cart-subtotal">
                            Rp{{ number_format($subtotal, 0, ',', '.') }}
                        </p>

                        {{-- HAPUS PRODUK --}}
                        <form
                            action="{{ url('/keranjang/hapus/' . $id) }}"
                            method="POST">
                            @csrf

                            <button
                                type="submit"
                                class="remove-cart"
                                title="Hapus dari keranjang">
                                Hapus
                            </button>
                        </form>

                    </div>

                @endforeach

                {{-- TOTAL PRODUK TERPILIH --}}
                <div class="cart-total">

                    <div>
                        <span>Total Produk Terpilih</span>

                        <p class="tm-summary-note"
                           id="tmSummaryCount">
                            {{ $selectableCount }}
                            produk akan di-checkout
                        </p>
                    </div>

                    <strong
                        class="tm-total-value"
                        id="tmSelectedTotal">
                        Rp{{ number_format($initialTotal, 0, ',', '.') }}
                    </strong>
                </div>

                {{-- TOMBOL CHECKOUT --}}
                <div class="tm-checkout-actions">

                    <a href="{{ url('/#produk') }}"
                       class="btn btn-secondary"
                       style="font-weight:700;">
                        ← Lanjutkan Belanja
                    </a>

                    {{--
                        Checkbox produk menggunakan atribut
                        form="checkoutSelectionForm".

                        Jadi formulir jumlah dan hapus tetap terpisah.
                        Tidak ada nested form.
                    --}}
                    <form
                        id="checkoutSelectionForm"
                        action="{{ route('checkout') }}"
                        method="GET"
                        style="margin:0;">

                        <input
                            type="hidden"
                            name="selection_submitted"
                            value="1"
                        >

                        <button
                            type="submit"
                            id="tmCheckoutButton"
                            class="tm-checkout-btn"
                            @disabled($selectableCount === 0)
                        >
                            <i class="fa-solid fa-cart-shopping"></i>
                            Checkout
                            (<span id="tmCheckoutCount">{{ $selectableCount }}</span>)
                            →
                        </button>
                    </form>
                </div>

            </div>

        @else

            {{-- KERANJANG KOSONG --}}
            <div class="cart-empty">

                <div class="cart-empty-icon">🛒</div>

                <h2>Keranjangmu masih kosong</h2>

                <p>
                    Yuk, temukan bibit, pupuk, atau
                    pot tanaman yang cocok untukmu.
                </p>

                <a href="/#produk"
                   class="btn btn-primary">
                    Mulai Belanja Sekarang →
                </a>

            </div>

        @endif

    </main>

    @include('partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const allCheckbox = document.getElementById('tmSelectAll');

            const checkboxes = Array.from(
                document.querySelectorAll('.tm-item-checkbox')
            );

            const activeCheckboxes = checkboxes.filter(
                checkbox => !checkbox.disabled
            );

            const selectedCount = document.getElementById(
                'tmSelectedCount'
            );

            const summaryCount = document.getElementById(
                'tmSummaryCount'
            );

            const selectedTotal = document.getElementById(
                'tmSelectedTotal'
            );

            const checkoutButton = document.getElementById(
                'tmCheckoutButton'
            );

            const checkoutCount = document.getElementById(
                'tmCheckoutCount'
            );

            const checkoutForm = document.getElementById(
                'checkoutSelectionForm'
            );

            if (!checkoutForm) return;

            // Simpan pilihan per akun di tab browser.
            // Ini hanya preferensi antarmuka.
            // Checkout tetap divalidasi oleh Laravel.
            const storageKey =
                'tanimart_cart_selection_{{ auth()->id() }}';

            try {
                const stored = sessionStorage.getItem(storageKey);

                if (stored !== null) {
                    const ids = JSON.parse(stored);

                    if (Array.isArray(ids)) {
                        const savedIds = new Set(
                            ids.map(String)
                        );

                        activeCheckboxes.forEach(checkbox => {
                            checkbox.checked = savedIds.has(
                                checkbox.value
                            );
                        });
                    }
                }
            } catch (error) {
                // Jika storage tidak tersedia,
                // checkbox tetap berfungsi normal.
            }

            function saveSelection() {
                try {
                    const ids = activeCheckboxes
                        .filter(checkbox => checkbox.checked)
                        .map(checkbox => checkbox.value);

                    sessionStorage.setItem(
                        storageKey,
                        JSON.stringify(ids)
                    );
                } catch (error) {
                    // Tidak mengganggu proses checkout.
                }
            }

            function updateSummary() {

                const checked = activeCheckboxes.filter(
                    checkbox => checkbox.checked
                );

                let total = 0;

                checked.forEach(checkbox => {

                    const row = checkbox.closest(
                        '[data-cart-product]'
                    );

                    if (!row) return;

                    const price = Number(
                        row.dataset.price || 0
                    );

                    const quantity = Number(
                        row.dataset.quantity || 0
                    );

                    total += price * quantity;
                });

                const formattedTotal = new Intl.NumberFormat(
                    'id-ID',
                    {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }
                ).format(total);

                if (selectedTotal) {
                    selectedTotal.textContent = formattedTotal;
                }

                if (selectedCount) {
                    selectedCount.textContent =
                        checked.length + ' dari ' +
                        checkboxes.length + ' produk dipilih';
                }

                if (summaryCount) {
                    summaryCount.textContent =
                        checked.length +
                        ' produk akan di-checkout';
                }

                if (checkoutCount) {
                    checkoutCount.textContent = checked.length;
                }

                if (checkoutButton) {
                    checkoutButton.disabled =
                        checked.length === 0;
                }

                if (allCheckbox) {
                    allCheckbox.checked =
                        activeCheckboxes.length > 0 &&
                        checked.length === activeCheckboxes.length;

                    allCheckbox.indeterminate =
                        checked.length > 0 &&
                        checked.length < activeCheckboxes.length;
                }
            }

            // Checkbox pilih semua
            if (allCheckbox) {

                allCheckbox.addEventListener(
                    'change',
                    function () {

                        activeCheckboxes.forEach(checkbox => {
                            checkbox.checked = allCheckbox.checked;
                        });

                        saveSelection();
                        updateSummary();
                    }
                );
            }

            // Checkbox masing-masing produk
            checkboxes.forEach(checkbox => {

                checkbox.addEventListener(
                    'change',
                    function () {

                        saveSelection();
                        updateSummary();
                    }
                );
            });

            // Tolak checkout tanpa produk
            checkoutForm.addEventListener(
                'submit',
                function (event) {

                    const hasSelected = activeCheckboxes.some(
                        checkbox => checkbox.checked
                    );

                    if (!hasSelected) {
                        event.preventDefault();

                        alert(
                            'Pilih minimal satu produk sebelum checkout.'
                        );

                        return;
                    }

                    saveSelection();
                }
            );

            // Inisialisasi total
            updateSummary();

            // Hapus notifikasi otomatis
            setTimeout(function () {

                const errorToast = document.getElementById(
                    'cartErrorToast'
                );

                const successToast = document.getElementById(
                    'cartSuccessToast'
                );

                if (errorToast) errorToast.remove();
                if (successToast) successToast.remove();

            }, 5000);
        });
    </script>

</body>
</html>
