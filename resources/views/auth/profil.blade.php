<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya — TaniMart</title>
    <link rel="stylesheet" href="/css/tanimart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .profil-wrapper {
            max-width: 900px;
            margin: 2.5rem auto;
            padding: 0 1.5rem;
        }
        .profil-header-card {
            background: linear-gradient(135deg, #1a3d28 0%, #2d6a4f 100%);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
            color: #fff;
        }
        .profil-avatar {
            width: 90px;
            height: 90px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: #fff;
            border: 3px solid rgba(255,255,255,0.4);
            flex-shrink: 0;
        }
        .profil-header-info h2 {
            font-size: 1.6rem;
            margin: 0 0 0.3rem;
        }
        .profil-header-info p {
            margin: 0;
            opacity: 0.8;
            font-size: 0.95rem;
        }
        .profil-stats {
            display: flex;
            gap: 1.5rem;
            margin-top: 1rem;
        }
        .profil-stat {
            background: rgba(255,255,255,0.15);
            border-radius: 10px;
            padding: 0.5rem 1.1rem;
            text-align: center;
        }
        .profil-stat strong { display: block; font-size: 1.3rem; }
        .profil-stat span { font-size: 0.75rem; opacity: 0.8; }
        .profil-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        @media (max-width: 640px) {
            .profil-grid { grid-template-columns: 1fr; }
            .profil-header-card { flex-direction: column; text-align: center; }
            .profil-stats { justify-content: center; }
        }
        .profil-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e5ede9;
            padding: 1.75rem;
            box-shadow: 0 2px 12px rgba(45,106,79,0.07);
        }
        .profil-card h3 {
            font-size: 1rem;
            color: #1a3d28;
            margin: 0 0 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-bottom: 2px solid #e8f5ed;
            padding-bottom: 0.75rem;
        }
        .form-group {
            margin-bottom: 1.1rem;
        }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #3a5a4a;
            margin-bottom: 0.4rem;
        }
        .form-group input {
            width: 100%;
            padding: 0.65rem 0.9rem;
            border: 1.5px solid #d1e8da;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: border-color 0.2s;
            box-sizing: border-box;
            background: #f7faf8;
        }
        .form-group input:focus {
            outline: none;
            border-color: #34754a;
            background: #fff;
        }
        .btn-save {
            width: 100%;
            padding: 0.75rem;
            background: #34754a;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 0.5rem;
        }
        .btn-save:hover { background: #2d6a4f; }
        .alert-success {
            background: #e8f5ed;
            border: 1px solid #a3d9b4;
            color: #1a5c32;
            border-radius: 10px;
            padding: 0.9rem 1.1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .input-hint {
            font-size: 0.78rem;
            color: #6b8c78;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <main style="min-height: 70vh; padding-bottom: 2rem;">
        <div class="profil-wrapper">

            @if(session('success'))
                <div class="alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Header Card --}}
            <div class="profil-header-card">
                <div class="profil-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="profil-header-info">
                    <h2>{{ $user->name }}</h2>
                    <p><i class="fa-solid fa-envelope" style="opacity:0.7;"></i> {{ $user->email }}</p>
                    <div class="profil-stats">
                        <div class="profil-stat">
                            <strong>{{ $user->products()->count() }}</strong>
                            <span>Produk</span>
                        </div>
                        <div class="profil-stat">
                            <strong>{{ $user->created_at->format('Y') }}</strong>
                            <span>Bergabung</span>
                        </div>
                        <div class="profil-stat">
                            <strong>{{ ucfirst($user->role ?? 'user') }}</strong>
                            <span>Role</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Forms Grid --}}
            <div class="profil-grid">

                {{-- Edit Profil --}}
                <div class="profil-card">
                    <h3><i class="fa-solid fa-user-pen"></i> Edit Informasi Profil</h3>
                    <form action="{{ route('profil.update') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <p class="input-hint" style="color:#c0392b;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" value="{{ $user->email }}" disabled style="opacity:0.6;cursor:not-allowed;">
                            <p class="input-hint">Email tidak dapat diubah.</p>
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="cth: 081234567890">
                            @error('phone')
                                <p class="input-hint" style="color:#c0392b;">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="hidden" name="form_type" value="profil">
                        <button type="submit" class="btn-save">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>

                {{-- Ganti Password --}}
                <div class="profil-card">
                    <h3><i class="fa-solid fa-lock"></i> Ganti Password</h3>
                    <form action="{{ route('profil.update') }}" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="form_type" value="password">
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input type="password" id="password" name="password" placeholder="Minimal 6 karakter">
                            @error('password')
                                <p class="input-hint" style="color:#c0392b;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                        </div>
                        <p class="input-hint" style="margin-bottom:1rem;">Kosongkan jika tidak ingin mengubah password.</p>
                        <button type="submit" class="btn-save" style="background:#1a3d28;">
                            <i class="fa-solid fa-key"></i> Perbarui Password
                        </button>
                    </form>
                </div>

            </div>

            {{-- Quick Links --}}
            <div style="margin-top:1.5rem; display:flex; gap:1rem; flex-wrap:wrap;">
                <a href="{{ route('products.my') }}" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.65rem 1.2rem;background:#e8f5ed;color:#1a3d28;border-radius:10px;font-size:0.9rem;font-weight:600;text-decoration:none;">
                    <i class="fa-solid fa-box-archive"></i> Produk Saya
                </a>
                <a href="{{ route('pesanan.riwayat') }}" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.65rem 1.2rem;background:#e8f5ed;color:#1a3d28;border-radius:10px;font-size:0.9rem;font-weight:600;text-decoration:none;">
                    <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Pesanan
                </a>
                <a href="{{ route('chat.index') }}" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.65rem 1.2rem;background:#e8f5ed;color:#1a3d28;border-radius:10px;font-size:0.9rem;font-weight:600;text-decoration:none;">
                    <i class="fa-solid fa-comments"></i> Obrolan Saya
                </a>
            </div>

        </div>
    </main>

    @include('partials.footer')
</body>
</html>
