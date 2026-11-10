<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KonsultasiController extends Controller
{
    /**
     * Tampilkan halaman percakapan TaniAI
     */
    public function index()
    {
        $riwayat = session()->get('taniai_riwayat', []);

        return view('konsultasi', compact('riwayat'));
    }

    /**
     * Kirim pertanyaan ke Gemini AI atau engine cerdas TaniMart
     */
    public function tanya(Request $request)
    {
        $data = $request->validate([
            'pertanyaan' => 'required|string|min:2|max:1000',
        ], [
            'pertanyaan.required' => 'Pertanyaan tidak boleh kosong.',
            'pertanyaan.min' => 'Pertanyaan minimal 2 karakter.',
            'pertanyaan.max' => 'Pertanyaan maksimal 1000 karakter.',
        ]);

        $riwayat = session()->get('taniai_riwayat', []);
        $pertanyaan = trim($data['pertanyaan']);

        // Ambil data produk pasar TaniMart
        $products = Product::where('status', 'tersedia')->get();
        $katalogText = $products->map(function ($p) {
            return "- {$p->name} [Kategori: {$p->category}] (Harga: Rp" . number_format($p->price, 0, ',', '.') . " / {$p->unit}) - {$p->description}";
        })->implode("\n");

        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-1.5-flash');

        $jawaban = null;

        // 1. Jika API Key Google Gemini tersedia di .env, gunakan Gemini API resmi
        if (!empty($apiKey)) {
            $jawaban = $this->callGeminiApi($apiKey, $model, $pertanyaan, $riwayat, $katalogText);
        }

        // 2. Jika API Key kosong atau sedang offline, gunakan AI Engine Cerdas Lokal TaniMart
        if (empty($jawaban)) {
            $jawaban = $this->generateSmartLocalResponse($pertanyaan, $products);
        }

        // Simpan ke riwayat percakapan sesi
        $riwayat[] = [
            'role' => 'user',
            'content' => $pertanyaan,
        ];

        $riwayat[] = [
            'role' => 'assistant',
            'content' => $jawaban,
        ];

        session()->put('taniai_riwayat', array_slice($riwayat, -12));

        return redirect()->route('konsultasi');
    }

    /**
     * Panggil Google Gemini API resmi (v1beta generateContent)
     */
    protected function callGeminiApi(string $apiKey, string $model, string $pertanyaan, array $riwayat, string $katalogText): ?string
    {
        $systemInstruction = "Kamu adalah TaniAI, asisten pertanian pintar dan konsultan resmi dari TaniMart (marketplace pertanian Indonesia).\n\n"
            . "Panduan Jawaban:\n"
            . "1. Jawab secara tepat, to the point, dan langsung menjawab inti keluhan pengguna dengan ramah dan santun dalam bahasa Indonesia.\n"
            . "2. Jelaskan diagnosis penyebab (misal: penyakit, hama, defisiensi kalsium/nitrogen, atau kelebihan air) dan berikan langkah solusi yang praktis.\n"
            . "3. Jika ada produk di katalog TaniMart yang relevan untuk mengatasi masalah tersebut, rekomendasikan produk itu secara alami:\n"
            . "--- KATALOG PRODUK TANIMART ---\n"
            . $katalogText . "\n"
            . "--------------------------------\n"
            . "4. Jika pengguna menanyakan hal umum di luar pertanian, jawab secara singkat dan sopan, lalu ajak kembali berdiskusi seputar tanaman/kebun.";

        $contents = [];
        foreach (array_slice($riwayat, -6) as $msg) {
            $role = ($msg['role'] === 'user') ? 'user' : 'model';
            $contents[] = [
                'role' => $role,
                'parts' => [
                    ['text' => $msg['content']]
                ]
            ];
        }

        $contents[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $pertanyaan]
            ]
        ];

        try {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

            $response = Http::acceptJson()
                ->timeout(20)
                ->post($url, [
                    'system_instruction' => [
                        'parts' => [
                            ['text' => $systemInstruction]
                        ]
                    ],
                    'contents' => $contents,
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 1000,
                    ]
                ]);

            if ($response->successful()) {
                $candidates = $response->json('candidates', []);
                if (!empty($candidates) && isset($candidates[0]['content']['parts'][0]['text'])) {
                    return trim($candidates[0]['content']['parts'][0]['text']);
                }
            }

            Log::warning('Gemini API Warning: ' . $response->status() . ' - ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Mesin Penjawab Pintar Pertanian TaniMart (Deep Agricultural Knowledge)
     */
    protected function generateSmartLocalResponse(string $pertanyaan, $products): string
    {
        $q = strtolower($pertanyaan);
        $rekomendasi = [];

        // -------------------------------------------------------------
        // KASUS 1: Tomat / Tanaman Busuk, Mati, Layu Tiba-Tiba
        // -------------------------------------------------------------
        if ((str_contains($q, 'tomat') || str_contains($q, 'cabai') || str_contains($q, 'tanaman')) && (str_contains($q, 'busuk') || str_contains($q, 'mati') || str_contains($q, 'rontok') || str_contains($q, 'hitam'))) {
            $jawaban = "Halo Sahabat Tani! 🍅 Jangan berkecil hati, mari kita bedah penyebab tomat/tanaman busuk dan mati beserta cara mengatasinya:\n\n"
                . "🔍 Kemungkinan Penyebab Utama:\n"
                . "1. Busuk Ujung Buah (Blossom-End Rot): Bagian bawah buah tomat menghitam dan lembek. Ini bukan jamur, melainkan kekurangan Kalsium (Ca) yang dipicu oleh pola penyiraman yang tidak stabil (terlalu kering lalu banjir).\n"
                . "2. Busuk Batang/Akar (Phytophthora/Pythium): Batang dekat tanah menjadi cokelat kehitaman dan lembek akibat media tanam terlalu becek dan drainase pot tersumbat.\n"
                . "3. Layu Bakteri (Ralstonia): Tanaman layu hijau tiba-tiba di siang hari meski tanah masih basah.\n\n"
                . "💡 Langkah Penyelamatan & Pencegahan:\n"
                . "• Perbaiki Sirkulasi Air: Jangan biarkan air tergenang di piringan pot. Gunakan pot dengan drainase baik.\n"
                . "• Berikan Asupan Kalsium: Tambahkan kapur dolomit atau pupuk kalsium/cangkang telur halus pada media tanam.\n"
                . "• Pangkas Daun Bawah: Buang daun yang menempel langsung ke tanah untuk mencegah jamur tanah memercik ke buah saat disiram.\n"
                . "• Rutin Semprot Pupuk Hayati: Meningkatkan antibodi tanaman dari serangan patogen tular tanah.";

            $rekomendasi = $products->filter(fn($p) => str_contains(strtolower($p->name), 'pupuk') || str_contains(strtolower($p->name), 'media') || str_contains(strtolower($p->name), 'pot'));
        }

        // -------------------------------------------------------------
        // KASUS 2: Rekomendasi Pupuk Khusus Tomat
        // -------------------------------------------------------------
        elseif (str_contains($q, 'pupuk') && str_contains($q, 'tomat')) {
            $jawaban = "Halo Sahabat Tani! 🍅 Untuk tanaman tomat agar berbuah lebat, manis, dan tidak mudah rontok/busuk, berikut panduan pemupukan yang ideal:\n\n"
                . "1. Fase Vegetatif (Awal Tanam s/d Umur 30 Hari):\n"
                . "   • Gunakan media tanam kaya bahan organik (kompos/pupuk kandang matang) dan pupuk kaya Nitrogen (N) untuk membentuk daun dan batang yang kokoh.\n\n"
                . "2. Fase Generatif (Mulai Muncul Bunga & Buah):\n"
                . "   • Ganti ke pupuk tinggi Fosfor (P) dan Kalium (K) seperti NPK berimbang (16-16-16) atau pupuk cair organik untuk memacu pembungaan.\n"
                . "   • Sangat penting: Berikan asupan Kalsium (Ca) dan Boron secara berkala untuk mencegah busuk pantat buah dan membuat kulit tomat tebal tidak pecah.\n\n"
                . "3. Tips Aplikasi:\n"
                . "   • Larutkan pupuk organik cair seminggu sekali dan kocor ke tanah di pagi hari (hindari terkena bunga langsung).";

            $rekomendasi = $products->filter(fn($p) => str_contains(strtolower($p->name), 'pupuk') || str_contains(strtolower($p->name), 'media'));
        }

        // -------------------------------------------------------------
        // KASUS 3: Rekomendasi Pupuk Khusus Cabai
        // -------------------------------------------------------------
        elseif (str_contains($q, 'pupuk') && (str_contains($q, 'cabai') || str_contains($q, 'cabe'))) {
            $jawaban = "Halo Sahabat Tani! 🌶️ Pemupukan tanaman cabai yang tepat agar buah lebat dan pedas maksimal:\n\n"
                . "1. Saat Awal Tanam: Berikan pupuk dasar media tanam organik gembur dengan kandungan nitrogen sedang.\n"
                . "2. Saat Berbunga (Umur 40+ hari): Kocor pupuk berkadar Kalium dan Fosfor tinggi seminggu sekali agar bunga tidak rontok diterpa angin atau hujan.\n"
                . "3. Nutrisi Mikro Hayati: Gunakan pupuk organik hayati cair untuk menjaga kesuburan tanah dan menguatkan daya tahan tanaman dari penyakit keriting.";

            $rekomendasi = $products->filter(fn($p) => str_contains(strtolower($p->name), 'pupuk') || str_contains(strtolower($p->name), 'cabai'));
        }

        // -------------------------------------------------------------
        // KASUS 4: Pertanyaan Pupuk Secara Umum / Daun Kuning
        // -------------------------------------------------------------
        elseif (str_contains($q, 'pupuk') || str_contains($q, 'nutrisi') || str_contains($q, 'subur') || str_contains($q, 'kuning')) {
            $jawaban = "Halo Sahabat Tani! 🌿 Nutrisi yang tepat adalah kunci tanaman sehat dan panen berlimpah:\n\n"
                . "1. Untuk Daun Menguning: Daun bawah menguning pucat menandakan tanaman kekurangan Nitrogen (N). Berikan pupuk organik hayati atau kompos matang.\n"
                . "2. Untuk Bunga Rontok / Tidak Mau Berbuah: Tanaman kekurangan Kalium (K) dan Fosfor (P). Kurangi pupuk nitrogen dan tingkatkan kalium.\n"
                . "3. Kiat Pemupukan Aman: Berikan pupuk di pagi hari saat tanah lembap. Jangan menabur pupuk kimia langsung mengenai batang pokok tanaman.";

            $rekomendasi = $products->filter(fn($p) => str_contains(strtolower($p->name), 'pupuk') || str_contains(strtolower($p->name), 'media'));
        }

        // -------------------------------------------------------------
        // KASUS 5: Masalah Hama (Kutu Daun, Keriting, Ulat, Jamur)
        // -------------------------------------------------------------
        elseif (str_contains($q, 'hama') || str_contains($q, 'kutu') || str_contains($q, 'keriting') || str_contains($q, 'ulat') || str_contains($q, 'semut') || str_contains($q, 'jamur') || str_contains($q, 'bercak')) {
            $jawaban = "Halo Sahabat Tani! 🐛 Solusi pengendalian hama dan penyakit daun:\n\n"
                . "1. Daun Keriting & Kutu Kebul / Thrips: Hama bersembunyi di balik daun menghisap cairan. Semprotkan larutan sabun cuci piring (1 sdt per liter air) atau ekstrak daun mimba/bawang putih di sore hari.\n"
                . "2. Jamur & Bercak Daun Cokelat: Pangkas daun yang terinfeksi berat dan buang jauh dari tanaman. Hindari menyiram tanaman pada bagian daun di malam hari.\n"
                . "3. Ulat Pemakan Daun: Lakukan pembersihan manual di pagi hari dan jaga kebersihan gulma di sekitar pot.";

            $rekomendasi = $products->filter(fn($p) => str_contains(strtolower($p->name), 'pupuk') || str_contains(strtolower($p->name), 'media'));
        }

        // -------------------------------------------------------------
        // KASUS 6: Pertanyaan Out-of-Domain: Universitas Udayana / Kampus / Lokasi
        // -------------------------------------------------------------
        elseif (str_contains($q, 'udayana') || str_contains($q, 'unud')) {
            $jawaban = "Halo! 🎓 **Universitas Udayana (UNUD)** adalah perguruan tinggi negeri tertua di Provinsi **Bali, Indonesia**.\n\n"
                . "📍 Kampus Universitas Udayana berlokasi di:\n"
                . "1. Kampus Utama Bukit Jimbaran: Jl. Raya Kampus UNUD, Jimbaran, Kec. Kuta Selatan, Kabupaten Badung, Bali.\n"
                . "2. Kampus Sudirman: Jl. P.B. Sudirman, Dangin Puri, Kec. Denpasar Barat, Kota Denpasar, Bali.\n\n"
                . "🌱 *Catatan dari TaniAI:* Sebagai asisten cerdas TaniMart, saya juga siap membantu Anda seputar budidaya tanaman, benih unggul, pupuk, dan marketplace TaniMart. Jika ada hal seputar kebun yang ingin ditanyakan, silakan ya!";
            $rekomendasi = collect();
        }

        // -------------------------------------------------------------
        // KASUS 7: Cara Menjual Produk di TaniMart
        // -------------------------------------------------------------
        elseif (str_contains($q, 'cara jual') || str_contains($q, 'jual produk') || str_contains($q, 'jual barang') || str_contains($q, 'buka toko') || str_contains($q, 'jualan')) {
            $jawaban = "Halo Sahabat Tani! 🌾 Menjual hasil kebun atau perlengkapan tani di TaniMart sangat mudah:\n\n"
                . "1. Masuk (Login) ke akun TaniMart Anda (atau daftar jika belum punya).\n"
                . "2. Klik menu **'➕ Jual Produk'** di bar navigasi atas.\n"
                . "3. Isi formulir produk: Nama barang, kategori (Bibit, Pupuk, Media Tanam, Hasil Panen, dll), harga per satuan (kg/pack/pcs), stok, dan kota Anda.\n"
                . "4. Unggah foto produk atau pilih ikon emoji yang cocok, lalu klik Simpan.\n"
                . "5. Produk Anda langsung aktif di pasar dan dapat dikelola statusnya di menu **'📦 Produk Saya'**!";
            $rekomendasi = collect();
        }

        // -------------------------------------------------------------
        // KASUS 8: Apa itu TaniMart / Cara Belanja
        // -------------------------------------------------------------
        elseif (str_contains($q, 'apa itu tanimart') || str_contains($q, 'tentang tanimart') || str_contains($q, 'cara beli') || str_contains($q, 'cara belanja')) {
            $jawaban = "Halo! 🌱 **TaniMart** adalah platform marketplace pertanian modern di Indonesia yang menghubungkan petani, penghobi kebun, dan pembeli secara langsung.\n\n"
                . "Keunggulan TaniMart:\n"
                . "• Belanja Kebutuhan Tani: Benih sayur, pupuk hayati, media tanam siap pakai, pot terracotta, dan alat berkebun.\n"
                . "• Dukungan Petani Lokal: Pengguna bisa mendaftar dan langsung menjual hasil panennya sendiri.\n"
                . "• Asisten AI TaniAI: Konsultasi gratis seputar perawatan tanaman dan rekomendasi produk yang tepat.\n\n"
                . "Untuk berbelanja, cukup klik tombol '+' pada produk di Beranda untuk memasukkan ke keranjang, lalu lanjut ke menu Checkout!";
            $rekomendasi = $products->take(2);
        }

        // -------------------------------------------------------------
        // KASUS 9: Media Tanam & Pot
        // -------------------------------------------------------------
        elseif (str_contains($q, 'media') || str_contains($q, 'tanah') || str_contains($q, 'pot') || str_contains($q, 'drainase')) {
            $jawaban = "Halo Sahabat Tani! 🪴 Kunci tanaman sehat berakar kuat ada pada media tanam yang gembur:\n\n"
                . "1. Formula Media Tanam Gembur: Campurkan tanah subur gembur, sekam bakar/mentah, dan pupuk kandang/kompos matang (rasio 1:1:1).\n"
                . "2. Lubang Drainase Pot: Pastikan pot memiliki lubang air yang cukup di bagian dasar agar kelebihan air dapat mengalir lancar dan mencegah busuk akar.\n"
                . "3. Pot Terracotta: Pot berbahan tanah liat sangat direkomendasikan karena memiliki pori-pori alami yang menjaga suhu akar tetap sejuk.";

            $rekomendasi = $products->filter(fn($p) => str_contains(strtolower($p->name), 'media') || str_contains(strtolower($p->name), 'pot'));
        }

        // -------------------------------------------------------------
        // KASUS 10: Semai Benih & Bibit
        // -------------------------------------------------------------
        elseif (str_contains($q, 'semai') || str_contains($q, 'bibit') || str_contains($q, 'benih') || str_contains($q, 'tunas')) {
            $jawaban = "Halo Sahabat Tani! 🌱 Tips menyemai benih agar cepat berkecambah dan tidak mudah mati:\n\n"
                . "1. Rendam Benih: Rendam benih dalam air hangat suam-suam kuku selama 2-3 jam sebelum ditanam untuk mempercepat masa bertunas.\n"
                . "2. Media Semai Halus: Gunakan media tanam yang halus dan gembur (misal campuran cocopeat dan kompos halus).\n"
                . "3. Kelembapan Stabil: Semprot air halus (spray) setiap pagi. Tempatkan di tempat teduh sampai kecambah muncul, lalu segera kenalkan ke sinar matahari pagi agar batang tidak kurus.";

            $rekomendasi = $products->filter(fn($p) => str_contains(strtolower($p->name), 'bibit') || str_contains(strtolower($p->name), 'media'));
        }

        // -------------------------------------------------------------
        // KASUS 11: Salam / Sapaan
        // -------------------------------------------------------------
        elseif (str_contains($q, 'halo') || str_contains($q, 'hai') || str_contains($q, 'pagi') || str_contains($q, 'siang') || str_contains($q, 'malam') || str_contains($q, 'assalamualaikum')) {
            $jawaban = "Halo Sahabat Tani! 🌱 Senang sekali bisa membantu Anda hari ini.\n\n"
                . "Saya adalah **TaniAI**, konsultan tanaman pintar dari TaniMart. Anda bisa berkonsultasi seputar:\n"
                . "• Masalah tanaman layu, daun kuning, atau buah busuk\n"
                . "• Rekomendasi pupuk yang tepat untuk tanaman Anda\n"
                . "• Tips meracik media tanam dan menyemai benih\n"
                . "• Produk pertanian yang tersedia di pasar TaniMart\n\n"
                . "Apa yang sedang terjadi dengan tanaman Anda di rumah?";
            $rekomendasi = $products->take(2);
        }

        // -------------------------------------------------------------
        // KASUS 12: Pertanyaan Umum Lainnya
        // -------------------------------------------------------------
        else {
            $jawaban = "Halo Sahabat Tani! 🌱 Menanggapi pertanyaan Anda:\n\n"
                . "Dalam merawat tanaman di iklim tropis, terdapat 3 faktor utama yang perlu diperhatikan:\n"
                . "1. Kebutuhan Cahaya: Pastikan tanaman mendapatkan sinar matahari pagi minimal 4-6 jam sehari.\n"
                . "2. Pengaturan Siram: Siram saat permukaan tanah terasa mulai mengering. Siram di pangkal tanah, bukan pada daun atau bunga.\n"
                . "3. Nutrisi Berkelanjutan: Berikan nutrisi organik cair atau kompos secara rutin setiap 1-2 minggu sekali.\n\n"
                . "Jika ada gejala spesifik pada tanaman Anda (misal daun menguning, ada bintik putih, buah busuk, atau batang layu), ceritakan lebih rinci ya agar saya bisa mendiagnosisnya lebih akurat!";
            $rekomendasi = $products->take(2);
        }

        // Tambahkan rekomendasi produk yang relevan dari database TaniMart jika ada
        if ($rekomendasi->isNotEmpty()) {
            $jawaban .= "\n\n🛒 Rekomendasi produk di pasar TaniMart yang relevan:\n";
            foreach ($rekomendasi->take(2) as $item) {
                $jawaban .= "• {$item->name} (Rp" . number_format($item->price, 0, ',', '.') . "/{$item->unit})\n";
            }
            $jawaban .= "Anda bisa langsung menambahkannya ke keranjang di Beranda TaniMart!";
        }

        return $jawaban;
    }

    /**
     * Reset riwayat percakapan
     */
    public function reset()
    {
        session()->forget('taniai_riwayat');

        return redirect()->route('konsultasi');
    }
}
