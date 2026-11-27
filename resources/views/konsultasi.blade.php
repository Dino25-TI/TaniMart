
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaniAI | Konsultasi Pertanian TaniMart</title>
    <meta name="description" content="Konsultasi perawatan tanaman, hama, pupuk, dan budidaya bersama TaniAI.">
    <meta name="theme-color" content="#04442c">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* DESAIN TANIAI — KHUSUS HALAMAN KONSULTASI */

        body.taniai-stitch {
            margin: 0;
            background: #effdf1;
            color: #1a3325;
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            overflow-x: hidden;
        }

        .taniai-stitch *,
        .taniai-stitch *::before,
        .taniai-stitch *::after {
            box-sizing: border-box;
        }

        /* NAVBAR — TETAP NAVBAR LARAVEL ASLI */

        .taniai-stitch .tm-navbar-wrapper {
            background: #effdf1 !important;
            box-shadow: 0 2px 12px #04442c08;
        }

        .taniai-stitch .tm-navbar {
            max-width: 1490px;
            min-height: 68px;
            padding: 9px 18px;
            gap: 12px;
        }

        .taniai-stitch .tm-nav-link {
            font-size: 12px;
            white-space: nowrap;
        }

        .taniai-stitch .tm-nav-main .tm-nav-link {
            padding: 8px 9px;
        }

        .taniai-stitch .tm-nav-sell {
            font-size: 12px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .taniai-stitch .tm-user-name {
            font-size: 12px;
        }

        /* LAYOUT TIGA KOLOM */

        .ai-layout {
            max-width: 1500px;
            margin: 0 auto;
            padding: 24px;

            display: grid;
            grid-template-columns: 248px minmax(0, 1fr) 248px;
            gap: 22px;
            align-items: start;
        }

        .ai-panel {
            background: #fff;
            border: 1px solid #e4eee7;
            border-radius: 19px;
            box-shadow: 0 5px 22px #03422b08;
        }

        /* SIDEBAR KIRI */

        .ai-side {
            background: #e9f7ec;
            border-radius: 20px;
            padding: 17px;
            min-height: 615px;

            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .ai-brand {
            display: flex;
            gap: 11px;
            align-items: center;
            padding: 3px;
        }

        .ai-logo {
            width: 43px;
            height: 43px;
            background: #245c42;
            color: #fff;
            border-radius: 13px;

            display: flex;
            align-items: center;
            justify-content: center;
            flex: none;
            font-size: 20px;
        }

        .ai-brand strong {
            font-size: 18px;
            color: #064b33;
            display: block;
        }

        .ai-brand small {
            display: block;
            color: #637b6a;
            font-size: 10px;
            line-height: 1.5;
        }

        .ai-primary {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;

            background: #245c42;
            color: #fff;
            border: 0;
            border-radius: 999px;
            padding: 12px 16px;

            text-decoration: none;
            font-family: inherit;
            font-weight: 800;
            font-size: 12px;
            cursor: pointer;
        }

        .ai-primary:hover {
            background: #04442c;
            color: #fff;
        }

        .ai-side-search {
            display: flex;
            align-items: center;
            gap: 9px;

            background: #fff;
            border-radius: 999px;
            padding: 11px 13px;
            border: 1px solid #e0ece3;
        }

        .ai-side-search input {
            border: 0;
            background: transparent;
            outline: 0;
            width: 100%;
            min-width: 0;
            font: inherit;
            font-size: 11px;
        }

        .ai-group-label {
            color: #718478;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .7px;
            margin: 12px 6px 6px;
        }

        .ai-history-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 11px;

            border-radius: 11px;
            color: #385343;
            text-decoration: none;
            font-size: 11px;
            line-height: 1.5;
            min-width: 0;
        }

        .ai-history-item:hover {
            background: #dceee1;
            color: #164b31;
        }

        .ai-history-item.active {
            background: #245c42;
            color: #fff;
        }

        .ai-history-item span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .ai-history-list {
            max-height: 390px;
            overflow-y: auto;
            scrollbar-width: thin;
        }

        .ai-side-bottom {
            margin-top: auto;
            display: grid;
            gap: 10px;
        }

        .ai-back {
            display: flex;
            justify-content: space-between;
            align-items: center;

            background: #d0ebd0;
            color: #29533b;
            padding: 12px;
            border-radius: 11px;
            text-decoration: none;
            font-weight: 700;
            font-size: 11px;
        }

        .ai-account {
            display: flex;
            align-items: center;
            gap: 10px;

            background: white;
            border-radius: 13px;
            padding: 10px;
            font-size: 11px;
            color: #36513f;
        }

        .ai-account i {
            width: 31px;
            height: 31px;
            border-radius: 50%;
            background: #04442c;
            color: #fff;
            display: grid;
            place-items: center;
        }

        /* AREA UTAMA */

        .ai-main {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 17px;
        }

        .ai-header {
            padding: 17px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .ai-ident {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ai-ident strong {
            display: block;
            font-size: 18px;
            color: #183b29;
        }

        .ai-ident small {
            font-size: 11px;
            color: #728477;
        }

        .ai-chip {
            background: #d6efd1;
            color: #315942;
            font-size: 10px;
            font-weight: 800;
            border-radius: 99px;
            padding: 4px 9px;
            margin-left: 7px;
        }

        .ai-light-button {
            padding: 11px 16px;
            border-radius: 999px;
            background: #d5ecd1;
            color: #2e5b3d;
            font-family: inherit;
            font-size: 11px;
            font-weight: 800;
            border: 0;
            cursor: pointer;
        }

        .ai-light-button:hover {
            background: #c2e4c2;
        }

        /* HALAMAN SAMBUTAN */

        .ai-intro {
            padding: 24px;
            background:
                radial-gradient(
                    circle at 92% 5%,
                    #dcf8e6,
                    transparent 38%
                ),
                #fff;
        }

        .ai-eyebrow {
            font-size: 10px;
            color: #2c6d4a;
            font-weight: 800;
            letter-spacing: .7px;
        }

        .ai-intro h1 {
            font-size: clamp(21px, 2.2vw, 29px);
            line-height: 1.32;
            margin: 9px 0;
            color: #193a28;
            letter-spacing: -.5px;
        }

        .ai-intro p {
            font-size: 12px;
            line-height: 1.8;
            color: #637668;
            margin: 0 0 18px;
        }

        .ai-suggestions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 11px;
        }

        .ai-suggestion {
            background: #e9f7ed;
            border: 0;
            border-radius: 14px;
            padding: 14px;

            display: flex;
            align-items: flex-start;
            gap: 11px;

            cursor: pointer;
            text-align: left;
            color: #244231;
            font-family: inherit;
        }

        .ai-suggestion:hover {
            background: #d9f1e0;
        }

        .ai-suggestion i {
            width: 35px;
            height: 35px;
            display: grid;
            place-items: center;

            background: #d1ebd5;
            border-radius: 11px;
            color: #20573b;
            flex: none;
        }

        .ai-suggestion strong {
            display: block;
            font-size: 11px;
            margin: 1px 0 5px;
        }

        .ai-suggestion small {
            display: block;
            color: #667b6d;
            font-size: 10px;
            line-height: 1.55;
        }

        /* PESAN CHAT */

        .ai-stream {
            min-height: 175px;
            max-height: 55vh;
            overflow-y: auto;

            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 6px 0;
            scrollbar-width: thin;
        }

        .ai-bubble-user {
            align-self: flex-end;
            max-width: min(87%, 620px);

            border-radius: 17px 17px 5px 17px;
            background: #245c42;
            color: #fff;
            padding: 15px 18px;

            font-size: 12px;
            line-height: 1.85;
            overflow-wrap: anywhere;
        }

        .ai-bubble-bot {
            align-self: flex-start;
            max-width: 100%;
            padding: 18px 20px;

            border-radius: 17px;
            background: #fff;
            border: 1px solid #e6f0e8;
            box-shadow: 0 4px 18px #04442c08;
        }

        .ai-message-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 12px;
        }

        .ai-message-name {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            font-weight: 800;
        }

        .ai-message-name i {
            color: #245c42;
            font-size: 18px;
        }

        .ai-copy {
            background: transparent;
            border: 0;
            color: #687c6f;
            cursor: pointer;
            border-radius: 9px;
            padding: 5px 8px;
        }

        .ai-copy:hover {
            background: #e9f7ed;
        }

        .ai-bot-content {
            white-space: pre-wrap;
            overflow-wrap: anywhere;

            color: #334e3c;
            font-size: 12px;
            line-height: 1.95;
        }

        /* INPUT PESAN */

        .ai-composer {
            padding: 16px;
        }

        .ai-composer textarea {
            width: 100%;
            min-height: 72px;
            border: 0;
            resize: vertical;
            outline: 0;

            font: inherit;
            font-size: 12px;
            color: #233c2c;
            background: transparent;
        }

        .ai-composer textarea::placeholder {
            color: #809185;
        }

        .ai-compose-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .ai-compose-bottom small {
            color: #8a9c90;
            font-size: 10px;
        }

        .ai-send {
            border: 0;
            border-radius: 999px;
            padding: 11px 19px;

            background: #245c42;
            color: #fff;
            font: inherit;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
        }

        .ai-send:disabled {
            opacity: .6;
            cursor: wait;
        }

        .ai-disclaimer {
            margin: 0;
            text-align: center;
            color: #819286;
            font-size: 10px;
            line-height: 1.6;
        }

        .ai-alert {
            border-radius: 12px;
            padding: 11px 13px;
            background: #fff0ed;
            color: #aa3020;
            margin-bottom: 10px;
            font-size: 12px;
        }

        .ai-empty-message {
            text-align: center;
            margin: 0;
            padding: 10px;
            color: #758d7c;
            font-size: 12px;
        }

        /* SIDEBAR KANAN */

        .ai-aside-right {
            display: grid;
            gap: 15px;
        }

        .ai-info-card {
            padding: 18px;
        }

        .ai-info-card h3 {
            font-size: 12px;
            color: #244331;
            margin: 0 0 10px;

            display: flex;
            gap: 7px;
            align-items: center;
        }

        .ai-info-card p {
            font-size: 11px;
            color: #67796b;
            line-height: 1.8;
            margin: 0;
        }

        .ai-topics {
            display: flex;
            gap: 7px;
            flex-wrap: wrap;
        }

        .ai-topic {
            border: 0;
            border-radius: 999px;
            padding: 7px 11px;

            background: #e3f1e5;
            color: #44654c;
            font: inherit;
            font-size: 10px;
            cursor: pointer;
        }

        .ai-topic:hover {
            background: #cee8d0;
        }

        .ai-market-card {
            background: #245c42;
            color: #fff;
            border-radius: 19px;
            padding: 17px;
        }

        .ai-market-photo {
            height: 115px;
            border-radius: 12px;
            background: #16452f url(
                'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=700&q=75'
            ) center/cover;
        }

        .ai-market-card h3 {
            font-size: 11px;
            margin: 16px 0 7px;
            color: #d6ecdc;
        }

        .ai-market-card p {
            font-size: 11px;
            line-height: 1.7;
            margin: 0 0 16px;
        }

        .ai-market-card a {
            display: block;
            text-align: center;
            background: #fff;
            color: #245c42;

            border-radius: 999px;
            text-decoration: none;
            padding: 11px;
            font-size: 11px;
            font-weight: 800;
        }

        .ai-delete-form {
            margin-top: 7px;
        }

        .ai-delete-btn {
            color: #9b4a39;
            background: transparent;
            border: 0;
            font: inherit;
            font-size: 10px;
            cursor: pointer;
            padding: 6px;
        }

        /* FOOTER */

        .ai-footer {
            max-width: 1500px;
            margin: 0 auto 30px;
            padding: 0 25px;

            display: flex;
            justify-content: space-between;
            gap: 15px;
            color: #78897d;
            font-size: 10px;
        }

        /* RESPONSIVE */

        @media (max-width: 1250px) {
            .ai-layout {
                grid-template-columns: 210px minmax(0, 1fr);
            }

            .ai-aside-right {
                display: none;
            }
        }

        @media (max-width: 850px) {
            .ai-layout {
                display: flex;
                flex-direction: column;
                padding: 14px;
                gap: 13px;
            }

            .ai-side {
                min-height: auto;
                width: 100%;
            }

            .ai-history-list {
                max-height: 185px;
            }

            .ai-main {
                width: 100%;
            }

            .ai-intro {
                padding: 18px;
            }

            .ai-bubble-bot {
                max-width: 100%;
            }

            .ai-footer {
                padding: 0 16px;
            }
        }

        @media (max-width: 540px) {
            .ai-header {
                padding: 13px;
            }

            .ai-ident strong {
                font-size: 15px;
            }

            .ai-suggestions {
                grid-template-columns: 1fr;
            }

            .ai-intro h1 {
                font-size: 21px;
            }

            .ai-chip {
                display: none;
            }

            .ai-composer {
                padding: 12px;
            }

            .ai-bubble-user {
                max-width: 95%;
            }

            .ai-footer {
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body class="taniai-stitch">

@include('partials.navbar')

<div class="ai-layout">

    <!-- SIDEBAR KIRI: RIWAYAT DARI DATABASE -->
    <aside class="ai-side" aria-label="Riwayat konsultasi">

        <div class="ai-brand">
            <span class="ai-logo">
                <i class="fa-solid fa-leaf"></i>
            </span>

            <div>
                <strong>TaniAI</strong>
                <small>Asisten Pertanian Digital</small>
            </div>
        </div>

        <!-- KONSULTASI BARU -->
        <form action="{{ route('konsultasi.reset') }}" method="POST">
            @csrf

            <button type="submit"
                    class="ai-primary"
                    style="width:100%">
                <i class="fa-solid fa-plus"></i>
                Konsultasi Baru
            </button>
        </form>

        @auth

            <!-- CARI RIWAYAT -->
            <form action="{{ route('konsultasi') }}"
                  method="GET"
                  class="ai-side-search">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="search"
                    name="cari"
                    value="{{ $pencarian }}"
                    placeholder="Cari riwayat konsultasi..."
                    maxlength="100"
                    aria-label="Cari riwayat"
                >
            </form>

            <!-- RIWAYAT PERCAKAPAN -->
            <div class="ai-history-list">

                @php
                    $nowLocal = now('Asia/Makassar');

                    $sections = [
                        'Hari Ini' => [],
                        'Kemarin' => [],
                        'Sebelumnya' => [],
                    ];

                    foreach ($daftarPercakapan as $chat) {
                        $day = $chat->updated_at
                            ->copy()
                            ->timezone('Asia/Makassar');

                        $group = $day->isSameDay($nowLocal)
                            ? 'Hari Ini'
                            : (
                                $day->isSameDay(
                                    $nowLocal->copy()->subDay()
                                )
                                ? 'Kemarin'
                                : 'Sebelumnya'
                            );

                        $sections[$group][] = $chat;
                    }
                @endphp

                @foreach($sections as $group => $conversations)

                    @if(count($conversations))

                        <div class="ai-group-label">
                            {{ $group }}
                        </div>

                        @foreach($conversations as $chat)

                            <a
                                class="ai-history-item {{ optional($percakapanAktif)->id === $chat->id ? 'active' : '' }}"
                                href="{{ route('konsultasi', ['percakapan' => $chat->id]) }}"
                                title="{{ $chat->title }}"
                            >
                                <i class="fa-regular fa-message"></i>
                                <span>{{ $chat->title }}</span>
                            </a>

                        @endforeach

                    @endif

                @endforeach

                @if($daftarPercakapan->isEmpty())
                    <p class="ai-empty-message">
                        {{
                            $pencarian !== ''
                                ? 'Riwayat tidak ditemukan.'
                                : 'Belum ada riwayat. Mulai konsultasi pertamamu!'
                        }}
                    </p>
                @endif

            </div>

            <!-- HAPUS PERCAKAPAN TERPILIH -->
            @if($percakapanAktif)

                <form
                    class="ai-delete-form"
                    method="POST"
                    action="{{ route('konsultasi.riwayat.hapus', ['conversation' => $percakapanAktif->id]) }}"
                    onsubmit="return confirm('Hapus percakapan ini beserta semua pesannya?');"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="ai-delete-btn">
                        <i class="fa-solid fa-trash"></i>
                        Hapus percakapan ini
                    </button>
                </form>

            @endif

        @else

            <p style="color:#617a68;font-size:12px;line-height:1.8">
                <a href="{{ route('login') }}"
                   style="font-weight:800;color:#245c42">
                    Masuk
                </a>
                untuk menyimpan, mencari, dan membuka kembali
                riwayat konsultasimu. Kamu tetap bisa bertanya
                tanpa login.
            </p>

        @endauth

        <!-- AREA BAWAH SIDEBAR -->
        <div class="ai-side-bottom">

            <a class="ai-back" href="{{ url('/') }}">
                <span>
                    <i class="fa-solid fa-store"></i>
                    Kembali ke TaniMart
                </span>

                <i class="fa-solid fa-arrow-right"></i>
            </a>

            <div class="ai-account">
                <i class="fa-solid fa-user"></i>
                <span>
                    {{ auth()->user()->name ?? 'Pengunjung TaniMart' }}
                </span>
            </div>

        </div>

    </aside>


    <!-- AREA UTAMA KONSULTASI -->
    <main class="ai-main">

        <!-- HEADER CHAT -->
        <div class="ai-panel ai-header">

            <div class="ai-ident">

                <span class="ai-logo">
                    <i class="fa-solid fa-leaf"></i>
                </span>

                <div>
                    <strong>
                        TaniAI
                        <span class="ai-chip">
                            Asisten Pertanian
                        </span>
                    </strong>

                    <small>
                        Konsultasi budidaya, hama, pupuk, dan tanaman
                    </small>
                </div>

            </div>

            <form action="{{ route('konsultasi.reset') }}"
                  method="POST">
                @csrf

                <button type="submit" class="ai-light-button">
                    <i class="fa-solid fa-plus"></i>
                    Konsultasi Baru
                </button>
            </form>

        </div>


        <!-- SAMBUTAN SAAT BELUM ADA PESAN -->
        @if(empty($riwayat))

            <div class="ai-panel ai-intro">

                <span class="ai-eyebrow">
                    KONSULTASI CERDAS AGRO AI
                </span>

                <h1>
                    Halo! Siap Membantu Kebunmu
                    Tumbuh Lebih Baik?
                </h1>

                <p>
                    Tanyakan tentang tanaman, hama, penyakit,
                    pupuk, dan perawatan kebun.
                    Mulailah dari salah satu topik berikut.
                </p>

                <div class="ai-suggestions">

                    <button
                        type="button"
                        class="ai-suggestion"
                        data-prompt="Daun cabai saya mulai menguning. Apa kemungkinan penyebabnya?"
                    >
                        <i class="fa-solid fa-leaf"></i>

                        <span>
                            <strong>
                                Identifikasi Masalah Tanaman
                            </strong>

                            <small>
                                Ceritakan gejala yang kamu
                                temukan pada tanaman.
                            </small>
                        </span>
                    </button>

                    <button
                        type="button"
                        class="ai-suggestion"
                        data-prompt="Apa penyebab hama kutu daun pada cabai dan bagaimana mengendalikannya?"
                    >
                        <i class="fa-solid fa-bug"></i>

                        <span>
                            <strong>Hama dan Penyakit</strong>
                            <small>
                                Pelajari gangguan tanaman
                                dan cara menanganinya.
                            </small>
                        </span>
                    </button>

                    <button
                        type="button"
                        class="ai-suggestion"
                        data-prompt="Pupuk dan nutrisi apa yang sesuai untuk pertumbuhan tanaman tomat?"
                    >
                        <i class="fa-solid fa-flask"></i>

                        <span>
                            <strong>Pupuk dan Nutrisi</strong>
                            <small>
                                Kenali kebutuhan nutrisi tanamanmu.
                            </small>
                        </span>
                    </button>

                    <button
                        type="button"
                        class="ai-suggestion"
                        data-prompt="Apa saja produk pertanian yang cocok untuk menanam cabai di TaniMart?"
                    >
                        <i class="fa-solid fa-basket-shopping"></i>

                        <span>
                            <strong>Rekomendasi Produk</strong>
                            <small>
                                Cari kebutuhan pertanian yang relevan.
                            </small>
                        </span>
                    </button>

                </div>
            </div>

        @endif


        <!-- PESAN PENGGUNA DAN JAWABAN AI -->
        <div
            class="ai-stream"
            id="chatMessages"
            role="log"
            aria-label="Isi percakapan"
            aria-live="polite"
        >

            @foreach($riwayat as $pesan)

                @if($pesan['role'] === 'user')

                    <article class="ai-bubble-user">
                        {{ $pesan['content'] }}
                    </article>

                @else

                    <article class="ai-bubble-bot">

                        <div class="ai-message-top">

                            <div class="ai-message-name">
                                <i class="fa-solid fa-leaf"></i>
                                TaniAI
                            </div>

                            <button
                                type="button"
                                class="ai-copy"
                                title="Salin jawaban"
                                aria-label="Salin jawaban"
                            >
                                <i class="fa-regular fa-copy"></i>
                            </button>

                        </div>

                        <div class="ai-bot-content">{{ $pesan['content'] }}</div>

                    </article>

                @endif

            @endforeach

        </div>


        <!-- FORM KIRIM PESAN -->
        <form
            action="{{ route('konsultasi.tanya') }}"
            method="POST"
            id="chatForm"
            class="ai-panel ai-composer"
        >
            @csrf

            <!-- ID percakapan yang sedang dibuka -->
            <input
                type="hidden"
                name="conversation_id"
                value="{{ optional($percakapanAktif)->id }}"
            >

            @if($errors->any())
                <div class="ai-alert">
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('ai_error'))
                <div class="ai-alert">
                    {{ session('ai_error') }}
                </div>
            @endif

            @if(session('success'))
                <div style="padding:8px;color:#206c41;font-size:11px">
                    {{ session('success') }}
                </div>
            @endif

            <label
                for="pertanyaan"
                style="position:absolute;width:1px;height:1px;overflow:hidden;clip-path:inset(50%)"
            >
                Pertanyaan untuk TaniAI
            </label>

            <textarea
                name="pertanyaan"
                id="pertanyaan"
                rows="2"
                minlength="2"
                maxlength="1000"
                required
                placeholder="Tanyakan sesuatu tentang pertanian..."
            >{{ old('pertanyaan') }}</textarea>

            <div class="ai-compose-bottom">

                <small>
                    Enter untuk kirim · Shift+Enter baris baru
                </small>

                <button
                    class="ai-send"
                    type="submit"
                    id="sendButton"
                >
                    Kirim
                    <i class="fa-solid fa-paper-plane"></i>
                </button>

            </div>

            <small
                id="chatStatus"
                hidden
                style="color:#538564;font-size:11px"
            >
                🌱 TaniAI sedang menyiapkan jawaban...
            </small>

        </form>

        <p class="ai-disclaimer">
            Saran TaniAI adalah informasi awal,
            bukan diagnosis pasti kondisi tanaman.
        </p>

    </main>


    <!-- SIDEBAR KANAN: INFORMASI PERTANIAN -->
    <aside class="ai-aside-right"
           aria-label="Informasi pertanian">

        <div class="ai-panel ai-info-card">

            <h3>
                <i class="fa-regular fa-sun"></i>
                Tips Pertanian
            </h3>

            <p>
                Periksa kelembapan media tanam sebelum menyiram.
                Kebutuhan air setiap tanaman berbeda,
                tergantung jenis, cuaca, dan kondisi tanah.
            </p>

        </div>

        <div class="ai-panel ai-info-card">

            <h3>
                <i class="fa-solid fa-arrow-trend-up"></i>
                Topik Populer
            </h3>

            <div class="ai-topics">

                <button
                    type="button"
                    class="ai-topic"
                    data-prompt="Bagaimana cara merawat tanaman cabai yang baik?"
                >
                    Perawatan cabai
                </button>

                <button
                    type="button"
                    class="ai-topic"
                    data-prompt="Bagaimana mengatasi hama tanaman secara aman?"
                >
                    Hama tanaman
                </button>

                <button
                    type="button"
                    class="ai-topic"
                    data-prompt="Bagaimana menggunakan pupuk organik yang benar?"
                >
                    Pupuk organik
                </button>

                <button
                    type="button"
                    class="ai-topic"
                    data-prompt="Bagaimana membuat media tanam untuk pot yang sehat?"
                >
                    Media tanam
                </button>

            </div>

        </div>

        <div class="ai-market-card">

            <div
                class="ai-market-photo"
                role="img"
                aria-label="Aneka hasil pertanian segar"
            ></div>

            <h3>TANIMART MARKETPLACE</h3>

            <p>
                Temukan berbagai kebutuhan pertanianmu
                di TaniMart.
            </p>

            <a href="{{ url('/#produk') }}">
                Jelajahi Produk
                <i class="fa-solid fa-arrow-right"></i>
            </a>

        </div>

    </aside>

</div>


<!-- FOOTER -->
<footer class="ai-footer">
    <span>
        © {{ now()->year }} TaniMart Indonesia
    </span>

    <span>
        Konsultasi untuk membantu perawatan
        tanaman dengan lebih mudah.
    </span>
</footer>


<!-- JAVASCRIPT CHAT -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('chatForm');
    const textarea = document.getElementById('pertanyaan');
    const button = document.getElementById('sendButton');
    const status = document.getElementById('chatStatus');
    const messages = document.getElementById('chatMessages');

    let sending = false;

    // Tampilkan pesan terbaru saat membuka riwayat
    function scrollToLatest() {
        if (messages) {
            messages.scrollTop = messages.scrollHeight;
        }
    }

    requestAnimationFrame(scrollToLatest);

    // Klik kartu saran => isi textarea
    document.querySelectorAll('[data-prompt]').forEach(function (item) {
        item.addEventListener('click', function () {
            textarea.value = item.getAttribute('data-prompt') || '';
            textarea.focus();
        });
    });

    // Salin jawaban AI
    document.querySelectorAll('.ai-copy').forEach(function (copyButton) {
        copyButton.addEventListener('click', function () {

            const text = copyButton
                .closest('.ai-bubble-bot')
                ?.querySelector('.ai-bot-content')
                ?.textContent || '';

            if (navigator.clipboard && text) {
                navigator.clipboard.writeText(text)
                    .then(function () {
                        copyButton.title = 'Tersalin';
                    })
                    .catch(function () {});
            }
        });
    });

    // Enter mengirim, Shift + Enter membuat baris baru
    textarea.addEventListener('keydown', function (event) {

        if (
            event.key === 'Enter' &&
            !event.shiftKey &&
            !event.isComposing
        ) {
            event.preventDefault();

            if (form.requestSubmit) {
                form.requestSubmit();
            } else {
                button.click();
            }
        }
    });

    // Mencegah pengiriman ganda
    form.addEventListener('submit', function (event) {

        if (sending) {
            event.preventDefault();
            return;
        }

        if (!textarea.value.trim()) {
            event.preventDefault();
            return;
        }

        sending = true;
        button.disabled = true;
        button.innerHTML = 'Mengirim...';
        status.hidden = false;
    });

    // Pulihkan tombol ketika browser kembali ke halaman
    window.addEventListener('pageshow', function () {

        sending = false;
        button.disabled = false;

        button.innerHTML =
            'Kirim <i class="fa-solid fa-paper-plane"></i>';

        status.hidden = true;
        scrollToLatest();
    });

});
</script>

</body>
</html>
