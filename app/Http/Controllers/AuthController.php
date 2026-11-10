<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan formulir login
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin() 
                ? redirect()->route('admin.dashboard') 
                : redirect('/');
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', "Halo {$user->name}! Anda berhasil masuk sebagai Administrator.");
            }

            return redirect()->intended('/')
                ->with('success', "Halo {$user->name}! Senang melihatmu kembali di TaniMart 🌱");
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan formulir registrasi
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin() 
                ? redirect()->route('admin.dashboard') 
                : redirect('/');
        }

        return view('auth.register');
    }

    /**
     * Proses pendaftaran akun baru
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'role' => 'nullable|in:user,admin',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar. Gunakan email lain atau silakan login.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal harus 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $role = $validated['role'] ?? 'user';

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => $role,
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('success', "Pendaftaran berhasil! Selamat datang di Dashboard Admin, {$user->name}.");
        }

        return redirect('/')
            ->with('success', "Pendaftaran berhasil! Selamat bergabung di TaniMart, {$user->name} 🌱");
    }

    /**
     * Proses keluar (logout)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar dari akun.');
    }
}

