
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>TaniAI | Konsultasi Tanaman</title>

    <link rel="stylesheet"
          href="{{ asset('css/tanimart.css') }}">

    <link rel="stylesheet"
          href="{{ asset('css/taniai-chat.css') }}">
</head>
<body>

<nav>
    <a href="/" class="logo">🌱 TaniMart</a>

    <div class="nav-links">
        <a href="/">Beranda</a>
        <a href="/#produk">Produk</a>
        <a href="/konsultasi">Konsultasi AI</a>
        <a href="/keranjang">Keranjang</a>
    </div>
</nav>

<main class="section tm-chat-page">

    <header class="tm-chat-heading">
        <h1>🌱 Konsultasi dengan TaniAI</h1>
        <p>
            Asisten pertanian berbasis Gemini AI
            siap membantu masalah tanamanmu.
        </p>
    </header>

    <section class="tm-chat-shell">

        <!-- HEADER CHAT -->
        <div class="tm-chat-top">

            <div class="tm-chat-identity">
                <span class="tm-chat-avatar">🌱</span>

                <div>
                    <strong>TaniAI</strong>
                    <small>Asisten Tanaman</small>
                </div>
            </div>

            <form action="{{ route('konsultasi.reset') }}"
                  method="POST">
                @csrf

                <button type="submit"
                        class="tm-chat-reset">
                    + Chat Baru
                </button>
            </form>

        </div>

        <!-- RIWAYAT PESAN -->
        <div id="chatMessages"
             class="tm-chat-messages"
             role="log"
             aria-label="Riwayat percakapan">

            @forelse ($riwayat as $pesan)

                <article class="tm-chat-bubble {{ $pesan['role'] === 'user' ? 'tm-chat-user' : 'tm-chat-bot' }}">

                    <span class="tm-chat-name">
                        {{ $pesan['role'] === 'user' ? '👤 Kamu' : '🌱 TaniAI' }}
                    </span>

                    <div class="tm-chat-body">{{ $pesan['content'] }}</div>

                </article>

            @empty

                <div class="tm-chat-empty">
                    <div class="tm-chat-empty-icon">🌱</div>

                    <h2>Halo! Aku TaniAI</h2>

                    <p>
                        Ada masalah dengan tanamanmu?
                        Ceritakan di bawah, ya!
                    </p>

                    <span>
                        Contoh: Kenapa daun cabai saya menguning?
                    </span>
                </div>

            @endforelse

        </div>

        <!-- FORM CHAT DI BAGIAN BAWAH -->
        <form id="chatForm"
              class="tm-chat-form"
              action="{{ route('konsultasi.tanya') }}"
              method="POST">

            @csrf

            @if ($errors->any())
                <div class="tm-chat-error">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('ai_error'))
                <div class="tm-chat-error">
                    {{ session('ai_error') }}
                </div>
            @endif

            <label for="pertanyaan"
                   class="tm-visually-hidden">
                Pesan untuk TaniAI
            </label>

            <textarea
                id="pertanyaan"
                name="pertanyaan"
                class="tm-chat-input"
                rows="2"
                minlength="10"
                maxlength="1000"
                required
                placeholder="Tanyakan masalah tanamanmu..."
            >{{ old('pertanyaan') }}</textarea>

            <button type="submit"
                    id="sendButton"
                    class="tm-chat-send">
                ➤ Kirim
            </button>

            <small id="chatStatus"
                   class="tm-chat-status"
                   role="status"
                   hidden>
                🌱 TaniAI sedang menyiapkan jawaban...
            </small>

        </form>

    </section>

    <p class="tm-chat-disclaimer">
        Saran TaniAI adalah informasi awal,
        bukan diagnosis pasti kondisi tanaman.
    </p>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const messages = document.getElementById('chatMessages');
    const form = document.getElementById('chatForm');
    const textarea = document.getElementById('pertanyaan');
    const button = document.getElementById('sendButton');
    const status = document.getElementById('chatStatus');

    let sending = false;

    // Otomatis tampilkan pesan terbaru
    function scrollToLatest() {
        messages.scrollTop = messages.scrollHeight;
    }

    requestAnimationFrame(scrollToLatest);

    // Enter untuk kirim, Shift+Enter untuk baris baru
    textarea.addEventListener('keydown', function (event) {
        if (event.key === 'Enter'
            && !event.shiftKey
            && !event.isComposing) {

            event.preventDefault();
            form.requestSubmit();
        }
    });

    // Mencegah tombol diklik berkali-kali
    form.addEventListener('submit', function (event) {

        if (sending) {
            event.preventDefault();
            return;
        }

        sending = true;
        button.disabled = true;
        button.textContent = 'Mengirim...';
        status.hidden = false;
    });

    // Pulihkan tombol bila halaman kembali dari cache browser
    window.addEventListener('pageshow', function () {
        sending = false;
        button.disabled = false;
        button.textContent = '➤ Kirim';
        status.hidden = true;
        scrollToLatest();
    });

});
</script>

</body>
</html>
