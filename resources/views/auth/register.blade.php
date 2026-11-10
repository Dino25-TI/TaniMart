<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru | TaniMart</title>
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1rem;
            background: radial-gradient(circle at 10% 20%, rgba(52, 117, 74, 0.08) 0%, rgba(248, 247, 240, 1) 90%);
        }

        .auth-card {
            background: #ffffff;
            width: 100%;
            max-width: 500px;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 20px 50px rgba(36, 88, 59, 0.12);
            border: 1px solid #e7ebe3;
            position: relative;
            overflow: hidden;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #34754a, #52a36d, #8cd19d);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: #24583b;
            margin-bottom: 0.5rem;
            display: inline-block;
        }

        .auth-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #26392d;
            margin-bottom: 0.35rem;
        }

        .auth-subtitle {
            font-size: 0.95rem;
            color: #758176;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #26392d;
            margin-bottom: 0.4rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #758176;
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 1.5px solid #dce4db;
            border-radius: 12px;
            font-size: 0.95rem;
            color: #26392d;
            background: #fbfcfb;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #34754a;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(52, 117, 74, 0.12);
        }

        /* Role Selector Cards */
        .role-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .role-option {
            position: relative;
        }

        .role-option input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .role-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0.85rem;
            border: 2px solid #e1e8e0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
            background: #fafbfa;
        }

        .role-box i {
            font-size: 1.35rem;
            margin-bottom: 0.35rem;
            color: #758176;
        }

        .role-box span {
            font-size: 0.9rem;
            font-weight: 700;
            color: #26392d;
        }

        .role-box small {
            font-size: 0.72rem;
            color: #758176;
        }

        .role-option input:checked + .role-box {
            border-color: #34754a;
            background: #eef6f0;
        }

        .role-option input:checked + .role-box i,
        .role-option input:checked + .role-box span {
            color: #24583b;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #758176;
            cursor: pointer;
            padding: 4px;
        }

        .password-toggle:hover {
            color: #26392d;
        }

        .btn-submit {
            width: 100%;
            padding: 0.9rem;
            background: #34754a;
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 8px 20px rgba(52, 117, 74, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 0.5rem;
        }

        .btn-submit:hover {
            background: #24583b;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(36, 88, 59, 0.35);
        }

        .alert {
            padding: 0.85rem 1rem;
            border-radius: 12px;
            font-size: 0.9rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-error {
            background: #fdf2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .auth-footer {
            margin-top: 1.8rem;
            text-align: center;
            font-size: 0.92rem;
            color: #758176;
        }

        .auth-footer a {
            color: #34754a;
            font-weight: 700;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 1.2rem;
            color: #758176;
            font-size: 0.88rem;
            font-weight: 600;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #24583b;
        }
    </style>
</head>
<body>

    <div class="auth-container">
        <div class="auth-card">
            
            <div class="auth-header">
                <a href="/" class="auth-logo">🌱 TaniMart</a>
                <h1 class="auth-title">Daftar Akun Baru</h1>
                <p class="auth-subtitle">Bergabung bersama komunitas pertanian modern</p>
            </div>

            @if(isset($errors) && $errors->any())
                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-xmark"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST">
                @csrf

                {{-- Pilih Peran / Role --}}
                <div class="form-group">
                    <label class="form-label">Daftar Sebagai:</label>
                    <div class="role-grid">
                        <label class="role-option">
                            <input type="radio" name="role" value="user" {{ old('role', 'user') === 'user' ? 'checked' : '' }}>
                            <div class="role-box">
                                <i class="fa-solid fa-seedling"></i>
                                <span>Pengguna / Pembeli</span>
                                <small>Belanja produk tani</small>
                            </div>
                        </label>

                        <label class="role-option">
                            <input type="radio" name="role" value="admin" {{ old('role') === 'admin' ? 'checked' : '' }}>
                            <div class="role-box">
                                <i class="fa-solid fa-shield-halved"></i>
                                <span>Administrator</span>
                                <small>Kelola toko & data</small>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Nama Lengkap --}}
                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-user input-icon"></i>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="form-control" 
                            placeholder="Contoh: Budi Santoso" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                        >
                    </div>
                </div>

                {{-- Alamat Email --}}
                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-envelope input-icon"></i>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control" 
                            placeholder="nama@email.com" 
                            value="{{ old('email') }}" 
                            required
                        >
                    </div>
                </div>

                {{-- Nomor Telepon/WhatsApp --}}
                <div class="form-group">
                    <label class="form-label" for="phone">Nomor Telepon / WhatsApp (Opsional)</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-phone input-icon"></i>
                        <input 
                            type="tel" 
                            name="phone" 
                            id="phone" 
                            class="form-control" 
                            placeholder="Contoh: 081234567890" 
                            value="{{ old('phone') }}"
                        >
                    </div>
                </div>

                {{-- Kata Sandi --}}
                <div class="form-group">
                    <label class="form-label" for="password">Kata Sandi</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-control" 
                            placeholder="Minimal 6 karakter" 
                            required
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password', this)" title="Lihat password">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>

                {{-- Konfirmasi Kata Sandi --}}
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-shield-check input-icon"></i>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            class="form-control" 
                            placeholder="Ulangi kata sandi" 
                            required
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)" title="Lihat password">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <span>Daftar Akun Sekarang</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="auth-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                <br>
                <a href="/" class="back-link">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
