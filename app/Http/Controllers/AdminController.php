<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard utama admin
     */
    public function dashboard()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $totalUsers = $users->count();
        $totalAdmins = $users->where('role', 'admin')->count();
        $totalCustomers = $users->where('role', 'user')->count();

        $products = \App\Models\Product::with('user')->latest()->get();

        // Ambil riwayat pesanan sesi terakhir jika ada
        $pesananTerakhir = session()->get('pesanan_terakhir');

        return view('admin.dashboard', compact(
            'users',
            'totalUsers',
            'totalAdmins',
            'totalCustomers',
            'products',
            'pesananTerakhir'
        ));
    }

    /**
     * Ubah peran (role) pengguna (User <-> Admin)
     */
    public function toggleRole(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat mengubah peran akun Anda sendiri.');
        }

        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();

        return back()->with('success', "Peran untuk {$user->name} berhasil diubah menjadi {$user->role}.");
    }

    /**
     * Hapus pengguna
     */
    public function deleteUser(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "Pengguna {$name} berhasil dihapus dari sistem.");
    }
}

