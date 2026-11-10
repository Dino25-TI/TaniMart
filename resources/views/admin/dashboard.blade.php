<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrator | TaniMart</title>
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f3;
            color: #26392d;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Admin Navbar */
        .admin-nav {
            background: #ffffff;
            border-bottom: 1px solid #e1e7e0;
            padding: 0.85rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-logo {
            font-size: 1.4rem;
            font-weight: 800;
            color: #24583b;
        }

        .admin-badge-top {
            background: #e0f2fe;
            color: #0369a1;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            letter-spacing: 0.5px;
            border: 1px solid #bae6fd;
        }

        .admin-user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .store-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.5rem 1rem;
            background: #f0f7f1;
            color: #24583b;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.88rem;
            border: 1px solid #cce3d1;
            transition: all 0.2s;
        }

        .store-btn:hover {
            background: #24583b;
            color: #ffffff;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #34754a;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .logout-btn {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 0.5rem 0.9rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .logout-btn:hover {
            background: #b91c1c;
            color: #ffffff;
        }

        /* Dashboard Container */
        .admin-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .dashboard-header {
            margin-bottom: 2rem;
        }

        .dashboard-header h1 {
            font-size: 1.85rem;
            font-weight: 800;
            color: #1e3a2b;
            margin-bottom: 0.35rem;
        }

        .dashboard-header p {
            color: #64748b;
            font-size: 0.95rem;
        }

        /* Stat Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: center;
            gap: 1.2rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        }

        .stat-icon {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .icon-users { background: #ecfdf5; color: #059669; }
        .icon-admin { background: #eff6ff; color: #2563eb; }
        .icon-customer { background: #fefce8; color: #ca8a04; }
        .icon-products { background: #faf5ff; color: #9333ea; }

        .stat-info h3 {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 0.15rem;
            color: #1e293b;
        }

        .stat-info p {
            font-size: 0.88rem;
            color: #64748b;
            font-weight: 600;
        }

        /* Content Sections */
        .content-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 1.75rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            margin-bottom: 2rem;
        }

        .content-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .content-card-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Modern Table */
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

        .role-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .role-admin {
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }

        .role-user {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .actions-cell {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-toggle-role {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #cbd5e1;
        }

        .btn-toggle-role:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .btn-delete {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .btn-delete:hover {
            background: #b91c1c;
            color: #ffffff;
        }

        /* Alert notifications */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 14px;
            font-size: 0.92rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }
    </style>
</head>
<body>

    <!-- Admin Navbar -->
    <header class="admin-nav">
        <div class="admin-brand">
            <a href="/" class="admin-logo">🌱 TaniMart</a>
            <span class="admin-badge-top"><i class="fa-solid fa-shield-halved"></i> PANEL ADMIN</span>
        </div>

        <div class="admin-user-menu">
            <a href="/jual-produk" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.5rem 1rem; background: #34754a; color: #ffffff; border-radius: 10px; font-weight: 700; font-size: 0.88rem; transition: all 0.2s; text-decoration: none;">
                <i class="fa-solid fa-plus"></i> Jual Produk Baru
            </a>

            <a href="/produk-saya" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.5rem 0.9rem; background: #f0f7f1; color: #24583b; border-radius: 10px; font-weight: 600; font-size: 0.88rem; border: 1px solid #cce3d1; transition: all 0.2s; text-decoration: none;">
                <i class="fa-solid fa-boxes-stacked"></i> Produk Saya
            </a>

            <a href="/" class="store-btn">
                <i class="fa-solid fa-shop"></i> Ke Halaman Toko
            </a>

            <div class="admin-profile">
                <div class="avatar-circle">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span>{{ auth()->user()->name }}</span>
            </div>

            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn" title="Keluar dari akun">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </header>

    <main class="admin-container">

        <!-- Flash messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Page Header -->
        <div class="dashboard-header">
            <h1>Selamat Datang di Pusat Kendali, {{ auth()->user()->name }} 👋</h1>
            <p>Kelola peran pengguna, pantau stok produk pertanian, dan pantau aktivitas pesanan TaniMart.</p>
        </div>

        <!-- Metric Stat Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-users">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Akun Terdaftar</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-admin">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalAdmins }}</h3>
                    <p>Total Administrator</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-customer">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalCustomers }}</h3>
                    <p>Pelanggan / Pengguna</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-products">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ count($products) }}</h3>
                    <p>Kategori Produk Aktif</p>
                </div>
            </div>
        </div>

        <!-- Tabel Manajemen Pengguna -->
        <div class="content-card">
            <div class="content-card-header">
                <h2 class="content-card-title">
                    <i class="fa-solid fa-id-badge" style="color: #34754a;"></i>
                    Daftar Pengguna & Hak Akses
                </h2>
                <span style="font-size: 0.85rem; color: #64748b;">
                    Total: <strong>{{ $totalUsers }}</strong> pengguna
                </span>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Peran (Role)</th>
                            <th>Terdaftar Pada</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $u)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $u->name }}</strong>
                                    @if($u->id === auth()->id())
                                        <small style="color: #0284c7; font-weight: 600;">(Akun Anda)</small>
                                    @endif
                                </td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->phone ?? '-' }}</td>
                                <td>
                                    @if($u->isAdmin())
                                        <span class="role-pill role-admin">
                                            <i class="fa-solid fa-shield"></i> Admin
                                        </span>
                                    @else
                                        <span class="role-pill role-user">
                                            <i class="fa-solid fa-user"></i> Pengguna
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $u->created_at ? $u->created_at->format('d M Y H:i') : '-' }}</td>
                                <td>
                                    <div class="actions-cell" style="justify-content: flex-end;">
                                        @if($u->id !== auth()->id())
                                            <form action="{{ route('admin.users.toggle-role', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengubah peran pengguna {{ $u->name }}?')">
                                                @csrf
                                                <button type="submit" class="btn-action btn-toggle-role" title="Ganti peran pengguna">
                                                    <i class="fa-solid fa-rotate"></i>
                                                    Ubah jadi {{ $u->isAdmin() ? 'User' : 'Admin' }}
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna {{ $u->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" title="Hapus pengguna">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @else
                                            <small style="color: #94a3b8; font-style: italic;">Sedang aktif</small>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Grid: Produk & Pesanan Terakhir -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 1.5rem;">
            
            <!-- Ringkasan Katalog Produk -->
            <div class="content-card" style="margin-bottom: 0;">
                <div class="content-card-header">
                    <h2 class="content-card-title">
                        <i class="fa-solid fa-plant-wilt" style="color: #34754a;"></i>
                        Katalog Produk Toko
                    </h2>
                    <a href="/jual-produk" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; background: #34754a; color: #ffffff; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none;">
                        <i class="fa-solid fa-plus"></i> Jual / Tambah Produk
                    </a>
                </div>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Penjual</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $prod)
                                <tr>
                                    <td>
                                        <span>{{ $prod->icon }}</span>
                                        <strong>{{ $prod->name }}</strong>
                                        <br>
                                        <small style="color: #64748b;">{{ $prod->category }}</small>
                                    </td>
                                    <td>
                                        <small style="font-weight: 600; color: #24583b;">
                                            {{ $prod->user->name ?? 'Admin' }}
                                        </small>
                                    </td>
                                    <td>Rp {{ number_format($prod->price, 0, ',', '.') }}</td>
                                    <td>
                                        <span style="font-weight: 700; color: #166534;">
                                            {{ $prod->stock }} {{ $prod->unit }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 4px; justify-content: flex-end;">
                                            <a href="/produk-saya/{{ $prod->id }}/edit" class="btn-action btn-toggle-role" style="padding: 4px 8px; font-size: 0.78rem;" title="Edit Produk">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form action="/produk-saya/{{ $prod->id }}" method="POST" onsubmit="return confirm('Hapus produk {{ $prod->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" style="padding: 4px 8px; font-size: 0.78rem;" title="Hapus Produk">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pesanan Terakhir -->
            <div class="content-card" style="margin-bottom: 0;">
                <div class="content-card-header">
                    <h2 class="content-card-title">
                        <i class="fa-solid fa-receipt" style="color: #34754a;"></i>
                        Pesanan Terakhir
                    </h2>
                </div>

                @if($pesananTerakhir)
                    <div style="background: #f8fafc; border-radius: 12px; padding: 1.2rem; border: 1px solid #e2e8f0;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                            <span style="font-weight: 700; color: #0f172a;">{{ $pesananTerakhir['nomor'] }}</span>
                            <span style="font-size: 0.8rem; color: #64748b;">{{ $pesananTerakhir['tanggal'] }}</span>
                        </div>
                        <p style="margin-bottom: 0.4rem; font-size: 0.9rem;">
                            <strong>Penerima:</strong> {{ $pesananTerakhir['penerima']['nama'] }} ({{ $pesananTerakhir['penerima']['telepon'] }})
                        </p>
                        <p style="margin-bottom: 0.6rem; font-size: 0.85rem; color: #64748b;">
                            {{ $pesananTerakhir['penerima']['alamat'] }}
                        </p>
                        <div style="border-top: 1px dashed #cbd5e1; padding-top: 0.6rem; display: flex; justify-content: space-between; font-weight: 700;">
                            <span>Total Pembayaran:</span>
                            <span style="color: #166534;">Rp {{ number_format($pesananTerakhir['total'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                @else
                    <div style="text-align: center; padding: 2rem; color: #94a3b8;">
                        <i class="fa-solid fa-box-open" style="font-size: 2.5rem; margin-bottom: 0.75rem; opacity: 0.6;"></i>
                        <p style="font-size: 0.92rem;">Belum ada pesanan yang masuk pada sesi ini.</p>
                        <a href="/checkout" style="font-size: 0.82rem; color: #34754a; font-weight: 600;">Coba lakukan pemesanan di toko →</a>
                    </div>
                @endif
            </div>

        </div>

    </main>

</body>
</html>

