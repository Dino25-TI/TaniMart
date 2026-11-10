<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk | {{ $product->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .page-container {
            max-width: 800px;
            margin: 2.5rem auto 4rem;
            padding: 0 1.5rem;
        }

        .form-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 2.5rem;
            border: 1px solid #e1e7e0;
            box-shadow: 0 15px 40px rgba(36, 88, 59, 0.08);
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
            background: linear-gradient(90deg, #34754a, #52a36d, #8cd19d);
        }

        .form-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-header h1 {
            font-size: 1.85rem;
            font-weight: 800;
            color: #24583b;
            margin-bottom: 0.4rem;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        @media (max-width: 640px) {
            .form-grid-2 {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            margin-bottom: 1.35rem;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 700;
            color: #26392d;
            margin-bottom: 0.45rem;
        }

        .form-control, .form-select, .form-textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1.5px solid #dce4db;
            border-radius: 12px;
            font-size: 0.95rem;
            color: #26392d;
            background: #fbfcfb;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .form-control:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #34754a;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(52, 117, 74, 0.12);
        }

        .icon-picker-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 0.35rem;
        }

        .icon-option {
            cursor: pointer;
        }

        .icon-option input {
            display: none;
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
            transition: all 0.2s;
        }

        .icon-option input:checked + .icon-box {
            border-color: #34754a;
            background: #e7efe4;
            transform: scale(1.1);
            box-shadow: 0 4px 10px rgba(52, 117, 74, 0.15);
        }

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f1f5f9;
        }

        .btn-cancel {
            padding: 0.8rem 1.5rem;
            color: #64748b;
            font-weight: 600;
            border-radius: 12px;
            transition: background 0.2s;
        }

        .btn-cancel:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .btn-publish {
            padding: 0.85rem 2rem;
            background: #34754a;
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 0.98rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(52, 117, 74, 0.25);
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-publish:hover {
            background: #24583b;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(36, 88, 59, 0.35);
        }

        .alert-error {
            background: #fdf2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 0.85rem 1rem;
            border-radius: 12px;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    @include('partials.navbar')

    <div class="page-container">
        
        <div class="form-card">
            
            <div class="form-header">
                <h1>Edit Produk: {{ $product->name }}</h1>
                <p>Perbarui informasi harga, stok, atau deskripsi produk Anda</p>
            </div>

            @if(isset($errors) && $errors->any())
                <div class="alert-error">
                    <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Produk -->
                <div class="form-group">
                    <label class="form-label" for="name">Nama Produk Pertanian *</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control" 
                        value="{{ old('name', $product->name) }}" 
                        required 
                    >
                </div>

                <div class="form-grid-2">
                    <!-- Kategori -->
                    <div class="form-group">
                        <label class="form-label" for="category">Kategori Produk *</label>
                        <select name="category" id="category" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $product->category) === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Lokasi / Kota Penjual -->
                    <div class="form-group">
                        <label class="form-label" for="location">Kota / Asal Lokasi *</label>
                        <input 
                            type="text" 
                            name="location" 
                            id="location" 
                            class="form-control" 
                            value="{{ old('location', $product->location) }}" 
                            required
                        >
                    </div>
                </div>

                <div class="form-grid-2">
                    <!-- Harga -->
                    <div class="form-group">
                        <label class="form-label" for="price">Harga Jual (Rp) *</label>
                        <input 
                            type="number" 
                            name="price" 
                            id="price" 
                            class="form-control" 
                            value="{{ old('price', $product->price) }}" 
                            min="500" 
                            required
                        >
                    </div>

                    <!-- Stok & Satuan -->
                    <div class="form-group">
                        <label class="form-label">Stok & Satuan *</label>
                        <div style="display: flex; gap: 8px;">
                            <input 
                                type="number" 
                                name="stock" 
                                class="form-control" 
                                value="{{ old('stock', $product->stock) }}" 
                                min="0" 
                                style="flex: 1;" 
                                required
                            >
                            <select name="unit" class="form-select" style="width: 130px;" required>
                                @foreach(['pack', 'kg', 'gram', 'ikat', 'karung', 'pcs', 'botol'] as $u)
                                    <option value="{{ $u }}" {{ old('unit', $product->unit) === $u ? 'selected' : '' }}>{{ $u }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-grid-2">
                    <!-- Status Ketersediaan -->
                    <div class="form-group">
                        <label class="form-label" for="status">Status Ketersediaan *</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="tersedia" {{ old('status', $product->status) === 'tersedia' ? 'selected' : '' }}>Tersedia (Bisa dibeli)</option>
                            <option value="habis" {{ old('status', $product->status) === 'habis' ? 'selected' : '' }}>Habis (Stok Kosong)</option>
                        </select>
                    </div>

                    <!-- Ikon Emoji -->
                    <div class="form-group">
                        <label class="form-label">Ikon Emoji:</label>
                        <div class="icon-picker-grid">
                            @foreach($suggestedIcons as $icon)
                                <label class="icon-option">
                                    <input type="radio" name="icon" value="{{ $icon }}" {{ old('icon', $product->icon) === $icon ? 'checked' : '' }}>
                                    <div class="icon-box">{{ $icon }}</div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Foto Produk -->
                <div class="form-group">
                    <label class="form-label" for="image">Ganti Foto Produk (Opsional)</label>
                    @if($product->image)
                        <div style="margin-bottom: 8px;">
                            <img src="{{ asset($product->image) }}" alt="Foto saat ini" style="width: 70px; height: 70px; object-fit: cover; border-radius: 12px; border: 1px solid #dce4db;">
                        </div>
                    @endif
                    <input 
                        type="file" 
                        name="image" 
                        id="image" 
                        class="form-control" 
                        accept="image/png, image/jpeg, image/webp"
                    >
                </div>

                <!-- Deskripsi Produk -->
                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi Produk</label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="4" 
                        class="form-textarea" 
                    >{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Aksi -->
                <div class="form-actions">
                    <a href="{{ route('products.my') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-publish">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>

            </form>

        </div>

    </div>

</body>
</html>

