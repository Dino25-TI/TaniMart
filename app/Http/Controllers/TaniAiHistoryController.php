<?php

namespace App\Http\Controllers;

use App\Models\TaniAiConversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Pengelolaan riwayat konsultasi TaniAI.
 *
 * Jawaban AI tetap diproses oleh KonsultasiController lama.
 */
class TaniAiHistoryController extends Controller
{
    /**
     * Tampilkan halaman chat dan riwayat pengguna.
     */
    public function index(Request $request)
    {
        $riwayat = [];
        $percakapanAktif = null;
        $daftarPercakapan = collect();

        $pencarian = trim(
            (string) $request->query('cari', '')
        );

        if (auth()->check()) {
            $query = TaniAiConversation::query()
                ->where('user_id', auth()->id());

            // Pencarian hanya di dalam riwayat pemilik akun.
            if ($pencarian !== '') {
                $query->where(
                    'title',
                    'like',
                    '%' . $pencarian . '%'
                );
            }

            $daftarPercakapan = $query
                ->latest('updated_at')
                ->limit(100)
                ->get();

            $id = $request->query(
                'percakapan',
                session('taniai_active_conversation_id')
            );

            if (
                $id !== null &&
                ctype_digit((string) $id)
            ) {
                $percakapanAktif = TaniAiConversation::query()
                    ->where('user_id', auth()->id())
                    ->whereKey((int) $id)
                    ->first();
            }

            if ($percakapanAktif) {
                session()->put(
                    'taniai_active_conversation_id',
                    $percakapanAktif->id
                );

                $riwayat = $percakapanAktif
                    ->messages()
                    ->orderBy('id')
                    ->get(['role', 'content'])
                    ->map(fn ($pesan) => [
                        'role' => $pesan->role,
                        'content' => $pesan->content,
                    ])
                    ->all();
            } else {
                session()->forget(
                    'taniai_active_conversation_id'
                );
            }
        } else {
            // Pengunjung tanpa login tetap bisa bertanya.
            $riwayat = session()->get(
                'taniai_riwayat',
                []
            );
        }

        return view('konsultasi', compact(
            'riwayat',
            'percakapanAktif',
            'daftarPercakapan',
            'pencarian'
        ));
    }

    /**
     * Mengirim pertanyaan dan menyimpan hasilnya.
     */
    public function tanya(
        Request $request,
        KonsultasiController $mesinAi
    ) {
        // Pertahankan cara kerja lama untuk pengunjung.
        if (!auth()->check()) {
            return $mesinAi->tanya($request);
        }

        $data = $request->validate([
            'conversation_id' => 'nullable|integer|min:1',
        ]);

        $percakapan = null;

        // Ambil percakapan yang dipilih, jika ada.
        if (!empty($data['conversation_id'])) {
            $percakapan = TaniAiConversation::query()
                ->where('user_id', auth()->id())
                ->whereKey((int) $data['conversation_id'])
                ->firstOrFail();
        }

        /*
         * Siapkan konteks terakhir untuk Gemini.
         *
         * Engine AI lama membaca riwayat dari session.
         * Kita mengisinya dari MySQL sebelum memanggilnya.
         */
        $konteks = $percakapan
            ? $percakapan
                ->messages()
                ->latest('id')
                ->limit(12)
                ->get()
                ->reverse()
                ->values()
                ->map(fn ($pesan) => [
                    'role' => $pesan->role,
                    'content' => $pesan->content,
                ])
                ->all()
            : [];

        session()->put(
            'taniai_riwayat',
            $konteks
        );

        // Menggunakan Gemini / fallback lokal yang sudah ada.
        $jawabanLama = $mesinAi->tanya($request);

        // Ambil pertanyaan dan jawaban yang baru dibuat.
        $hasil = session()->get(
            'taniai_riwayat',
            []
        );

        $duaPesan = array_slice($hasil, -2);

        if (
            count($duaPesan) !== 2 ||
            ($duaPesan[0]['role'] ?? '') !== 'user' ||
            ($duaPesan[1]['role'] ?? '') !== 'assistant'
        ) {
            return $jawabanLama;
        }

        // Simpan kedua pesan secara konsisten.
        $id = DB::transaction(function () use (
            $percakapan,
            $duaPesan
        ) {
            if (!$percakapan) {
                $percakapan = TaniAiConversation::create([
                    'user_id' => auth()->id(),
                    'title' => Str::limit(
                        $duaPesan[0]['content'],
                        100,
                        '…'
                    ),
                ]);
            }

            foreach ($duaPesan as $pesan) {
                $percakapan->messages()->create([
                    'role' => $pesan['role'],
                    'content' => $pesan['content'],
                ]);
            }

            $percakapan->touch();

            return $percakapan->id;
        });

        // Pilih percakapan terbaru setelah mengirim pesan.
        session()->put(
            'taniai_active_conversation_id',
            $id
        );

        session()->forget('taniai_riwayat');

        return redirect()->route('konsultasi', [
            'percakapan' => $id,
        ]);
    }

    /**
     * Konsultasi Baru:
     * tidak menghapus riwayat lama dari MySQL.
     */
    public function reset()
    {
        session()->forget(
            'taniai_active_conversation_id'
        );

        session()->forget('taniai_riwayat');

        return redirect()->route('konsultasi');
    }

    /**
     * Hapus percakapan terpilih.
     */
    public function destroyConversation(int $conversation)
    {
        abort_unless(auth()->check(), 403);

        $item = TaniAiConversation::query()
            ->where('user_id', auth()->id())
            ->whereKey($conversation)
            ->firstOrFail();

        $item->delete();

        if (
            (int) session('taniai_active_conversation_id')
            === $conversation
        ) {
            session()->forget(
                'taniai_active_conversation_id'
            );
        }

        return redirect()
            ->route('konsultasi')
            ->with(
                'success',
                'Riwayat konsultasi berhasil dihapus.'
            );
    }
}
