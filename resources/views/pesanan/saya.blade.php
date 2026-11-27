
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya | TaniMart</title>
    <meta name="description" content="Pantau pesanan, pembayaran, pengiriman, pembatalan, dan ulasan produk di TaniMart.">
    <meta name="theme-color" content="#04442c">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/tanimart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ==================================================
           TANIMART — PESANAN SAYA STITCH REDESIGN
           Scoped khusus halaman pesanan pembeli
           ================================================== */

        body.tm-orders-stitch {
            --os-primary: #04442c;
            --os-primary-soft: #d9eddb;
            --os-bg: #effdf1;
            --os-card: #ffffff;
            --os-border: #dcebe0;
            --os-muted: #6b7d70;
            --os-text: #203629;

            margin: 0;
            background: var(--os-bg);
            color: var(--os-text);
            font-family: "Plus Jakarta Sans", Arial, sans-serif;
            overflow-x: hidden;
        }

        .tm-orders-stitch *,
        .tm-orders-stitch *::before,
        .tm-orders-stitch *::after {
            box-sizing: border-box;
        }

        .tm-orders-stitch button,
        .tm-orders-stitch input,
        .tm-orders-stitch select,
        .tm-orders-stitch textarea {
            font-family: inherit;
        }

        /* NAVBAR: IKUTI NAVBAR LARAVEL ASLI */

        .tm-orders-stitch .tm-navbar-wrapper {
            background: #effdf1 !important;
            border-bottom: 1px solid #dcebe0;
            box-shadow: 0 2px 12px rgba(0, 55, 30, .04);
        }

        .tm-orders-stitch .tm-navbar {
            max-width: 1510px;
        }

        .tm-orders-stitch .tm-nav-sell {
            background: var(--os-primary);
            color: #fff !important;
            border-radius: 999px;
        }

        /* CONTAINER */

        .os-container {
            width: min(94%, 1350px);
            margin: 0 auto;
            padding: 30px 0 80px;
        }

        .os-breadcrumb {
            display: flex;
            align-items: center;
            gap: 9px;
            flex-wrap: wrap;
            margin-bottom: 19px;
            color: #75897a;
            font-size: 11px;
        }

        .os-breadcrumb a {
            color: #5d7866;
            text-decoration: none;
        }

        .os-breadcrumb a:hover {
            color: var(--os-primary);
        }

        .os-page-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            padding-bottom: 29px;
            margin-bottom: 27px;
            border-bottom: 1px solid var(--os-border);
        }

        .os-heading-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .os-heading-icon {
            width: 55px;
            height: 55px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #d9eddb;
            color: var(--os-primary);
            border-radius: 50%;
            font-size: 23px;
        }

        .os-heading-left h1 {
            font-size: clamp(24px, 2.8vw, 35px);
            line-height: 1.3;
            letter-spacing: -1px;
            font-weight: 800;
            color: var(--os-primary);
            margin: 0 0 6px;
        }

        .os-heading-left p {
            max-width: 640px;
            color: var(--os-muted);
            font-size: 12px;
            line-height: 1.75;
            margin: 0;
        }

        .os-header-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 9px;
        }

        .os-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 39px;
            padding: 10px 15px;
            border: 1px solid transparent;
            border-radius: 999px;
            background: #e4f1e6;
            color: #315d40;
            font-size: 11px;
            font-weight: 800;
            line-height: 1.3;
            text-decoration: none;
            cursor: pointer;
            transition: .2s ease;
        }

        .os-btn:hover {
            transform: translateY(-2px);
            background: #d3e8d7;
            color: #204b33;
        }

        .os-btn-primary {
            background: var(--os-primary);
            color: #fff;
        }

        .os-btn-primary:hover {
            background: #126245;
            color: #fff;
        }

        .os-btn-danger {
            color: #aa4747;
            background: #fbebea;
        }

        .os-btn-danger:hover {
            color: #9f2525;
            background: #f8dddd;
        }

        .os-btn:disabled {
            opacity: .55;
            cursor: not-allowed;
            transform: none;
        }

        /* KPI STATISTIK */

        .os-kpis {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 26px;
        }

        .os-kpi {
            position: relative;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            min-width: 0;
            padding: 22px;
            border: 1px solid #e8f0e8;
            border-radius: 17px;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0, 50, 31, .035);
        }

        .os-kpi-label {
            color: #76867b;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .6px;
            text-transform: uppercase;
        }

        .os-kpi-number {
            display: block;
            margin: 8px 0 5px;
            color: #1e3929;
            font-size: clamp(25px, 3vw, 35px);
            font-weight: 800;
            line-height: 1;
        }

        .os-kpi-note {
            color: #829185;
            font-size: 10px;
            line-height: 1.6;
        }

        .os-kpi-icon {
            display: grid;
            place-items: center;
            flex: 0 0 43px;
            height: 43px;
            border-radius: 12px;
            background: #e0f0df;
            color: #24583b;
            font-size: 19px;
        }

        .os-kpi:nth-child(2) .os-kpi-icon {
            background: #ccf3dd;
        }

        .os-kpi:nth-child(3) .os-kpi-icon {
            background: #e7f4e5;
        }

        .os-kpi:nth-child(4) .os-kpi-icon {
            background: #ffe4e3;
            color: #b42331;
        }

        .os-kpi:nth-child(4) .os-kpi-number {
            color: #b42331;
        }

        /* TABS DAN FILTER */

        .os-toolbar {
            background: #fff;
            padding: 18px;
            border-radius: 19px;
            border: 1px solid #e9f0e9;
            margin-bottom: 27px;
            box-shadow: 0 4px 17px rgba(0, 50, 31, .035);
        }

        .os-tabs {
            display: flex;
            align-items: center;
            gap: 7px;
            overflow-x: auto;
            padding-bottom: 14px;
            border-bottom: 1px solid #e5eee6;
            scrollbar-width: thin;
        }

        .os-tab {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            flex-shrink: 0;
            padding: 10px 14px;
            background: #e7f3e8;
            color: #4d6655;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
        }

        .os-tab.active {
            color: #fff;
            background: var(--os-primary);
        }

        .os-tab:hover {
            background: #d4e9d8;
            color: #244d37;
        }

        .os-tab.active:hover {
            background: #126245;
            color: #fff;
        }

        .os-tab-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 21px;
            height: 21px;
            padding: 0 5px;
            font-size: 10px;
            font-weight: 800;
            border-radius: 999px;
            background: rgba(4, 68, 44, .10);
        }

        .os-tab.active .os-tab-count {
            background: rgba(255,255,255,.20);
        }

        .os-filters {
            display: grid;
            grid-template-columns: minmax(0, 1.6fr) 1fr 1fr auto;
            gap: 12px;
            padding-top: 16px;
        }

        .os-field {
            position: relative;
            min-width: 0;
        }

        .os-field > i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #678b75;
            font-size: 13px;
            pointer-events: none;
        }

        .os-field input,
        .os-field select {
            display: block;
            width: 100%;
            height: 43px;
            padding: 0 14px 0 38px;
            border: 1px solid #e0eee2;
            outline: none;
            border-radius: 11px;
            background: #eaf6ec;
            color: #34533f;
            font-size: 11px;
        }

        .os-field input:focus,
        .os-field select:focus {
            background: white;
            border-color: #8cb9a0;
        }

        .os-field input::placeholder {
            color: #819386;
        }

        .os-reset {
            width: 43px;
            height: 43px;
            border: 0;
            border-radius: 11px;
            background: #e8f4ea;
            color: #315f43;
            cursor: pointer;
        }

        .os-reset:hover {
            background: #d1e9d5;
        }

        /* CONTENT GRID */

        .os-content {
            display: grid;
            grid-template-columns: minmax(0, 1.75fr) minmax(280px, .85fr);
            align-items: start;
            gap: 24px;
        }

        .os-order-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
            min-width: 0;
        }

        /* ORDER CARD */

        .os-card {
            position: relative;
            overflow: hidden;
            background: white;
            border-radius: 18px;
            border: 1px solid #e5efe7;
            box-shadow: 0 5px 20px rgba(0, 51, 33, .045);
        }

        .os-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: #245c42;
        }

        .os-card[data-status="belum_bayar"]::before {
            background: #f0be60;
        }

        .os-card[data-status="dibatalkan"]::before {
            background: #cf4747;
        }

        .os-card[data-status="selesai"]::before {
            background: #4d8965;
        }

        .os-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 23px 23px 17px;
            border-bottom: 1px solid #ecf1ec;
        }

        .os-seller {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .os-seller-avatar {
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background: #dcefdc;
            color: #315e41;
            font-size: 12px;
            font-weight: 800;
        }

        .os-seller-name {
            color: #25382b;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.5;
        }

        .os-order-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            color: #839086;
            font-size: 10px;
            line-height: 1.7;
        }

        .os-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 11px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
            line-height: 1.4;
            white-space: normal;
        }

        .os-shipping {
            display: flex;
            gap: 11px;
            margin: 16px 23px 0;
            padding: 14px;
            border-radius: 12px;
            background: #e9f7eb;
            color: #2b6544;
        }

        .os-shipping > i {
            flex-shrink: 0;
            font-size: 17px;
            margin-top: 2px;
        }

        .os-shipping strong {
            font-size: 11px;
        }

        .os-shipping p {
            margin: 5px 0 0;
            color: #6b826f;
            font-size: 10px;
            line-height: 1.7;
        }

        .os-items {
            padding: 13px 23px;
        }

        .os-item {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
            padding: 12px 0;
            border-bottom: 1px solid #edf1ed;
        }

        .os-item:last-child {
            border-bottom: 0;
        }

        .os-thumb {
            width: 67px;
            height: 67px;
            flex: 0 0 67px;
            border-radius: 12px;
            background: #e7f3e9;
            display: grid;
            place-items: center;
            overflow: hidden;
            font-size: 30px;
        }

        .os-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .os-item-content {
            flex: 1;
            min-width: 0;
        }

        .os-item-name {
            display: block;
            color: #25392b;
            font-size: 12px;
            line-height: 1.55;
            font-weight: 800;
            text-decoration: none;
        }

        a.os-item-name:hover {
            color: #0e6a47;
        }

        .os-item-sub {
            margin-top: 4px;
            font-size: 10px;
            line-height: 1.6;
            color: #7c9080;
        }

        .os-item-price {
            flex-shrink: 0;
            min-width: 100px;
            text-align: right;
            color: #263a2c;
            font-size: 12px;
            font-weight: 800;
        }

        .os-item-price small {
            display: block;
            font-size: 10px;
            margin-top: 4px;
            color: #859688;
            font-weight: 500;
        }

        /* REVIEW */

        .os-review {
            margin-top: 10px;
            padding: 11px;
            border-radius: 10px;
            background: #fff8e9;
            color: #7d5b26;
            font-size: 11px;
            line-height: 1.7;
        }

        .os-stars {
            color: #dea62f;
            margin-bottom: 5px;
        }

        /* CARD FOOTER */

        .os-card-footer {
            padding: 18px 23px 22px;
            border-top: 1px solid #edf1ed;
        }

        .os-footer-top {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 12px;
        }

        .os-total-label {
            color: #89998c;
            font-size: 10px;
            margin-bottom: 4px;
        }

        .os-total {
            display: block;
            color: var(--os-primary);
            font-size: 21px;
            line-height: 1.4;
            font-weight: 800;
        }

        .os-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 8px;
        }

        .os-actions form {
            margin: 0;
        }

        .os-cancel-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 14px;
        }

        .os-cancel-row select {
            max-width: 230px;
            padding: 10px;
            border: 1px solid #dce9de;
            border-radius: 11px;
            background: #f3faf5;
            color: #345d43;
            font-size: 11px;
        }

        .os-notice {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
            padding: 10px 12px;
            border-radius: 11px;
            background: #fff5dc;
            color: #8e601e;
            font-size: 11px;
            line-height: 1.6;
        }

        .os-notice.danger {
            background: #fff0ee;
            color: #a64236;
        }

        .os-notice.info {
            background: #e9f3fb;
            color: #28618e;
        }

        /* SIDEBAR */

        .os-aside {
            position: sticky;
            top: 90px;
            display: flex;
            flex-direction: column;
            gap: 17px;
            min-width: 0;
        }

        .os-aside-card {
            padding: 22px;
            border: 1px solid #e5eee7;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 4px 16px rgba(0, 52, 33, .035);
        }

        .os-aside-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 18px;
        }

        .os-aside-title h2 {
            display: flex;
            gap: 9px;
            align-items: center;
            margin: 0;
            font-size: 15px;
            font-weight: 800;
            color: #233b2b;
        }

        .os-aside-title h2 i {
            color: #286549;
        }

        .os-aside-label {
            padding: 5px 9px;
            border-radius: 999px;
            background: #d8efdb;
            color: #2b6743;
            font-size: 9px;
            font-weight: 800;
        }

        .os-selected-order {
            padding: 15px;
            border-radius: 13px;
            background: #ebf7ed;
        }

        .os-selected-order small {
            display: block;
            margin-bottom: 5px;
            color: #73907d;
            font-size: 10px;
        }

        .os-selected-order strong {
            color: var(--os-primary);
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .os-selected-status {
            display: block;
            margin-top: 10px;
            color: #477357;
            font-size: 11px;
        }

        .os-tracking {
            position: relative;
            margin: 23px 0;
            padding-left: 27px;
        }

        .os-step {
            position: relative;
            padding: 0 0 25px;
            border-left: 2px solid #dde9df;
            padding-left: 19px;
        }

        .os-step:last-child {
            padding-bottom: 0;
            border-left-color: transparent;
        }

        .os-step::before {
            content: "";
            position: absolute;
            left: -7px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #d5e2d8;
            border: 2px solid #fff;
            box-shadow: 0 0 0 1px #cdddce;
        }

        .os-step.done::before {
            background: #176e49;
        }

        .os-step.current::before {
            background: #68b68e;
            box-shadow: 0 0 0 4px #e0f2e4;
        }

        .os-step strong {
            display: block;
            color: #344d3c;
            font-size: 11px;
            line-height: 1.5;
        }

        .os-step small {
            display: block;
            margin-top: 5px;
            color: #8a9a8d;
            font-size: 10px;
            line-height: 1.6;
        }

        .os-tracking-extra {
            padding-top: 14px;
            border-top: 1px solid #e9f0ea;
            color: #607b68;
            font-size: 11px;
            line-height: 1.9;
        }

        .os-summary-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            padding: 8px 0;
            color: #718576;
            font-size: 11px;
            line-height: 1.6;
        }

        .os-summary-row strong {
            color: #244533;
            text-align: right;
            font-weight: 800;
        }

        .os-summary-row.total {
            border-top: 1px solid #e2eee5;
            margin-top: 8px;
            padding-top: 16px;
            font-weight: 800;
        }

        .os-summary-row.total strong {
            color: #04442c;
            font-size: 17px;
        }

        /* EMPTY & EXTRA */

        .os-empty,
        .os-no-match {
            background: #fff;
            padding: 50px 22px;
            border: 1px solid #e1eee5;
            border-radius: 18px;
            text-align: center;
            color: #7a8f7e;
        }

        .os-empty-icon {
            display: block;
            margin-bottom: 15px;
            font-size: 49px;
        }

        .os-empty h3 {
            color: #24513a;
            margin-bottom: 12px;
            font-size: 19px;
        }

        .os-empty p {
            font-size: 12px;
            line-height: 1.8;
        }

        .os-cta {
            margin-top: 44px;
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            border-left: 4px solid #04442c;
            border-radius: 18px;
            background: #fff;
        }

        .os-cta h3 {
            margin: 0 0 8px;
            color: #244432;
            font-size: 15px;
        }

        .os-cta p {
            color: #819184;
            font-size: 11px;
            line-height: 1.7;
            margin: 0;
        }

        /* RATING MODAL */

        .rating-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 5000;
            align-items: center;
            justify-content: center;
            background: rgba(0, 28, 16, .58);
            padding: 18px;
        }

        .rating-modal-backdrop.show {
            display: flex;
        }

        .rating-modal-card {
            width: 100%;
            max-width: 480px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 27px;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 24px 50px rgba(0,0,0,.18);
        }

        .star-picker {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
            color: #d5ddd5;
            font-size: 27px;
        }

        .star-picker i {
            cursor: pointer;
        }

        .star-picker i.selected {
            color: #edb43f;
        }

        .rating-modal-card textarea {
            width: 100%;
            min-height: 105px;
            resize: vertical;
            padding: 12px;
            border: 1px solid #d6e5db;
            border-radius: 12px;
            font: inherit;
            font-size: 12px;
        }

        /* RESPONSIVE */

        @media (max-width: 1160px) {
            .os-content {
                grid-template-columns: minmax(0, 1fr) 300px;
                gap: 15px;
            }

            .os-kpi {
                padding: 17px;
            }

            .os-card-header,
            .os-items,
            .os-card-footer {
                padding-left: 17px;
                padding-right: 17px;
            }
        }

        @media (max-width: 940px) {
            .os-kpis {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .os-content {
                grid-template-columns: 1fr;
            }

            .os-aside {
                position: static;
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .os-filters {
                grid-template-columns: 1fr 1fr;
            }

            .os-filters .os-field:first-child {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 620px) {
            .os-container {
                width: 93%;
                padding-top: 20px;
            }

            .os-heading-left {
                align-items: flex-start;
            }

            .os-heading-icon {
                width: 43px;
                height: 43px;
                flex-basis: 43px;
                font-size: 18px;
            }

            .os-heading-left h1 {
                font-size: 25px;
            }

            .os-kpis {
                gap: 9px;
            }

            .os-kpi {
                padding: 14px;
            }

            .os-kpi-icon {
                flex-basis: 32px;
                height: 32px;
                font-size: 14px;
            }

            .os-kpi-label {
                font-size: 9px;
            }

            .os-kpi-number {
                font-size: 24px;
            }

            .os-toolbar {
                padding: 12px;
            }

            .os-filters {
                grid-template-columns: minmax(0, 1fr) auto;
            }

            .os-filters .os-field:first-child {
                grid-column: 1 / -1;
            }

            .os-filters .os-field:nth-child(2),
            .os-filters .os-field:nth-child(3) {
                grid-column: 1 / -1;
            }

            .os-aside {
                grid-template-columns: 1fr;
            }

            .os-item {
                align-items: flex-start;
                gap: 10px;
            }

            .os-thumb {
                width: 54px;
                height: 54px;
                flex-basis: 54px;
            }

            .os-item-price {
                min-width: 80px;
                font-size: 11px;
            }

            .os-footer-top {
                align-items: flex-start;
            }

            .os-actions {
                justify-content: flex-start;
            }
        }
    </style>
</head>

<body class="tm-orders-stitch">

@include('partials.navbar')

@php
    $totalPesanan = (int) ($counts['semua'] ?? 0);
    $jumlahDikemas = (int) ($counts['dikemas'] ?? 0);
    $jumlahDikirim = (int) ($counts['dikirim'] ?? 0);
    $jumlahDiproses = (int) ($counts['diproses'] ?? 0);
    $jumlahSelesai = (int) ($counts['selesai'] ?? 0);
    $jumlahBatal = (int) ($counts['dibatalkan'] ?? 0);
    $jumlahProses = $jumlahDikemas + $jumlahDikirim + $jumlahDiproses;

    $tabs = [
        'semua' => 'Semua Pesanan',
        'belum_bayar' => 'Belum Bayar',
        'dikemas' => 'Dikemas',
        'dikirim' => 'Dikirim',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];
@endphp

<main class="os-container">

    <!-- BREADCRUMB -->

    <nav class="os-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ url('/') }}">
            <i class="fa-solid fa-house"></i>
            Beranda
        </a>

        <i class="fa-solid fa-chevron-right" style="font-size:9px;"></i>

        <span>Pesanan Saya</span>
    </nav>

    <!-- HEADER -->

    <header class="os-page-head">

        <div class="os-heading-left">

            <span class="os-heading-icon">
                <i class="fa-solid fa-bag-shopping"></i>
            </span>

            <div>
                <h1>Pesanan Saya</h1>

                <p>
                    Pantau transaksi, status pembayaran,
                    pengiriman, pembatalan, dan ulasan produk.
                </p>
            </div>

        </div>

        <div class="os-header-actions">

            <a href="{{ route('chat.index') }}" class="os-btn">
                <i class="fa-regular fa-comments"></i>
                Pesan
            </a>

            @if(auth()->user()->products()->count() > 0)
                <a href="{{ route('pesanan.penjual') }}"
                   class="os-btn os-btn-primary">

                    <i class="fa-solid fa-store"></i>
                    Pesanan Masuk Toko
                </a>
            @endif

        </div>

    </header>

    <!-- KPI RINGKASAN PESANAN -->

    <section class="os-kpis" aria-label="Ringkasan pesanan">

        <div class="os-kpi">
            <div>
                <span class="os-kpi-label">Total Pesanan</span>
                <strong class="os-kpi-number">{{ $totalPesanan }}</strong>
                <span class="os-kpi-note">Sepanjang riwayat</span>
            </div>

            <span class="os-kpi-icon">
                <i class="fa-solid fa-receipt"></i>
            </span>
        </div>

        <div class="os-kpi">
            <div>
                <span class="os-kpi-label">Dalam Proses</span>
                <strong class="os-kpi-number">{{ $jumlahProses }}</strong>
                <span class="os-kpi-note">
                    {{ $jumlahDikemas }} dikemas,
                    {{ $jumlahDikirim }} dikirim
                </span>
            </div>

            <span class="os-kpi-icon">
                <i class="fa-solid fa-truck-fast"></i>
            </span>
        </div>

        <div class="os-kpi">
            <div>
                <span class="os-kpi-label">Pesanan Selesai</span>
                <strong class="os-kpi-number">{{ $jumlahSelesai }}</strong>
                <span class="os-kpi-note">Pesanan diterima</span>
            </div>

            <span class="os-kpi-icon">
                <i class="fa-regular fa-circle-check"></i>
            </span>
        </div>

        <div class="os-kpi">
            <div>
                <span class="os-kpi-label">Dibatalkan</span>
                <strong class="os-kpi-number">{{ $jumlahBatal }}</strong>
                <span class="os-kpi-note">Status pesanan batal</span>
            </div>

            <span class="os-kpi-icon">
                <i class="fa-solid fa-arrow-rotate-left"></i>
            </span>
        </div>

    </section>

    <!-- FILTER PESANAN -->

    <section class="os-toolbar" aria-label="Filter pesanan">

        <nav class="os-tabs" aria-label="Status pesanan">

            @foreach($tabs as $key => $label)

                <a
                    href="{{ route('pesanan.saya', ['tab' => $key]) }}"
                    class="os-tab {{ $statusTab === $key ? 'active' : '' }}"
                >
                    {{ $label }}

                    <span class="os-tab-count">
                        {{ (int) ($counts[$key] ?? 0) }}
                    </span>
                </a>

            @endforeach

        </nav>

        <div class="os-filters">

            <label class="os-field">
                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    id="orderSearch"
                    type="search"
                    placeholder="Cari nomor pesanan, penjual, produk..."
                    aria-label="Cari pesanan"
                >
            </label>

            <label class="os-field">
                <i class="fa-regular fa-calendar"></i>

                <select id="dateFilter" aria-label="Filter tanggal">
                    <option value="all">Semua Tanggal</option>
                    <option value="30">30 Hari Terakhir</option>
                    <option value="90">90 Hari Terakhir</option>
                </select>
            </label>

            <label class="os-field">
                <i class="fa-solid fa-store"></i>

                <select id="sellerFilter" aria-label="Filter penjual">
                    <option value="">Semua Penjual</option>
                </select>
            </label>

            <button type="button"
                    class="os-reset"
                    id="resetFilters"
                    title="Reset pencarian, tanggal, dan penjual"
                    aria-label="Reset filter">

                <i class="fa-solid fa-rotate-right"></i>
            </button>

        </div>

    </section>

    <!-- CONTENT DUA KOLOM -->

    <div class="os-content">

        <!-- DAFTAR PESANAN -->

        <section class="os-order-list" id="ordersList">

            <!-- NOTIFIKASI -->

            @if(session('success'))
                <div class="site-toast site-toast-success" id="orderToastSuccess">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="site-toast site-toast-error" id="orderToastError">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="os-notice danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            @forelse($orders as $order)

                @php
                    /*
                     * LOGIKA PEMBATALAN ASLI TANIMART
                     * Tidak mengubah proses di controller.
                     */

                    $cancellationWorkflowReady =
                        \Illuminate\Support\Facades\Route::has(
                            'pesanan.cancel.review'
                        ) &&
                        method_exists(
                            $order,
                            'cancellationApprovals'
                        );

                    $cancelRows = $cancellationWorkflowReady
                        ? $order->cancellationApprovals
                        : collect();

                    $cancelRejected = $cancelRows->contains(
                        'status',
                        'rejected'
                    );

                    $cancelPending = !$cancelRejected &&
                        $cancelRows->contains(
                            'status',
                            'pending'
                        );

                    $cancelApproved = !$cancelRejected &&
                        $cancelRows->contains(
                            'status',
                            'approved'
                        );

                    $cancelRequestExists = $cancelRows->isNotEmpty();

                    $canRequestCancel =
                        $cancellationWorkflowReady &&
                        in_array(
                            $order->shopee_status,
                            ['belum_bayar', 'dikemas'],
                            true
                        ) &&
                        $order->shipped_at === null &&
                        !$cancelRequestExists;

                    $stInfo = $order->status_info;

                    $firstItem = $order->items->first();

                    $seller = $firstItem && $firstItem->seller
                        ? $firstItem->seller
                        : (
                            $firstItem && $firstItem->product
                            ? $firstItem->product->user
                            : null
                        );

                    $sellerName = $seller
                        ? $seller->name
                        : 'Mitra TaniMart';

                    $subtotalProduk = $order->items->sum(
                        fn ($item) => (float) $item->price * (int) $item->quantity
                    );

                    $sellerInitial = mb_strtoupper(
                        mb_substr($sellerName, 0, 1)
                    );

                    $searchText = mb_strtolower(
                        $order->order_number . ' ' .
                        $sellerName . ' ' .
                        $order->items->pluck('product_name')->implode(' ')
                    );
                @endphp

                <article
                    class="os-card"
                    data-order-card
                    data-status="{{ $order->shopee_status }}"
                    data-date="{{ $order->created_at->format('Y-m-d') }}"
                    data-seller="{{ $sellerName }}"
                    data-search="{{ $searchText }}"
                    data-order-number="{{ $order->order_number }}"
                    data-order-label="{{ $stInfo['label'] }}"
                    data-order-total="Rp {{ number_format($order->total, 0, ',', '.') }}"
                    data-order-subtotal="Rp {{ number_format($subtotalProduk, 0, ',', '.') }}"
                    data-order-created="{{ $order->created_at->format('d M Y, H:i') }}"
                    data-order-courier="{{ $order->shipping_courier ?? '' }}"
                    data-order-tracking="{{ $order->tracking_number ?? '' }}"
                >

                    <!-- CARD HEADER -->

                    <div class="os-card-header">

                        <div class="os-seller">

                            <div class="os-seller-avatar">
                                {{ $sellerInitial }}
                            </div>

                            <div>

                                <div class="os-seller-name">
                                    {{ $sellerName }}
                                </div>

                                <div class="os-order-meta">
                                    <span>#{{ $order->order_number }}</span>
                                    <span>•</span>
                                    <span>
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    </span>
                                    <span>•</span>
                                    <span>
                                        {{ $order->payment_method ?? 'Metode tidak tercatat' }}
                                    </span>
                                </div>

                            </div>

                        </div>

                        <span
                            class="os-status"
                            style="color:{{ $stInfo['color'] }};background:{{ $stInfo['bg'] }};"
                        >
                            <i class="{{ $stInfo['icon'] }}"></i>
                            {{ $stInfo['label'] }}
                        </span>

                    </div>

                    <!-- INFORMASI PENGIRIMAN -->

                    @if($order->tracking_number)

                        <div class="os-shipping">

                            <i class="fa-solid fa-truck-fast"></i>

                            <div>
                                <strong>
                                    Resi:
                                    {{ $order->tracking_number }}
                                </strong>

                                <p>
                                    Kurir:
                                    {{ $order->shipping_courier ?? 'Belum tercatat' }}
                                    — gunakan nomor resi untuk menanyakan
                                    perkembangan pengiriman kepada penjual.
                                </p>
                            </div>

                        </div>

                    @elseif($order->shopee_status === 'dikirim')

                        <div class="os-shipping">

                            <i class="fa-solid fa-truck"></i>

                            <div>
                                <strong>Pesanan telah dikirim</strong>

                                <p>
                                    Nomor resi belum tercatat.
                                    Hubungi penjual untuk informasi pengiriman.
                                </p>
                            </div>

                        </div>

                    @endif

                    <!-- ITEMS PESANAN -->

                    <div class="os-items">

                        @foreach($order->items as $item)

                            <div class="os-item">

                                <!-- GAMBAR -->

                                <div class="os-thumb">

                                    @if($item->product && $item->product->image)

                                        <img
                                            src="{{ asset($item->product->image) }}"
                                            alt="{{ $item->product_name }}"
                                            loading="lazy"
                                        >

                                    @else

                                        <span>
                                            {{ $item->product->icon ?? '🌱' }}
                                        </span>

                                    @endif

                                </div>

                                <!-- INFORMASI -->

                                <div class="os-item-content">

                                    @if($item->product && $item->product->slug)

                                        <a
                                            href="{{ route('products.show', $item->product->slug) }}"
                                            class="os-item-name"
                                        >
                                            {{ $item->product_name }}
                                        </a>

                                    @else

                                        <span class="os-item-name">
                                            {{ $item->product_name }}
                                        </span>

                                    @endif

                                    <p class="os-item-sub">
                                        {{ $item->product->category ?? 'Produk Pertanian' }}

                                        @if($item->product && $item->product->unit)
                                            • {{ $item->product->unit }}
                                        @endif

                                        • {{ $item->quantity }} barang
                                    </p>

                                    <!-- ULASAN TERSIMPAN -->

                                    @if($item->rating)

                                        <div class="os-review">

                                            <div class="os-stars">

                                                @for($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa-solid fa-star"
                                                        style="color:{{ $i <= $item->rating ? '#eab308' : '#cbd5e1' }}"
                                                    ></i>
                                                @endfor

                                            </div>

                                            <strong>Penilaian Anda:</strong>
                                            {{ $item->review ?? 'Sudah dinilai' }}

                                        </div>

                                    @elseif($order->shopee_status === 'selesai')

                                        <div style="margin-top:11px;">

                                            <button
                                                type="button"
                                                class="os-btn"
                                                data-product-name="{{ $item->product_name }}"
                                                onclick="openRatingModal({{ $item->id }}, this.dataset.productName)"
                                            >
                                                <i class="fa-solid fa-star" style="color:#d4a235;"></i>
                                                Beri Ulasan
                                            </button>

                                        </div>

                                    @endif

                                </div>

                                <!-- HARGA -->

                                <div class="os-item-price">

                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}

                                    <small>
                                        {{ $item->quantity }} ×
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </small>

                                </div>

                            </div>

                        @endforeach

                    </div>

                    <!-- FOOTER KARTU -->

                    <div class="os-card-footer">

                        <div class="os-footer-top">

                            <div>

                                <div class="os-total-label">
                                    Total Pesanan
                                </div>

                                <strong class="os-total">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </strong>

                            </div>

                            <div class="os-actions">

                                <!-- PILIH PESANAN UNTUK SIDEBAR -->

                                <button
                                    type="button"
                                    class="os-btn"
                                    data-inspect-order
                                >
                                    <i class="fa-regular fa-eye"></i>
                                    Rincian
                                </button>

                                <!-- CHAT PENJUAL -->

                                @if($seller && $seller->id !== auth()->id())

                                    <a
                                        href="{{ route('chat.index', ['user_id' => $seller->id]) }}"
                                        class="os-btn"
                                    >
                                        <i class="fa-regular fa-comments"></i>
                                        Chat Penjual
                                    </a>

                                @endif

                                <!-- BELUM BAYAR -->

                                @if($order->shopee_status === 'belum_bayar')

                                    @if(!$cancelPending && !$cancelApproved)

                                        <form
                                            action="{{ route('pesanan.pay', $order->id) }}"
                                            method="POST"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="os-btn os-btn-primary"
                                            >
                                                <i class="fa-solid fa-credit-card"></i>
                                                Bayar Sekarang
                                            </button>

                                        </form>

                                    @endif

                                @endif

                                <!-- DIKEMAS -->

                                @if($order->shopee_status === 'dikemas')

                                    <span style="font-size:11px;color:#377b58;">
                                        <i class="fa-solid fa-box"></i>
                                        Dikemas penjual
                                    </span>

                                @endif

                                <!-- DIKIRIM -->

                                @if($order->shopee_status === 'dikirim')

                                    <form
                                        action="{{ route('pesanan.confirm', $order->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Pastikan barang sudah diterima dengan baik sebelum konfirmasi!');"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="os-btn os-btn-primary"
                                        >
                                            <i class="fa-solid fa-circle-check"></i>
                                            Pesanan Diterima
                                        </button>

                                    </form>

                                @endif

                                <!-- SELESAI -->

                                @if($order->shopee_status === 'selesai')

                                    <a href="{{ url('/#produk') }}"
                                       class="os-btn">
                                        <i class="fa-solid fa-rotate-right"></i>
                                        Beli Lagi
                                    </a>

                                @endif

                                <!-- DIBATALKAN -->

                                @if($order->shopee_status === 'dibatalkan')

                                    <a href="{{ url('/#produk') }}"
                                       class="os-btn">
                                        <i class="fa-solid fa-seedling"></i>
                                        Cari Produk Lain
                                    </a>

                                @endif

                            </div>

                        </div>

                        <!-- ALUR PEMBATALAN ASLI -->

                        @if(
                            in_array(
                                $order->shopee_status,
                                ['belum_bayar', 'dikemas'],
                                true
                            ) &&
                            ($cancelPending || $cancelApproved)
                        )

                            <div class="os-notice">
                                <i class="fa-solid fa-hourglass-half"></i>

                                {{ $cancelPending
                                    ? 'Menunggu Persetujuan Penjual'
                                    : 'Menunggu Persetujuan Penjual Lain'
                                }}
                            </div>

                        @elseif($cancelRejected)

                            <div class="os-notice danger">
                                <i class="fa-solid fa-circle-xmark"></i>
                                Permintaan Pembatalan Ditolak
                            </div>

                        @elseif($canRequestCancel)

                            <form
                                class="os-cancel-row"
                                action="{{ route('pesanan.cancel', $order->id) }}"
                                method="POST"
                                onsubmit="return confirm('Ajukan pembatalan kepada penjual? Pesanan tidak langsung dibatalkan.');"
                            >
                                @csrf

                                <label for="cancel-reason-{{ $order->id }}"
                                       style="font-size:11px;color:#667d6e;">
                                    Alasan pembatalan:
                                </label>

                                <select
                                    id="cancel-reason-{{ $order->id }}"
                                    name="reason"
                                    required
                                >
                                    <option value="">
                                        Pilih alasan
                                    </option>

                                    <option value="Salah memilih produk">
                                        Salah memilih produk
                                    </option>

                                    <option value="Ingin mengubah pesanan">
                                        Ingin mengubah pesanan
                                    </option>

                                    <option value="Tidak jadi membeli">
                                        Tidak jadi membeli
                                    </option>

                                    <option value="Alasan lainnya">
                                        Alasan lainnya
                                    </option>
                                </select>

                                <button type="submit"
                                        class="os-btn os-btn-danger">
                                    <i class="fa-solid fa-xmark"></i>
                                    Ajukan Pembatalan
                                </button>

                            </form>

                        @elseif(
                            in_array(
                                $order->shopee_status,
                                ['belum_bayar', 'dikemas'],
                                true
                            ) &&
                            !$cancellationWorkflowReady
                        )

                            <div class="os-notice info">
                                Pengajuan pembatalan belum tersedia.
                            </div>

                        @endif

                        <!-- STATUS REFUND -->

                        @if(
                            $order->shopee_status === 'dibatalkan' &&
                            $order->refund_status === 'pending'
                        )

                            <div class="os-notice info">
                                <i class="fa-solid fa-wallet"></i>
                                Pengembalian dana perlu diproses.
                            </div>

                        @endif

                    </div>

                </article>

            @empty

                <div class="os-empty">

                    <span class="os-empty-icon">📦</span>

                    <h3>
                        Belum Ada Pesanan
                    </h3>

                    <p>
                        Tidak ada pesanan pada kategori
                        "{{ $tabs[$statusTab] ?? 'Semua Pesanan' }}".
                        Yuk, jelajahi berbagai produk pertanian di TaniMart!
                    </p>

                    <a href="{{ url('/#produk') }}"
                       class="os-btn os-btn-primary"
                       style="margin-top:16px;">
                        <i class="fa-solid fa-basket-shopping"></i>
                        Mulai Belanja
                    </a>

                </div>

            @endforelse

            <!-- EMPTY STATE PENCARIAN JS -->

            <div class="os-no-match" id="noSearchMatch" hidden>
                <i class="fa-solid fa-magnifying-glass"
                   style="font-size:29px;display:block;margin-bottom:12px;"></i>

                Tidak ditemukan pesanan yang cocok
                dengan filter pencarianmu.
            </div>

        </section>

        <!-- SIDEBAR RINCIAN -->

        <aside class="os-aside">

            <!-- TAHAPAN PESANAN -->

            <div class="os-aside-card" id="ringkasan-pesanan">

                <div class="os-aside-title">

                    <h2>
                        <i class="fa-solid fa-chart-line"></i>
                        Status Pesanan
                    </h2>

                    <span class="os-aside-label">
                        Data TaniMart
                    </span>

                </div>

                <div class="os-selected-order">

                    <small>Nomor Pesanan:</small>

                    <strong id="focusOrderNumber">
                        Pilih pesanan
                    </strong>

                    <span class="os-selected-status"
                          id="focusOrderStatus">
                        Klik Rincian pada salah satu pesanan.
                    </span>

                </div>

                <div class="os-tracking" id="orderTimeline">

                    <div class="os-step" data-step="1">
                        <strong>Pesanan Dibuat</strong>
                        <small>Transaksi tercatat di TaniMart</small>
                    </div>

                    <div class="os-step" data-step="2">
                        <strong>Tahap Pembayaran</strong>
                        <small>Menunggu status pembayaran</small>
                    </div>

                    <div class="os-step" data-step="3">
                        <strong>Pesanan Dikemas</strong>
                        <small>Penjual mempersiapkan pesanan</small>
                    </div>

                    <div class="os-step" data-step="4">
                        <strong>Pesanan Dikirim</strong>
                        <small>Menunggu proses pengiriman</small>
                    </div>

                    <div class="os-step" data-step="5">
                        <strong>Pesanan Selesai</strong>
                        <small>Pembeli mengonfirmasi penerimaan</small>
                    </div>

                </div>

                <div class="os-tracking-extra">

                    <div>
                        <i class="fa-regular fa-calendar"></i>
                        <strong>Tanggal Pesanan:</strong>
                        <span id="focusOrderCreated">—</span>
                    </div>

                    <div>
                        <i class="fa-solid fa-truck"></i>
                        <strong>Kurir:</strong>
                        <span id="focusOrderCourier">—</span>
                    </div>

                    <div>
                        <i class="fa-solid fa-barcode"></i>
                        <strong>Nomor Resi:</strong>
                        <span id="focusOrderTracking">—</span>
                    </div>

                    <p style="margin:12px 0 0;color:#87998a;font-size:10px;line-height:1.7;">
                        Tahapan mengikuti status pesanan di TaniMart.
                        Pergerakan kurir secara real-time belum tersedia.
                    </p>

                </div>

            </div>

            <!-- RINCIAN FINANSIAL -->

            <div class="os-aside-card">

                <div class="os-aside-title">

                    <h2>
                        <i class="fa-solid fa-receipt"></i>
                        Rincian Pesanan
                    </h2>

                </div>

                <div class="os-summary-row">
                    <span>Subtotal produk</span>
                    <strong id="focusSubtotal">—</strong>
                </div>

                <div class="os-summary-row">
                    <span>Informasi biaya lainnya</span>
                    <strong>
                        Lihat total transaksi
                    </strong>
                </div>

                <div class="os-summary-row total">
                    <span>Total Pesanan</span>
                    <strong id="focusTotal">—</strong>
                </div>

                <div style="
                    margin-top:16px;
                    padding:12px;
                    background:#e7f5e9;
                    color:#52735e;
                    border-radius:12px;
                    font-size:10px;
                    line-height:1.7;
                ">
                    <i class="fa-solid fa-shield-halved"></i>
                    Informasi ini menggunakan nilai transaksi
                    yang tercatat di database TaniMart.
                </div>

            </div>

        </aside>

    </div>

    <!-- CTA PASAR -->

    <section class="os-cta">

        <div>

            <h3>
                🌱 Ingin memperluas kebun atau hidroponik?
            </h3>

            <p>
                Temukan bibit, pupuk, media tanam,
                dan berbagai perlengkapan pertanian lainnya.
            </p>

        </div>

        <a href="{{ url('/#produk') }}"
           class="os-btn os-btn-primary">

            Belanja Produk Kebun
            <i class="fa-solid fa-arrow-right"></i>
        </a>

    </section>

</main>

<!-- ==================================================
     MODAL RATING PRODUK
     FITUR LAMA TETAP DIPERTAHANKAN
     ================================================== -->

<div class="rating-modal-backdrop"
     id="ratingModal"
     role="dialog"
     aria-modal="true"
     aria-labelledby="ratingTitle">

    <div class="rating-modal-card">

        <div style="
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            margin-bottom:17px;
        ">

            <h2 id="ratingTitle"
                style="font-size:19px;color:#244e36;margin:0;">
                <i class="fa-solid fa-star"
                   style="color:#e4aa37;"></i>
                Beri Penilaian
            </h2>

            <button type="button"
                    onclick="closeRatingModal()"
                    aria-label="Tutup modal"
                    style="border:0;background:transparent;cursor:pointer;color:#718577;">
                ✕
            </button>

        </div>

        <p style="font-size:12px;color:#718577;">
            Produk:
            <strong id="modalProductName"
                    style="color:#274a36;">—</strong>
        </p>

        <form id="ratingForm" action="" method="POST">
            @csrf

            <input type="hidden"
                   name="rating"
                   id="ratingInput"
                   value="5">

            <div class="star-picker" id="starPicker">

                @for($i = 1; $i <= 5; $i++)
                    <i
                        class="fa-solid fa-star selected"
                        data-val="{{ $i }}"
                        role="button"
                        tabindex="0"
                        aria-label="{{ $i }} bintang"
                    ></i>
                @endfor

            </div>

            <p id="starDesc"
               style="text-align:center;color:#bb8727;font-size:12px;margin:0 0 19px;">
                ⭐⭐⭐⭐⭐ Sangat Puas!
            </p>

            <label
                for="ratingReview"
                style="display:block;font-size:12px;font-weight:800;color:#3f5f49;margin-bottom:8px;"
            >
                Tulis Ulasan Produk
            </label>

            <textarea
                id="ratingReview"
                name="review"
                rows="4"
                placeholder="Ceritakan pengalamanmu tentang kualitas produk dan pelayanan penjual..."
            ></textarea>

            <div style="
                display:flex;
                justify-content:flex-end;
                flex-wrap:wrap;
                gap:9px;
                margin-top:20px;
            ">

                <button type="button"
                        class="os-btn"
                        onclick="closeRatingModal()">
                    Batal
                </button>

                <button type="submit"
                        class="os-btn os-btn-primary">
                    <i class="fa-solid fa-paper-plane"></i>
                    Kirim Penilaian
                </button>

            </div>

        </form>

    </div>

</div>

@include('partials.footer')

<!-- ==================================================
     JAVASCRIPT FILTER, RINGKASAN, RATING
     Tidak mengubah isi database secara langsung
     ================================================== -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    const cards = Array.from(
        document.querySelectorAll('[data-order-card]')
    );

    const search = document.getElementById('orderSearch');
    const dateFilter = document.getElementById('dateFilter');
    const sellerFilter = document.getElementById('sellerFilter');
    const resetButton = document.getElementById('resetFilters');
    const noMatch = document.getElementById('noSearchMatch');

    // ==================================================
    // PILIHAN PENJUAL BERASAL DARI PESANAN YANG TAMPIL
    // ==================================================

    const sellerNames = [
        ...new Set(
            cards
                .map(card => card.dataset.seller)
                .filter(Boolean)
        )
    ].sort((a, b) => a.localeCompare(b, 'id'));

    sellerNames.forEach(function (name) {

        const option = document.createElement('option');

        option.value = name;
        option.textContent = name;

        sellerFilter.appendChild(option);

    });

    // ==================================================
    // PENCARIAN, FILTER TANGGAL, FILTER SELLER
    // ==================================================

    function filterOrders() {

        const keyword = search.value.trim().toLowerCase();
        const period = dateFilter.value;
        const selectedSeller = sellerFilter.value;

        let visibleCount = 0;

        const now = new Date();

        cards.forEach(function (card) {

            const searchable = (
                card.dataset.search || ''
            ).toLowerCase();

            const matchSearch =
                !keyword || searchable.includes(keyword);

            const matchSeller =
                !selectedSeller ||
                card.dataset.seller === selectedSeller;

            let matchDate = true;

            if (period !== 'all') {

                const dateText = card.dataset.date;

                if (dateText) {

                    const orderDate = new Date(
                        dateText + 'T00:00:00'
                    );

                    const difference =
                        now.getTime() - orderDate.getTime();

                    const maximumDays = Number(period);

                    matchDate =
                        difference >= 0 &&
                        difference <= maximumDays * 86400000;

                } else {
                    matchDate = false;
                }

            }

            const shouldShow =
                matchSearch && matchSeller && matchDate;

            card.hidden = !shouldShow;
            card.style.display = shouldShow ? '' : 'none';

            if (shouldShow) {
                visibleCount++;
            }

        });

        if (noMatch) {
            noMatch.hidden =
                cards.length === 0 || visibleCount !== 0;
        }
    }

    search.addEventListener('input', filterOrders);
    dateFilter.addEventListener('change', filterOrders);
    sellerFilter.addEventListener('change', filterOrders);

    resetButton.addEventListener('click', function () {

        search.value = '';
        dateFilter.value = 'all';
        sellerFilter.value = '';

        filterOrders();

    });

    // ==================================================
    // RINCIAN DINAMIS — PANEL SAMPING
    // ==================================================

    const focusNumber = document.getElementById('focusOrderNumber');
    const focusStatus = document.getElementById('focusOrderStatus');
    const focusCreated = document.getElementById('focusOrderCreated');
    const focusCourier = document.getElementById('focusOrderCourier');
    const focusTracking = document.getElementById('focusOrderTracking');
    const focusSubtotal = document.getElementById('focusSubtotal');
    const focusTotal = document.getElementById('focusTotal');

    const steps = document.querySelectorAll(
        '#orderTimeline [data-step]'
    );

    const timelineDescriptions = [
        'Transaksi tercatat di TaniMart',
        'Status pembayaran pesanan',
        'Penjual mempersiapkan pesanan',
        'Proses pengiriman pesanan',
        'Pembeli mengonfirmasi penerimaan'
    ];

    function getStage(status) {

        const stages = {
            'belum_bayar': 1,
            'dikemas': 3,
            'diproses': 3,
            'dikirim': 4,
            'selesai': 5,
            'dibatalkan': 0
        };

        return stages[status] ?? 1;
    }

    function selectOrder(card) {

        if (!card) {
            return;
        }

        const data = card.dataset;
        const status = data.status || '';

        focusNumber.textContent =
            '#' + (data.orderNumber || '—');

        focusStatus.textContent =
            data.orderLabel || 'Status belum tercatat';

        focusCreated.textContent =
            data.orderCreated || '—';

        focusCourier.textContent =
            data.orderCourier || 'Belum tercatat';

        focusTracking.textContent =
            data.orderTracking || 'Belum tersedia';

        focusSubtotal.textContent =
            data.orderSubtotal || '—';

        focusTotal.textContent =
            data.orderTotal || '—';

        const currentStage = getStage(status);

        steps.forEach(function (step, index) {

            const stageNumber = index + 1;

            step.classList.remove('done', 'current');

            const detail = step.querySelector('small');

            if (detail) {
                detail.textContent = timelineDescriptions[index];
            }

            if (status === 'dibatalkan') {

                if (stageNumber === 1) {
                    step.classList.add('done');
                }

                if (stageNumber === 2 && detail) {
                    detail.textContent =
                        'Pesanan dibatalkan; tahapan berikutnya tidak dilanjutkan.';
                }

            } else if (stageNumber < currentStage) {

                step.classList.add('done');

            } else if (stageNumber === currentStage) {

                step.classList.add('current');

            }

        });

        const aside = document.getElementById('ringkasan-pesanan');

        if (
            aside &&
            window.matchMedia('(max-width: 940px)').matches
        ) {
            aside.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

    }

    document.querySelectorAll('[data-inspect-order]')
        .forEach(function (button) {

            button.addEventListener('click', function () {

                const card = button.closest('[data-order-card]');

                selectOrder(card);

            });

        });

    // Pilih otomatis pesanan pertama yang tersedia
    if (cards.length > 0) {
        selectOrder(cards[0]);
    }

    // ==================================================
    // NOTIFIKASI
    // ==================================================

    setTimeout(function () {

        document.getElementById('orderToastSuccess')?.remove();
        document.getElementById('orderToastError')?.remove();

    }, 5000);

    // ==================================================
    // MODAL RATING
    // ==================================================

    const modal = document.getElementById('ratingModal');

    modal.addEventListener('click', function (event) {

        if (event.target === modal) {
            closeRatingModal();
        }

    });

    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {
            closeRatingModal();
        }

    });

});

function openRatingModal(itemId, productName) {

    document.getElementById('modalProductName').textContent =
        productName;

    document.getElementById('ratingForm').action =
        '/pesanan/item/' + encodeURIComponent(itemId) + '/nilai';

    document.getElementById('ratingModal')
        .classList.add('show');

    setRating(5);

}

function closeRatingModal() {

    document.getElementById('ratingModal')
        .classList.remove('show');

}

const starDescMap = {
    1: '⭐ Sangat Mengecewakan',
    2: '⭐⭐ Kurang Memuaskan',
    3: '⭐⭐⭐ Cukup Baik',
    4: '⭐⭐⭐⭐ Bagus & Sesuai',
    5: '⭐⭐⭐⭐⭐ Sangat Puas!'
};

function setRating(value) {

    document.getElementById('ratingInput').value = value;

    const stars = document.querySelectorAll('#starPicker i');

    stars.forEach(function (star, index) {

        star.classList.toggle(
            'selected',
            index < value
        );

    });

    document.getElementById('starDesc').textContent =
        starDescMap[value] || '';

}

document.querySelectorAll('#starPicker i').forEach(function (star) {

    star.addEventListener('click', function () {

        const value = parseInt(
            this.getAttribute('data-val'),
            10
        );

        setRating(value);

    });

    star.addEventListener('keydown', function (event) {

        if (event.key === 'Enter' || event.key === ' ') {

            event.preventDefault();

            setRating(
                parseInt(star.getAttribute('data-val'), 10)
            );

        }

    });

});
</script>

</body>
</html>
