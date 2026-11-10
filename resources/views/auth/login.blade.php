<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Akun | TaniMart</title>
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background: radial-gradient(circle at 10% 20%, rgba(52, 117, 74, 0.08) 0%, rgba(248, 247, 240, 1) 90%);
        }

        .auth-card {
            background: #ffffff;
            width: 100%;
            max-width: 460px;
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

        /* Demo Selector Box */
        .demo-box {
            background: #f4f8f3;
            border: 1.5px dashed #a4cbb0;
            border-radius: 14px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .demo-box-title {
            font-size: 0.82rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #34754a;
            margin-bottom: 0.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .demo-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.6rem;
        }

        .demo-btn {
            background: #ffffff;
            border: 1px solid #c8decb;
            padding: 0.55rem 0.75rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #26392d;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .demo-btn:hover {
            background: #34754a;
            color: #ffffff;
            border-color: #34754a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(52, 117, 74, 0.2);
        }

        .demo-btn.admin-btn:hover {
            background: #1e3a8a;
            border-color: #1e3a8a;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.2);
        }

        /* Form elements */
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

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            font-size: 0.88rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #4b5e51;
            cursor: pointer;
        }

        .remember-me input {
            accent-color: #34754a;
            width: 16px;
            height: 16px;
            cursor: pointer;
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
        }

        .btn-submit:hover {
            background: #24583b;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(36, 88, 59, 0.35);
        }

        /* Alert notifications */
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

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
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
                <h1 class="auth-title">Selamat Datang!</h1>
                <p class="auth-subtitle">Masuk untuk mengelola akun atau berbelanja</p>
            </div>

            {{-- Demo Auto Fill Box --}}
            <div class="demo-box">
                <div class="demo-box-title">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> Akun Uji Coba Cepat
                </div>
                <div class="demo-buttons">
                    <button type="button" class="demo-btn admin-btn" onclick="fillAdmin()">
                        <i class="fa-solid fa-shield-halved"></i> Akun Admin
                    </button>
                    <button type="button" class="demo-btn" onclick="fillUser()">
                        <i class="fa-solid fa-user"></i> Akun User
                    </button>
                </div>
            </div>

            {{-- Flash Messages --}}
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

            @if(isset($errors) && $errors->any())
                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-xmark"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf

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
                            autofocus
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Kata Sandi</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-control" 
                            placeholder="••••••••" 
                            required
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password', this)" title="Lihat password">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    <span>Masuk ke Akun</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="auth-footer">
                Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
                <br>
                <a href="/" class="back-link">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>

    <script>
        // Toggle lihat password
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

        // Quick demo fills
        function fillAdmin() {
            document.getElementById('email').value = 'admin@tanimart.com';
            document.getElementById('password').value = 'password123';
        }

        function fillUser() {
            document.getElementById('email').value = 'user@tanimart.com';
            document.getElementById('password').value = 'password123';
        }
    </script>
</body>
</html>
