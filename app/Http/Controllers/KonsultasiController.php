<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KonsultasiController extends Controller
{
public function index()
{
    $riwayat = session()->get('taniai_riwayat', []);

    return view('konsultasi', compact('riwayat'));
}

    public function tanya(Request $request)
    {
        $data = $request->validate([
            'pertanyaan' => 'required|string|min:10|max:1000',
        ]);

$riwayat = session()->get('taniai_riwayat', []);

$konteks = '';

foreach (array_slice($riwayat, -8) as $pesan) {
    $peran = $pesan['role'] === 'user'
        ? 'Pengguna'
        : 'TaniAI';

    $konteks .= $peran . ': '
        . $pesan['content'] . "\n\n";
}

$input = "Lanjutkan percakapan konsultasi tanaman berikut.\n\n"
    . $konteks
    . "Pengguna: " . $data['pertanyaan']
    . "\nTaniAI:";

        $apiKey = config('services.gemini.key');

        if (!$apiKey) {
            return back()->withInput()
                ->with('ai_error', 'API key Gemini belum diatur.');
        }

        try {
            $response = Http::withHeaders([
                'x-goog-api-key' => $apiKey,
            ])
            ->acceptJson()
            ->timeout(45)
            ->post(
                'https://generativelanguage.googleapis.com/v1beta/interactions',
                [
                    'model' => config('services.gemini.model'),
                    'input' => $input,
                    'store' => false,
                    'system_instruction' =>
                        'Kamu adalah TaniAI, asisten pertanian '
                        . 'untuk pengguna Indonesia. '
                        . 'Jawab dalam bahasa Indonesia yang ramah '
                        . 'dan mudah dipahami. Berikan saran '
                        . 'perawatan tanaman berdasarkan informasi '
                        . 'pengguna. Jika informasi belum cukup, '
                        . 'ajukan pertanyaan lanjutan. '
                        . 'Jangan mengklaim diagnosis pasti. '
                        . 'Jangan mengarang hasil pengukuran, '
                        . 'kondisi tanah, atau cuaca.',
                ]
            );
        } catch (ConnectionException $e) {
            return back()->withInput()
                ->with('ai_error', 'Koneksi ke Gemini gagal.');
        }

        if ($response->failed()) {
            Log::warning('Gemini API gagal', [
                'status' => $response->status(),
            ]);

            $pesan = match ($response->status()) {
                401, 403 => 'API key tidak valid atau tidak memiliki akses.',
                429 => 'Batas penggunaan Gemini tercapai. Coba lagi nanti.',
                404 => 'Model Gemini tidak tersedia untuk API key ini.',
                default => 'Gemini sedang tidak dapat menjawab.',
            };

            return back()->withInput()
                ->with('ai_error', $pesan);
        }

        $jawaban = collect($response->json('steps', []))
            ->where('type', 'model_output')
            ->flatMap(fn ($step) => $step['content'] ?? [])
            ->where('type', 'text')
            ->pluck('text')
            ->implode("\n\n");

        if (trim($jawaban) === '') {
            return back()->withInput()
                ->with('ai_error', 'Gemini tidak menghasilkan jawaban teks.');
        }

$riwayat[] = [
    'role' => 'user',
    'content' => $data['pertanyaan'],
];

$riwayat[] = [
    'role' => 'assistant',
    'content' => $jawaban,
];

session()->put(
    'taniai_riwayat',
    array_slice($riwayat, -10)
);

return redirect()->route('konsultasi');
    }
    public function reset()
{
    session()->forget('taniai_riwayat');

    return redirect()->route('konsultasi');
}
}