<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Tampilkan halaman chat (Daftar percakapan & ruang obrolan)
     */
    public function index(Request $request)
    {
        $currentUserId = auth()->id();

        // Ambil ID semua lawan bicara (baik sebagai pengirim maupun penerima)
        $contactIds = Message::where('sender_id', $currentUserId)
            ->pluck('receiver_id')
            ->merge(
                Message::where('receiver_id', $currentUserId)->pluck('sender_id')
            )
            ->unique()
            ->filter(fn($id) => $id !== $currentUserId);

        // Ambil user lawan bicara jika ada parameter ?user_id=
        $activeUserId = $request->query('user_id');
        $activeUser = null;

        if ($activeUserId) {
            $activeUser = User::find($activeUserId);
            // Jika ada user aktif baru yang belum ada di riwayat, sertakan di daftar kontak
            if ($activeUser && !$contactIds->contains($activeUser->id)) {
                $contactIds->prepend($activeUser->id);
            }
        } elseif ($contactIds->isNotEmpty()) {
            // Default: buka kontak percakapan pertama jika tidak ada yang dipilih
            $activeUser = User::find($contactIds->first());
        }

        // Ambil info produk jika dibuka dari tombol "Chat Penjual" di halaman produk
        $product = null;
        if ($request->filled('product_id')) {
            $product = Product::with('user')->find($request->query('product_id'));
        }

        // Bangun daftar percakapan dengan pesan terakhir dan jumlah pesan belum dibaca
        $conversations = collect();
        foreach ($contactIds as $contactId) {
            $contact = User::find($contactId);
            if (!$contact) continue;

            $lastMessage = Message::where(function ($q) use ($currentUserId, $contactId) {
                $q->where('sender_id', $currentUserId)->where('receiver_id', $contactId);
            })->orWhere(function ($q) use ($currentUserId, $contactId) {
                $q->where('sender_id', $contactId)->where('receiver_id', $currentUserId);
            })->latest()->first();

            $unreadCount = Message::where('sender_id', $contactId)
                ->where('receiver_id', $currentUserId)
                ->where('is_read', false)
                ->count();

            $conversations->push([
                'user' => $contact,
                'last_message' => $lastMessage,
                'unread_count' => $unreadCount,
                'updated_at' => $lastMessage?->created_at ?? now(),
            ]);
        }

        // Urutkan percakapan berdasarkan waktu pesan terakhir
        $conversations = $conversations->sortByDesc('updated_at')->values();

        // Ambil riwayat pesan dengan lawan bicara yang sedang aktif
        $messages = collect();
        if ($activeUser) {
            // Tandai semua pesan dari user aktif ini sebagai SUDAH DIBACA
            Message::where('sender_id', $activeUser->id)
                ->where('receiver_id', $currentUserId)
                ->where('is_read', false)
                ->update(['is_read' => true]);

            $messages = Message::with(['product', 'sender'])
                ->where(function ($q) use ($currentUserId, $activeUser) {
                    $q->where('sender_id', $currentUserId)->where('receiver_id', $activeUser->id);
                })->orWhere(function ($q) use ($currentUserId, $activeUser) {
                    $q->where('sender_id', $activeUser->id)->where('receiver_id', $currentUserId);
                })
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('chat.index', compact('conversations', 'activeUser', 'messages', 'product'));
    }

    /**
     * Kirim pesan baru ke penjual atau pembeli
     */
    public function store(Request $request, User $user)
    {
        // Cegah chat ke diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat mengirim pesan ke akun sendiri.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:2000',
            'product_id' => 'nullable|exists:products,id',
        ], [
            'message.required' => 'Pesan tidak boleh kosong.',
            'message.max' => 'Pesan maksimal 2000 karakter.',
        ]);

        $msg = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            'product_id' => $validated['product_id'] ?? null,
            'message' => trim($validated['message']),
            'is_read' => false,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $msg->load('product'),
            ]);
        }

        return redirect()->route('chat.index', ['user_id' => $user->id]);
    }
}
