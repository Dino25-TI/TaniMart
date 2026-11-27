
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Produk | {{ $product->name }} | TaniMart</title>

    <link rel="icon"
          href="{{ asset('favicon.svg') }}"
          type="image/svg+xml">

    <meta name="description"
          content="Edit informasi produk, status, foto dan stok di TaniMart.">

    <meta name="theme-color" content="#34754a">

    <link rel="stylesheet"
          href="{{ asset('css/tanimart.css') }}">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .page-container {
            max-width: 820px;
            margin: 2.5rem auto 4rem;
            padding: 0 1.5rem;
        }

        .form-card {
            background: #fff;
            border-radius: 24px;
            padding: 2.5rem;
            border: 1px solid #e1e7e0;
            box-shadow: 0 15px 40px rgba(36,88,59,.08);
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(
                90deg,
                #34754a,
                #52a36d,
                #8cd19d
            );
        }

        .form-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-header h1 {
            font-size: 1.85rem;
            font-weight: 800;
            color: #24583b;
            margin-bottom: .4rem;
        }

        .form-header p {
            color: #64748b;
            font-size: .94rem;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        .form-group {
            margin-bottom: 1.35rem;
            min-width: 0;
        }

        .form-label {
            display: block;
            font-size: .9rem;
            font-weight: 700;
            color: #26392d;
            margin-bottom: .45rem;
        }

        .form-control,
        .form-select,
        .form-textarea {
            display: block;
            width: 100%;
            min-width: 0;
            box-sizing: border-box;
            padding: .8rem 1rem;
            border: 1.5px solid #dce4db;
            border-radius: 12px;
            font-size: .95rem;
            color: #26392d;
            background: #fbfcfb;
            transition: all .2s ease;
            font-family: inherit;
        }

        .form-control:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #34754a;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(52,117,74,.12);
        }

        .form-textarea {
            resize: vertical;
        }

        .form-note {
            margin-top: 7px;
            color: #64748b;
            font-size: .78rem;
            line-height: 1.6;
        }

        .inline-error {
            display: block;
            color: #b91c1c;
            font-size: .78rem;
            margin-top: 5px;
        }

        /* PILIH EMOJI */
        .icon-picker-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: .35rem;
        }

        .icon-option {
            cursor: pointer;
        }

        .icon-option input {
            position: absolute;
            opacity: 0;
            width: 1px;
            height: 1px;
        }

        .icon-box {
            width: 44px;
            height: 44px;
            border: 2px solid #e1e7e0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            background: #fafbfa;
            transition: all .2s;
        }

        .icon-option input:checked + .icon-box,
        .icon-option input:focus-visible + .icon-box {
            border-color: #34754a;
            background: #e7efe4;
            transform: scale(1.07);
            box-shadow: 0 4px 10px rgba(52,117,74,.15);
        }

        /* PANEL STOK BARU */
        .stock-panel {
            background: #f6faf7;
            border: 1px solid #d4e8d9;
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 1.5rem;
        }

        .stock-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 12px;
        }

        .stock-heading h2 {
            color: #24583b;
            font-size: 1.1rem;
            margin: 0;
        }

        .stock-current {
            color: #166534;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: .81rem;
            font-weight: 800;
        }

        .stock-modes {
            display: grid;
            grid-template-columns: repeat(
                3,
                minmax(0,1fr)
            );
            gap: 10px;
            margin: 15px 0;
        }

        .stock-choice {
            display: block;
            cursor: pointer;
        }

        .stock-choice input {
            position: absolute;
            opacity: 0;
        }

        .stock-choice-body {
            display: flex;
            align-items: flex-start;
            gap: 7px;
            height: 100%;
            padding: 12px 10px;
            border: 1.5px solid #dce4db;
            border-radius: 12px;
            background: #fff;
            box-sizing: border-box;
            font-size: .83rem;
            font-weight: 700;
            color: #475569;
        }

        .stock-choice input:checked + .stock-choice-body,
        .stock-choice input:focus-visible + .stock-choice-body {
            border-color: #34754a;
            background: #e7f5e9;
            color: #166534;
        }

        .stock-mode-fields[hidden] {
            display: none !important;
        }

        .stock-preview {
            margin-top: 13px;
            border: 1px dashed #8cc69e;
            background: #fff;
            color: #166534;
            padding: 12px 14px;
            border-radius: 12px;
            font-size: .86rem;
            font-weight: 700;
        }

        /* PENJELASAN STATUS */
        .status-hint {
            margin-top: 9px;
            padding: 11px 12px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 11px;
            font-size: .8rem;
            color: #1d4ed8;
            line-height: 1.6;
        }

        /* PRATINJAU FOTO */
        .photo-preview {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .photo-preview img {
            width: 82px;
            height: 82px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #dce4db;
        }

        .photo-preview small {
            color: #64748b;
        }

        /* AKSI FORM */
        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f1f5f9;
        }

        .btn-cancel {
            padding: .8rem 1.5rem;
            color: #64748b;
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .btn-publish {
            padding: .85rem 2rem;
            background: #34754a;
            color: #fff;
            border: 0;
            border-radius: 12px;
            font-size: .98rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(52,117,74,.25);
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-publish:hover {
            background: #24583b;
            transform: translateY(-2px);
        }

        .alert-error {
            background: #fdf2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: .85rem 1rem;
            border-radius: 12px;
            font-size: .9rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 640px) {
            .form-card {
                padding: 1.5rem 1.1rem;
            }

            .page-container {
                padding: 0 1rem;
            }

            .form-grid-2 {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .stock-modes {
                grid-template-columns: 1fr;
            }

            .stock-choice-body {
                height: auto;
            }

            .form-header h1 {
                font-size: 1.45rem;
            }
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    @php
        $stockNow = max(0, (int) $product->stock);

        $currentMode = old('stock_mode', 'keep');

        $currentUnit = old('unit', $product->unit);

        $unitOptions = [
            'pack',
            'kg',
            'gram',
            'ikat',
            'karung',
            'pcs',
            'botol'
        ];

        if (
            $currentUnit &&
            !in_array($currentUnit, $unitOptions, true)
        ) {
            $unitOptions[] = $currentUnit;
        }

        $categoryOptions = $categories;

        $currentCategory = old(
            'category',
            $product->category
        );

        if (
            $currentCategory &&
            !in_array($currentCategory, $categoryOptions, true)
        ) {
            $categoryOptions[] = $currentCategory;
        }

        $currentIcon = old(
            'icon',
            $product->icon ?: '🌱'
        );

        $iconOptions = $suggestedIcons;

        if (
            $currentIcon &&
            !in_array($currentIcon, $iconOptions, true)
        ) {
            $iconOptions[] = $currentIcon;
        }
    @endphp

    <main class="page-container">

        <div class="form-card">

            <div class="form-header">
                <h1>Edit Produk: {{ $product->name }}</h1>

                <p>
                    Perbarui harga, informasi produk, foto,
                    dan tambah stok dengan aman.
                </p>
            </div>

            {{-- NOTIFIKASI ERROR --}}
            @if($errors->any())

                <div class="alert-error" role="alert">
                    <i class="fa-solid fa-circle-xmark"></i>
                    {{ $errors->first() }}
                </div>

            @endif

            {{-- FORM EDIT PRODUK --}}
            <form
                action="{{ route('products.update', $product->id) }}"
                method="POST"
                enctype="multipart/form-data"
                id="editProductForm"
            >
                @csrf
                @method('PUT')

                {{-- NAMA PRODUK --}}
                <div class="form-group">

                    <label class="form-label" for="name">
                        Nama Produk Pertanian *
                    </label>

                    <input
                        class="form-control"
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $product->name) }}"
                        maxlength="150"
                        required
                    >

                    @error('name')
                        <small class="inline-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                {{-- KATEGORI DAN LOKASI --}}
                <div class="form-grid-2">

                    <div class="form-group">

                        <label class="form-label" for="category">
                            Kategori Produk *
                        </label>

                        <select
                            name="category"
                            id="category"
                            class="form-select"
                            required
                        >
                            @foreach($categoryOptions as $cat)

                                <option
                                    value="{{ $cat }}"
                                    @selected($currentCategory === $cat)
                                >
                                    {{ $cat }}
                                </option>

                            @endforeach
                        </select>

                        @error('category')
                            <small class="inline-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    <div class="form-group">

                        <label class="form-label" for="location">
                            Kota / Asal Lokasi *
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="location"
                            id="location"
                            value="{{ old('location', $product->location) }}"
                            maxlength="100"
                            required
                        >

                        @error('location')
                            <small class="inline-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

                {{-- HARGA DAN SATUAN --}}
                <div class="form-grid-2">

                    <div class="form-group">

                        <label class="form-label" for="price">
                            Harga Jual (Rp) *
                        </label>

                        <input
                            class="form-control"
                            type="number"
                            name="price"
                            id="price"
                            min="500"
                            step="1"
                            value="{{ old('price', $product->price) }}"
                            required
                        >

                        @error('price')
                            <small class="inline-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    <div class="form-group">

                        <label class="form-label" for="unit">
                            Satuan Produk *
                        </label>

                        <select
                            name="unit"
                            id="unit"
                            class="form-select"
                            required
                        >
                            @foreach($unitOptions as $unit)

                                <option
                                    value="{{ $unit }}"
                                    @selected($currentUnit === $unit)
                                >
                                    {{ $unit }}
                                </option>

                            @endforeach
                        </select>

                        <p class="form-note">
                            Contoh: pack, kg, botol, pcs.
                        </p>

                        @error('unit')
                            <small class="inline-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

                {{-- ======================================
                     FITUR BARU: PENGELOLAAN STOK
                     ====================================== --}}

                <section
                    class="stock-panel"
                    aria-labelledby="stockSectionTitle"
                >

                    <div class="stock-heading">

                        <h2 id="stockSectionTitle">
                            <i class="fa-solid fa-boxes-stacked"></i>
                            Pengelolaan Stok
                        </h2>

                        <span class="stock-current">
                            Stok saat ini:
                            {{ $stockNow }}
                            {{ $product->unit }}
                        </span>

                    </div>

                    <p class="form-note" style="margin:0;">
                        Restock akan
                        <strong>
                            ditambahkan ke stok terbaru di MySQL
                        </strong>,
                        bukan mengganti stok lama.

                        Jika hanya mengedit harga atau foto,
                        pilih "Tidak mengubah stok".
                    </p>

                    {{-- PILIHAN CARA MENGUBAH STOK --}}
                    <div
                        class="stock-modes"
                        role="radiogroup"
                        aria-label="Pilih cara mengubah stok"
                    >

                        <label class="stock-choice">

                            <input
                                type="radio"
                                name="stock_mode"
                                value="keep"
                                @checked($currentMode === 'keep')
                            >

                            <span class="stock-choice-body">
                                <i class="fa-solid fa-check"></i>
                                Tidak mengubah stok
                            </span>

                        </label>

                        <label class="stock-choice">

                            <input
                                type="radio"
                                name="stock_mode"
                                value="add"
                                @checked($currentMode === 'add')
                            >

                            <span class="stock-choice-body">
                                <i class="fa-solid fa-plus"></i>
                                Tambah stok (Restock)
                            </span>

                        </label>

                        <label class="stock-choice">

                            <input
                                type="radio"
                                name="stock_mode"
                                value="set"
                                @checked($currentMode === 'set')
                            >

                            <span class="stock-choice-body">
                                <i class="fa-solid fa-pen"></i>
                                Koreksi stok akhir
                            </span>

                        </label>

                    </div>

                    {{-- RESTOCK: TAMBAHKAN KE STOK TERBARU --}}
                    <div
                        class="stock-mode-fields"
                        id="stockAddPanel"
                        @if($currentMode !== 'add') hidden @endif
                    >

                        <div
                            class="form-group"
                            style="margin-bottom:0;"
                        >

                            <label
                                class="form-label"
                                for="stock_add"
                            >
                                Jumlah Barang Masuk *
                            </label>

                            <input
                                class="form-control"
                                type="number"
                                name="stock_add"
                                id="stock_add"
                                value="{{ old('stock_add') }}"
                                min="1"
                                max="1000000"
                                step="1"
                                placeholder="Contoh: 20"
                                @if($currentMode !== 'add') disabled @endif
                            >

                            <p class="form-note">
                                Contoh stok 5 + restock 20 = 25.
                                Stok transaksi terbaru tetap
                                dihitung di server.
                            </p>

                            @error('stock_add')
                                <small class="inline-error">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>
                    </div>

                    {{-- KOREKSI STOK AKHIR --}}
                    <div
                        class="stock-mode-fields"
                        id="stockSetPanel"
                        @if($currentMode !== 'set') hidden @endif
                    >

                        <div
                            class="form-group"
                            style="margin-bottom:0;"
                        >

                            <label
                                class="form-label"
                                for="stock"
                            >
                                Jumlah Stok Akhir *
                            </label>

                            <input
                                class="form-control"
                                type="number"
                                name="stock"
                                id="stock"
                                value="{{ old('stock', $stockNow) }}"
                                min="0"
                                max="2147483647"
                                step="1"
                                @if($currentMode !== 'set') disabled @endif
                            >

                            <p class="form-note">
                                Gunakan untuk koreksi hasil
                                stok opname.

                                Nilai ini menggantikan stok
                                saat ini, bukan menambah.
                            </p>

                            @error('stock')
                                <small class="inline-error">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>
                    </div>

                    {{-- PRATINJAU PERUBAHAN STOK --}}
                    <div
                        class="stock-preview"
                        id="stockPreview"
                        aria-live="polite"
                    >
                        Stok tidak diubah:
                        {{ $stockNow }}
                        {{ $product->unit }}
                    </div>

                </section>

                {{-- ======================================
                     STATUS PRODUK DAN EMOJI
                     ====================================== --}}

                <div class="form-grid-2">

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="status"
                        >
                            Tampilkan Produk di Pasar? *
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="form-select"
                            required
                        >

                            <option
                                value="tersedia"
                                @selected(
                                    old('status', $product->status)
                                    === 'tersedia'
                                )
                            >
                                Aktif — Tampilkan di Pasar
                            </option>

                            <option
                                value="habis"
                                @selected(
                                    old('status', $product->status)
                                    === 'habis'
                                )
                            >
                                Nonaktif — Sembunyikan dari Pasar
                            </option>

                        </select>

                        <div
                            class="status-hint"
                            id="statusHint"
                            aria-live="polite"
                        >
                            Produk aktif akan tampil di pasar.
                            Jika stok 0, tombol beli tetap dinonaktifkan.
                        </div>

                        @error('status')
                            <small class="inline-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    {{-- IKON EMOJI --}}
                    <div class="form-group">

                        <span class="form-label">
                            Ikon Emoji Produk
                        </span>

                        <div class="icon-picker-grid">

                            @foreach($iconOptions as $icon)

                                <label class="icon-option">

                                    <input
                                        type="radio"
                                        name="icon"
                                        value="{{ $icon }}"
                                        @checked($currentIcon === $icon)
                                    >

                                    <span class="icon-box">
                                        {{ $icon }}
                                    </span>

                                </label>

                            @endforeach

                        </div>

                        <p class="form-note">
                            Ikon dipakai apabila produk
                            tidak menggunakan foto.
                        </p>

                        @error('icon')
                            <small class="inline-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

                {{-- ======================================
                     FOTO PRODUK
                     ====================================== --}}

                <div class="form-group">

                    <label
                        class="form-label"
                        for="image"
                    >
                        Ganti Foto Produk (Opsional)
                    </label>

                    <div class="photo-preview">

                        @if($product->image)

                            <img
                                src="{{ asset($product->image) }}"
                                alt="Foto produk saat ini"
                                id="productPhotoPreview"
                            >

                        @else

                            <img
                                src=""
                                alt="Pratinjau foto baru"
                                id="productPhotoPreview"
                                hidden
                            >

                        @endif

                        <small>
                            Foto lama tetap digunakan
                            jika tidak memilih gambar baru.

                            JPG, PNG, WebP; maksimal 3MB.
                        </small>

                    </div>

                    <input
                        class="form-control"
                        type="file"
                        name="image"
                        id="image"
                        accept="image/jpeg,image/png,image/webp"
                    >

                    @error('image')
                        <small class="inline-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                {{-- ======================================
                     DESKRIPSI PRODUK
                     ====================================== --}}

                <div class="form-group">

                    <label
                        class="form-label"
                        for="description"
                    >
                        Deskripsi Produk
                    </label>

                    <textarea
                        class="form-textarea"
                        name="description"
                        id="description"
                        rows="4"
                        maxlength="2000"
                        placeholder="Jelaskan kualitas, kegunaan, dan cara pakai produk..."
                    >{{ old('description', $product->description) }}</textarea>

                    @error('description')
                        <small class="inline-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                {{-- ======================================
                     TOMBOL FORM
                     ====================================== --}}

                <div class="form-actions">

                    <a
                        href="{{ route('products.my') }}"
                        class="btn-cancel"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn-publish"
                    >
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </form>
        </div>

    </main>

    @include('partials.footer')

    <script>
        (function () {

            const form = document.getElementById(
                'editProductForm'
            );

            if (!form) return;

            const stockNow = @json($stockNow);

            const modeOptions = form.querySelectorAll(
                'input[name="stock_mode"]'
            );

            const addPanel = document.getElementById(
                'stockAddPanel'
            );

            const setPanel = document.getElementById(
                'stockSetPanel'
            );

            const addInput = document.getElementById(
                'stock_add'
            );

            const setInput = document.getElementById(
                'stock'
            );

            const unitSelect = document.getElementById(
                'unit'
            );

            const statusSelect = document.getElementById(
                'status'
            );

            const preview = document.getElementById(
                'stockPreview'
            );

            const statusHint = document.getElementById(
                'statusHint'
            );

            function getMode() {
                return form.querySelector(
                    'input[name="stock_mode"]:checked'
                )?.value || 'keep';
            }

            /*
             * Mengganti tampilan input berdasarkan:
             * keep = tidak mengubah stok
             * add  = tambah stok
             * set  = koreksi stok akhir
             */
            function updateStockUi() {

                const mode = getMode();

                const adding = mode === 'add';
                const setting = mode === 'set';
                const unit = unitSelect.value;

                addPanel.hidden = !adding;
                setPanel.hidden = !setting;

                addInput.disabled = !adding;
                setInput.disabled = !setting;

                addInput.required = adding;
                setInput.required = setting;

                let text;

                if (adding) {

                    const qty = Number(addInput.value);

                    text =
                        addInput.value !== '' &&
                        Number.isInteger(qty) &&
                        qty > 0

                        ? 'Perkiraan setelah restock: ' +
                          (stockNow + qty).toLocaleString('id-ID') +
                          ' ' + unit

                        : 'Isi jumlah restock untuk melihat perkiraan stok akhir.';

                } else if (setting) {

                    const target = Number(setInput.value);

                    text =
                        setInput.value !== '' &&
                        Number.isInteger(target) &&
                        target >= 0

                        ? 'Stok akhir yang ditetapkan: ' +
                          target.toLocaleString('id-ID') +
                          ' ' + unit

                        : 'Isi jumlah stok akhir yang benar.';

                } else {

                    text =
                        'Stok tidak diubah: ' +
                        stockNow.toLocaleString('id-ID') +
                        ' ' + unit;
                }

                preview.textContent = text;

                /*
                 * Penjelasan status:
                 * aktif/nonaktif terpisah dari stok.
                 */
                statusHint.textContent =
                    statusSelect.value === 'tersedia'

                    ? 'Produk aktif ditampilkan di Pasar. Jika stok 0, pembeli tetap tidak bisa checkout.'

                    : 'Produk Nonaktif disembunyikan dari Pasar walaupun stoknya masih tersedia.';
            }

            modeOptions.forEach(function(el) {
                el.addEventListener(
                    'change',
                    updateStockUi
                );
            });

            [
                addInput,
                setInput,
                unitSelect,
                statusSelect
            ].forEach(function(el) {

                el.addEventListener(
                    'input',
                    updateStockUi
                );

                el.addEventListener(
                    'change',
                    updateStockUi
                );

            });

            updateStockUi();

            /*
             * PRATINJAU FOTO PRODUK BARU
             *
             * Foto baru hanya dipratinjau di browser.
             * Upload baru dilakukan setelah Simpan.
             */
            const imageInput = document.getElementById(
                'image'
            );

            const imagePreview = document.getElementById(
                'productPhotoPreview'
            );

            let objectUrl = null;

            imageInput.addEventListener('change', function () {

                if (objectUrl) {
                    URL.revokeObjectURL(objectUrl);
                }

                const file =
                    imageInput.files &&
                    imageInput.files[0];

                if (!file) return;

                objectUrl = URL.createObjectURL(file);

                imagePreview.src = objectUrl;
                imagePreview.hidden = false;

            });

        })();
    </script>

</body>
</html>
