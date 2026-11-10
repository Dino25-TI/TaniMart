<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk Jualan Saya | TaniMart</title>
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f3;
        }

        .my-products-container {
            max-width: 1100px;
            margin: 2.5rem auto 4rem;
            padding: 0 1.5rem;
        }

        .dashboard-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .dashboard-title h1 {
            font-size: 1.85rem;
            font-weight: 800;
            color: #24583b;
            margin-bottom: 0.35rem;
        }

        .dashboard-title p {
            color: #758176;
            font-size: 0.95rem;
        }

        .btn-add-product {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0.85rem 1.6rem;
            background: #34754a;
            color: #ffffff !important;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.95rem;
            box-shadow: 0 6px 20px rgba(52, 117, 74, 0.25);
            transition: all 0.2s;
        }

        .btn-add-product:hover {
            background: #24583b;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(36, 88, 59, 0.35);
        }

        /* Stats */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .mini-stat {
            background: #ffffff;
            border-radius: 18px;
            padding: 1.25rem 1.5rem;
            border: 1px solid #e1e7e0;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }

        .mini-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #e7efe4;
            color: #24583b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        .mini-stat-info h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 2px;
        }

        .mini-stat-info p {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 600;
        }

        /* Products Table Card */
        .table-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 1.75rem;
            border: 1px solid #e1e7e0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.85rem 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.92rem;
            vertical-align: middle;
        }

        tr:hover td {
            background: #fbfcfb;
        }

        .product-meta {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .product-avatar {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: #e7efe4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            overflow: hidden;
            border: 1px solid #dce4db;
        }

        .product-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .status-tersedia {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .status-habis {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .action-btns {
            display: flex;
            align-items: center;
            gap: 6px;
            justify-content: flex-end;
        }

        .btn-act {
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-act:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .btn-act-danger {
            color: #b91c1c;
            border-color: #fecaca;
            background: #fef2f2;
        }

        .btn-act-danger:hover {
            background: #b91c1c;
            color: #ffffff;
        }

        .empty-state {
            text-align: center;
            padding: 3.5rem 1rem;
            color: #758176;
        }

        .empty-state i {
            font-size: 3.5rem;
            color: #a4cbb0;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #26392d;
            margin-bottom: 0.4rem;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    @include('partials.navbar')

    <main class="my-products-container">

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success" style="background: #f0fdf4; color: #166534; padding: 1rem 1.25rem; border-radius: 14px; margin-bottom: 1.5rem; border: 1px solid #bbf7d0; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="dashboard-top">
            <div class="dashboard-title">
                <h1>Kios Jualan Saya 🌿</h1>
                <p>Kelola semua barang pertanian dan hasil kebun yang Anda pasarkan di TaniMart</p>
            </div>

            <a href="/jual-produk" class="btn-add-product">
                <i class="fa-solid fa-plus"></i>
                <span>Pasang Produk Baru</span>
            </a>
        </div>

        <!-- Metric Stat Cards -->
        <div class="stats-row">
            <div class="mini-stat">
                <div class="mini-stat-icon">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <div class="mini-stat-info">
                    <h3>{{ $products->count() }}</h3>
                    <p>Total Produk Saya</p>
                </div>
            </div>

            <div class="mini-stat">
                <div class="mini-stat-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="mini-stat-info">
                    <h3>{{ $products->where('status', 'tersedia')->count() }}</h3>
                    <p>Produk Siap Jual</p>
                </div>
            </div>

            <div class="mini-stat">
                <div class="mini-stat-icon">
                    <i class="fa-solid fa-warehouse"></i>
                </div>
                <div class="mini-stat-info">
                    <h3>{{ $products->sum('stock') }}</h3>
                    <p>Total Akumulasi Stok</p>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-card">
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Sisa Stok</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $p)
                                <tr>
                                    <td>
                                        <div class="product-meta">
                                            <div class="product-avatar">
                                                @if($p->image)
                                                    <img src="{{ asset($p->image) }}" alt="{{ $p->name }}">
                                                @else
                                                    <span>{{ $p->icon }}</span>
                                                @endif
                                            </div>
                                            <div>
                                                <strong>{{ $p->name }}</strong>
                                                <br>
                                                <small style="color: #64748b;">Dibuat: {{ $p->created_at->format('d M Y') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $p->category }}</td>
                                    <td>
                                        <strong style="color: #24583b;">
                                            Rp {{ number_format($p->price, 0, ',', '.') }}
                                        </strong>
                                        <small style="color: #64748b;">/ {{ $p->unit }}</small>
                                    </td>
                                    <td>{{ $p->stock }} {{ $p->unit }}</td>
                                    <td><small><i class="fa-solid fa-location-dot" style="color: #ef4444;"></i> {{ $p->location }}</small></td>
                                    <td>
                                        <span class="status-badge status-{{ $p->status }}">
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <!-- Toggle Status -->
                                            <form action="/produk-saya/{{ $p->id }}/toggle-status" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-act" title="Ubah status ketersediaan">
                                                    <i class="fa-solid fa-arrows-rotate"></i>
                                                    {{ $p->status === 'tersedia' ? 'Tandai Habis' : 'Tandai Tersedia' }}
                                                </button>
                                            </form>

                                            <!-- Edit -->
                                            <a href="/produk-saya/{{ $p->id }}/edit" class="btn-act" title="Edit produk">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>

                                            <!-- Hapus -->
                                            <form action="/produk-saya/{{ $p->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $p->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-act btn-act-danger" title="Hapus produk">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fa-solid fa-seedling"></i>
                    <h3>Anda belum memasang produk untuk dijual</h3>
                    <p>Mulai tawarkan bibit, hasil panen sayuran, pot, atau perlengkapan kebun Anda sekarang juga!</p>
                    <br>
                    <a href="/jual-produk" class="btn-add-product" style="display: inline-flex;">
                        <i class="fa-solid fa-plus"></i> Pasang Produk Pertama Anda
                    </a>
                </div>
            @endif
        </div>

    </main>

</body>
</html>

