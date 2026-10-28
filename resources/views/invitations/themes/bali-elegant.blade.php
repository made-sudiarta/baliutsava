
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $invitation->title }} | BaliUtsava</title>

    <meta name="description"
          content="{{ \Illuminate\Support\Str::limit(trim(strip_tags(html_entity_decode($invitation->description ?? ''))), 160) }}">

    <meta property="og:title"
          content="{{ $invitation->title }} | BaliUtsava">

    <meta property="og:description"
          content="{{ \Illuminate\Support\Str::limit(trim(strip_tags(html_entity_decode($invitation->description ?? ''))), 160) }}">

    <meta property="og:type" content="website">

    <meta property="og:url" content="{{ url()->current() }}">

    <meta name="theme-color" content="#f8f4ec">

    <style>
        :root {
            --green: #254b3c;
            --green-light: #406b54;
            --gold: #b58a4a;
            --cream: #f8f4ec;
            --text: #30352f;
            --muted: #777b71;
            --white: #fff;
        }

        * { box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 20px;
        }

        body {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--text);
            background: var(--cream);
            line-height: 1.7;
        }

        a { color: inherit; }

        .hero {
            min-height: 100svh;
            position: relative;
            overflow: hidden;
            display: grid;
            place-items: center;
            padding: 40px 20px;
            text-align: center;
            color: white;
            background:
                radial-gradient(ellipse at center, #52705b, #18372c 75%);
        }

        .hero-photo {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .34;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(14, 34, 26, .25),
                rgba(14, 34, 26, .75)
            );
        }

        .hero-content {
            z-index: 1;
            position: relative;
            width: min(100%, 760px);
        }

        .eyebrow {
            text-transform: uppercase;
            letter-spacing: 4px;
            font-size: 11px;
        }

        .ornament {
            color: #e0bd7e;
            font-size: 28px;
            margin: 18px 0;
        }

        h1, h2, h3, p { margin-top: 0; }

        .hero h1 {
            font-size: clamp(36px, 7vw, 72px);
            line-height: 1.12;
            font-weight: 400;
            margin: 22px 0;
        }

        .hero-date {
            letter-spacing: 2px;
            margin: 24px 0;
        }

        /* Splash screen undangan */
        .hero {
            position: fixed;
            inset: 0;
            z-index: 9999;
            width: 100%;
            height: 100vh;
            height: 100dvh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            transition:
                opacity 0.6s ease,
                visibility 0.6s ease,
                transform 0.6s ease;
        }

        /* Foto sampul memenuhi layar */
        .hero .hero-photo {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Lapisan gelap agar teks terbaca */
        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(0, 0, 0, 0.25),
                rgba(0, 0, 0, 0.55)
            );
            z-index: 0;
        }

        .hero .hero-content {
            position: relative;
            z-index: 1;
            width: 100%;
            max-height: 100%;
            overflow-y: auto;
            padding: 24px 20px;
            box-sizing: border-box;
        }

        /* Setelah tombol diklik */
        .hero.splash-closed {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: scale(1.03);
        }

        /* Kunci scroll sebelum undangan dibuka */
        body.splash-active {
            overflow: hidden;
            height: 100%;
        }

        /* Tampilan tombol */
        #bukaUndangan {
            cursor: pointer;
        }
        .button {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 30px;
            text-decoration: none;
            border: 1px solid var(--gold);
            background: var(--green);
            color: white;
            cursor: pointer;
            font: inherit;
            transition: .2s ease;
        }

        .button:hover {
            background: var(--green-light);
            transform: translateY(-2px);
        }

        .button-outline {
            color: var(--green);
            background: transparent;
        }

        .button-outline:hover {
            color: white;
        }

        .section {
            padding: 76px 20px;
        }

        .section-inner {
            max-width: 1000px;
            margin: 0 auto;
        }

        .section-heading {
            text-align: center;
            margin-bottom: 34px;
        }
        .text-uppercase {
            text-transform: uppercase;
        }

        .section-heading h2 {
            color: var(--green);
            font-size: clamp(28px, 4vw, 42px);
            font-weight: 400;
            margin-bottom: 8px;
        }

        .section-heading p {
            /* color: var(--muted); */
            margin-bottom: 0;
        }

        .intro {
            text-align: center;
            max-width: 760px;
            margin: auto;
        }

        .intro .couple {
            color: var(--green);
            font-size: clamp(32px, 5vw, 52px);
            line-height: 1.3;
            margin: 20px 0;
        }

        .gold-line {
            width: 70px;
            height: 1px;
            background: var(--gold);
            margin: 22px auto;
        }

        .events {
            background: #eee8dc;
        }

        .event-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .event-card {
            background: rgba(255,255,255,.8);
            padding: 28px;
            text-align: center;
            border: 1px solid #e5d7bf;
            border-radius: 14px;
        }

        .event-card h3 {
            color: var(--green);
            font-size: 24px;
            font-weight: 400;
        }

        .event-time {
            color: var(--gold);
            font-size: 18px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .gallery-item {
            overflow: hidden;
            border-radius: 12px;
            aspect-ratio: 4 / 5;
            background: #e5dfd2;
        }

        .gallery-item img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.04);
        }

        .location-card {
            text-align: center;
            max-width: 700px;
            margin: auto;
            padding: 32px;
            background: white;
            border: 1px solid #e5d7bf;
            border-radius: 16px;
        }

        .message-list {
            display: grid;
            gap: 14px;
            max-width: 700px;
            margin: 0 auto;
        }

        .message-card {
            padding: 20px;
            border-radius: 12px;
            background: white;
            border: 1px solid #e8dfd1;
        }

        .message-card strong {
            color: var(--green);
        }

        .footer {
            padding: 35px 20px;
            background: var(--green);
            color: white;
            text-align: center;
        }

        .footer small {
            color: #d7dfd6;
        }

        .guest-label {
            padding: 12px 18px;
            display: inline-block;
            margin-top: 12px;
            border: 1px solid rgba(255,255,255,.4);
            border-radius: 12px;
        }
        .guest-name{
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 18px;
        }
        .invitation-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
        }

        .invitation-logo img {
            display: block;
            width: 180px;
            height: 180px;
            object-fit: contain;
        }
        .text-big{
            font-size:24pt;
            color:#fff !important;
            text-weight:bold;
        }

        #pembuka {
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            padding: 30px 20px;

            background-color: #25352e;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            color: #fff;
            position: relative;
            isolation: isolate;
            overflow: hidden;
        }

        #pembuka::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(15, 24, 20, 0.48);
            z-index: -1;
        }

        #pembuka .section-inner {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        #pembuka .section-heading {
            width: 100%;
            text-align: center;
        }

        /* Ornamen wave di bawah pembuka */
        #pembuka .section-wave {
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 85px;
            z-index: 2;
            line-height: 0;
            pointer-events: none;
        }

        #pembuka .section-wave svg {
            display: block;
            width: 100%;
            height: 100%;
        }
        /* Foto pasangan bersama */
        .couple-photo-card {
            width: 100%;
            max-width: 560px;
            margin: 0 auto;
            text-align: center;
        }

        .couple-photo-card img {
            display: block;
            width: 100%;
            height: auto;
            max-height: 70vh;
            max-height: 70dvh;
            object-fit: cover;
            object-position: bottom;
            margin: 0 auto;
            border: 5px solid #fffaf0;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(42, 51, 43, 0.12);
        }

        /* Dua foto partner */
        .partner-photo-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px;
            max-width: 760px;
            margin: 0 auto;
        }

        .partner-photo-card {
            min-width: 0;
            text-align: center;
        }

        .partner-photo-card img {
            display: block;
            width: 100%;
            aspect-ratio: 3 / 4;
            object-fit: cover;
            object-position: center;
            border: 4px solid #fffaf0;
            border-radius: 6px;
            box-shadow: 0 8px 25px rgba(42, 51, 43, 0.12);
            margin-bottom: 16px;
        }

        .partner-photo-card h3 {
            overflow-wrap: anywhere;
            font-size: clamp(16px, 2.5vw, 24px);
            line-height: 1.4;
        }

        @media (max-width: 600px) {
            .couple-photo-card {
                max-width: 100%;
            }

            .couple-photo-card img {
                max-height: 60vh;
                max-height: 60dvh;
                border-width: 3px;
            }

            .partner-photo-grid {
                gap: 12px;
            }

            .partner-photo-card img {
                border-width: 3px;
                margin-bottom: 12px;
            }
        }
    
        @media (max-width: 640px) {
            .invitation-logo {
                margin-bottom: 20px;
            }

            .invitation-logo img {
                width: 85px;
                height: 85px;
            }
        }
        @media (max-width: 640px) {
            .section { padding: 55px 18px; }

            .event-grid {
                grid-template-columns: 1fr;
            }

            .gallery-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .location-card { padding: 24px 18px; }

            .hero h1 { font-size: clamp(36px, 10vw, 52px); }
        }
        /* Perkecil jarak sebelum foto pasangan */
        .partner-photos {
            padding-top: 0px;
            padding-bottom: 0px;
        }

        .partner-heading {
            margin-top: 0;
            margin-bottom: 18px;
        }

        .partner-heading .partner-eyebrow {
            margin-top: 0;
            margin-bottom: 8px;
        }

        .partner-heading h2 {
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .partner-heading .gold-line {
            margin: 10px auto;
        }

        /* Foto pasangan */
        .couple-photo-card {
            margin-top: 0;
        }

        /* Jika section pembuka memiliki padding bawah terlalu besar */
        #pembuka {
            padding-bottom: 20px;
        }
        .partner-names{
            margin-top:35px;
            margin-bottom:50px;
        }

        @media (max-width: 600px) {
            .partner-photos {
                padding-top: 15px;
            }

            .partner-heading {
                margin-bottom: 15px;
            }
        }

        /* Dudonan Upacara Baliutsava */
        #upacara {
            background: #f8f5ee;
            color: #294638;
            padding: 65px 20px;
        }

        #upacara .section-inner {
            max-width: 900px;
            margin: 0 auto;
        }

        #upacara .section-heading {
            text-align: center;
            margin-bottom: 42px;
        }

        #upacara .ceremony-eyebrow {
            color: #a58242;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 10px;
        }

        #upacara .section-heading h2 {
            font-family: Georgia, serif;
            font-size: clamp(30px, 5vw, 44px);
            font-weight: normal;
            margin: 0;
        }

        #upacara .gold-line {
            width: 65px;
            height: 2px;
            background: #c8a45d;
            margin: 18px auto;
        }

        #upacara .ceremony-intro {
            max-width: 560px;
            margin: 0 auto;
            line-height: 1.8;
            color: #68685d;
        }

        #upacara .ceremony-timeline {
            position: relative;
            max-width: 760px;
            margin: 0 auto;
        }

        #upacara .ceremony-day {
            position: relative;
            padding-left: 155px;
            margin-bottom: 22px;
        }

        #upacara .ceremony-day::before {
            content: "";
            position: absolute;
            left: 137px;
            top: 24px;
            bottom: -25px;
            width: 1px;
            background: #d9c9a8;
        }

        #upacara .ceremony-day:last-child::before {
            display: none;
        }

        #upacara .ceremony-date {
            position: absolute;
            top: 18px;
            left: 0;
            width: 120px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #725b32;
            font-weight: 700;
            font-size: 14px;
        }

        #upacara .date-icon {
            color: #b18a45;
            font-size: 16px;
        }

        #upacara .ceremony-card {
            background: #fffdf8;
            border: 1px solid #e7dcc7;
            border-radius: 12px;
            padding: 12px 18px;
            box-shadow: 0 5px 18px rgba(50, 57, 43, 0.04);
        }

        #upacara .ceremony-item {
            display: grid;
            grid-template-columns: 58px minmax(0, 1fr);
            gap: 12px;
            padding: 10px 0;
            line-height: 1.6;
        }

        #upacara .ceremony-item + .ceremony-item {
            border-top: 1px solid #f0eadf;
        }

        #upacara .ceremony-time {
            color: #a58242;
            font-size: 13px;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
        }

        #upacara .ceremony-time-empty {
            visibility: hidden;
        }

        #upacara .ceremony-name {
            overflow-wrap: anywhere;
            color: #3c463d;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            #upacara {
                padding: 45px 16px;
            }

            #upacara .section-heading {
                margin-bottom: 28px;
            }

            #upacara .ceremony-day {
                padding-left: 0;
                margin-bottom: 20px;
            }

            #upacara .ceremony-day::before {
                display: none;
            }

            #upacara .ceremony-date {
                position: static;
                width: auto;
                margin-bottom: 8px;
                font-size: 14px;
            }

            #upacara .ceremony-card {
                padding: 8px 13px;
                border-radius: 10px;
            }

            #upacara .ceremony-item {
                grid-template-columns: 48px minmax(0, 1fr);
                gap: 8px;
                padding: 9px 0;
            }

            #upacara .ceremony-name {
                font-size: 13px;
                line-height: 1.65;
            }
        }

        /* Dudonan Acara */
        #dudonan-acara {
            background: #eee7d9;
            color: #294638;
            padding: 65px 20px;
        }

        #dudonan-acara .section-inner {
            max-width: 760px;
            margin: 0 auto;
        }

        .event-program-heading {
            text-align: center;
            margin-bottom: 30px;
        }

        .event-eyebrow {
            margin: 0 0 10px;
            color: #a58242;
            font-size: 12px;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .event-program-heading h2 {
            margin: 0;
            font-family: Georgia, serif;
            font-size: clamp(30px, 5vw, 42px);
            font-weight: normal;
        }

        .event-program-heading .gold-line {
            width: 65px;
            height: 2px;
            margin: 18px auto;
            background: #c8a45d;
        }

        .event-date {
            margin: 0;
            color: #6c6c60;
            line-height: 1.7;
        }

        .event-program-card {
            padding: 20px 26px;
            background: #fffdf8;
            border: 1px solid #e2d4ba;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(41, 70, 56, 0.06);
        }

        .event-program-list {
            list-style: none;
            counter-reset: event;
            padding: 0;
            margin: 0;
        }

        .event-program-list li {
            counter-increment: event;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 13px 0;
            line-height: 1.6;
            border-bottom: 1px solid #eee8dc;
        }

        .event-program-list li:last-child {
            border-bottom: none;
        }

        .event-program-list li::before {
            content: counter(event, decimal-leading-zero);
            flex: 0 0 34px;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #e9dfc9;
            color: #725b32;
            font-size: 12px;
            font-weight: 700;
        }

        .event-notes {
            margin-top: 22px;
            padding: 24px;
            border: 1px solid #dfcfb0;
            border-radius: 14px;
            background: rgba(255, 253, 248, 0.65);
        }

        .event-notes h3 {
            margin: 0 0 14px;
            font-family: Georgia, serif;
            font-size: 22px;
            font-weight: normal;
        }

        .event-notes ul {
            margin: 0;
            padding-left: 20px;
        }

        .event-notes li {
            padding: 4px 0;
            line-height: 1.7;
        }

        .event-contact {
            display: flex;
            flex-wrap: wrap;
            gap: 6px 12px;
            align-items: center;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #e2d4ba;
        }

        .event-contact span {
            color: #68685d;
        }

        .event-contact strong {
            color: #294638;
            overflow-wrap: anywhere;
        }

        .event-wa-button {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            width: 100%;
            box-sizing: border-box;
            margin-top: 18px;
            padding: 14px 20px;
            border-radius: 8px;
            background: #286746;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .event-wa-button:hover {
            background: #1e5237;
            color: #fff;
            transform: translateY(-1px);
        }

        @media (max-width: 600px) {
            #dudonan-acara {
                padding: 45px 16px;
            }

            .event-program-card {
                padding: 12px 17px;
                border-radius: 11px;
            }

            .event-program-list li {
                gap: 11px;
                padding: 11px 0;
                font-size: 14px;
            }

            .event-notes {
                padding: 19px 17px;
            }

            .event-notes h3 {
                font-size: 20px;
            }

            .event-wa-button {
                padding: 13px 14px;
                font-size: 14px;
            }
        }

        /* Nama pasangan - gaya undangan premium */
        .partner-names {
            text-align: center;
            margin: 25px auto 10px;
            padding: 0 12px;
            color: #294638;
        }

        .partner-caption {
            display: block;
            margin-bottom: 14px;
            font-family: Arial, sans-serif;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #a58242;
        }

        .partner-names h3 {
            margin: 0;
            font-family: "Cormorant Garamond", Georgia, serif;
            font-size: clamp(25px, 4vw, 38px);
            line-height: 1.3;
            font-weight: 500;
            color: #294638;
            overflow-wrap: anywhere;
        }

        .partner-ampersand {
            display: block;
            margin: 4px 0;
            font-family: Georgia, serif;
            font-size: 30px;
            font-style: italic;
            color: #c8a45d;
            line-height: 1.2;
        }

        .partner-ornament {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin: 18px auto 0;
            color: #c8a45d;
            font-size: 13px;
        }

        .partner-ornament span {
            display: block;
            width: 48px;
            height: 1px;
            background: #c8a45d;
        }

        /* Nama di bawah masing-masing foto pada mode dua foto */
        .partner-photo-card h3 {
            margin: 14px 0 0;
            font-family: "Cormorant Garamond", Georgia, serif;
            font-size: clamp(19px, 2.8vw, 27px);
            line-height: 1.4;
            font-weight: 500;
            color: #294638;
            overflow-wrap: anywhere;
        }

        @media (max-width: 600px) {
            .partner-names {
                margin-top: 20px;
            }

            .partner-caption {
                font-size: 10px;
                letter-spacing: 2px;
            }

            .partner-names h3 {
                font-size: clamp(23px, 6vw, 30px);
            }

            .partner-ampersand {
                font-size: 25px;
            }

            .partner-ornament span {
                width: 35px;
            }

            .partner-photo-card h3 {
                font-size: 18px;
            }
        }

        /* Section undangan upacara utama */
        #upacara-utama {
            padding: 65px 20px 0;
            background: #f8f7f3;
            color: #181818;
            overflow: hidden;
        }

        .ceremony-invitation {
            position: relative;
            max-width: 1100px;
            margin: 0 auto;
        }

        .ceremony-invitation-content {
            position: relative;
            z-index: 1;
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
        }

        .ceremony-mantra {
            margin: 15px 0 22px;
            font-family: serif;
            font-size: clamp(27px, 4vw, 38px);
            color: #25221d;
        }

        .ceremony-opening {
            max-width: 920px;
            margin: 0 auto;
            font-size: 14px;
            line-height: 1.8;
            color: #252525;
        }

        .ceremony-opening em {
            display: inline-block;
            font-family: Georgia, serif;
            margin-top: 3px;
        }

        .ceremony-priests {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 3px;
            font-size: 14px;
            line-height: 1.6;
        }

        .ceremony-priests strong {
            font-weight: 700;
        }

        .ceremony-main-date {
            margin-top: 32px;
        }

        .ceremony-day-name {
            margin: 0 0 12px;
            font-size: 15px;
            font-weight: 600;
        }

        .ceremony-main-date h2 {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: clamp(29px, 4.5vw, 36px);
            line-height: 1.25;
            font-weight: 500;
            letter-spacing: -1px;
        }

        .ceremony-time-main {
            margin: 12px 0 0;
            font-size: clamp(20px, 3vw, 24px);
            font-weight: 500;
        }

        .ceremony-location {
            margin-top: 18px;
            font-size: 14px;
            line-height: 1.5;
        }

        .ceremony-location-title {
            margin: 0;
            font-weight: 600;
        }

        .ceremony-location p:not(.ceremony-location-title) {
            margin: 0 auto;
            max-width: 750px;
        }

        .ceremony-maps-button {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 7px;
            margin-top: 16px;
            padding: 10px 22px;
            min-width: 145px;
            border-radius: 4px;
            background: #d5a72d;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .ceremony-maps-button:hover {
            background: #b88b1d;
            color: #fff;
        }

        .ceremony-map {
            margin: 18px auto 0;
            width: 100%;
            overflow: hidden;
            background: #e8e5dc;
        }

        .ceremony-map iframe {
            display: block;
            width: 100%;
            height: 350px;
            border: 0;
        }

        /* Ornamen sudut */
        .ceremony-ornament {
            position: absolute;
            top: -35px;
            z-index: 0;
            color: #d8b44e;
            opacity: 0.8;
            font-family: Georgia, serif;
            font-size: clamp(100px, 15vw, 190px);
            line-height: 1;
            pointer-events: none;
        }

        .ceremony-ornament-left {
            left: -25px;
            transform: rotate(-35deg);
        }

        .ceremony-ornament-right {
            right: -25px;
            transform: scaleX(-1) rotate(-35deg);
        }

        @media (max-width: 600px) {
            #upacara-utama {
                padding: 45px 16px 0;
            }

            .ceremony-mantra {
                margin-top: 25px;
            }

            .ceremony-opening {
                font-size: 13px;
                line-height: 1.8;
            }

            .ceremony-priests {
                font-size: 13px;
            }

            .ceremony-main-date {
                margin-top: 27px;
            }

            .ceremony-day-name {
                font-size: 13px;
            }

            .ceremony-location {
                font-size: 13px;
            }

            .ceremony-map iframe {
                height: 300px;
            }

            .ceremony-ornament {
                top: -15px;
                font-size: 90px;
                opacity: 0.45;
            }

            .ceremony-ornament-left {
                left: -35px;
            }

            .ceremony-ornament-right {
                right: -35px;
            }
        }

        /* Penutup undangan upacara */
        .ceremony-closing {
            padding: 48px 20px 55px;
            text-align: center;
            background: #f8f7f3;
        }

        .ceremony-closing-message {
            max-width: 620px;
            margin: 0 auto;
            font-size: 14px;
            line-height: 1.9;
            color: #33312d;
        }

        .ceremony-closing-ornament {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            margin-top: 24px;
            color: #bd9844;
        }

        .ceremony-closing-ornament > span:first-child,
        .ceremony-closing-ornament > span:last-child {
            font-family: Georgia, serif;
            font-size: 28px;
        }

        .ceremony-closing-ornament > span:first-child {
            transform: scaleX(-1);
        }

        .ceremony-closing-ornament .closing-mantra {
            font-family: serif;
            font-size: clamp(20px, 3.5vw, 30px);
            line-height: 1.6;
            color: #28251f;
        }

        @media (max-width: 600px) {
            .ceremony-closing {
                padding: 35px 18px 42px;
            }

            .ceremony-closing-message {
                font-size: 13px;
            }

            .ceremony-closing-ornament {
                gap: 10px;
                margin-top: 20px;
            }

            .ceremony-closing-ornament > span:first-child,
            .ceremony-closing-ornament > span:last-child {
                font-size: 22px;
            }

            .ceremony-closing-ornament .closing-mantra {
                font-size: 20px;
            }
        }
        .ceremony-mantra {
            /* margin: 15px 0 22px; */
            padding-bottom:40px;
            font-family: "Noto Sans Balinese", serif;
            font-size: clamp(36px, 6vw, 20px);
            line-height: 1.8;
            color: #171717;
            text-align: center;
        }
        .ceremony-closing-ornament .closing-mantra {
            font-family: "Noto Sans Balinese", serif;
            font-size: clamp(28px, 5vw, 20px);
            line-height: 1.8;
            color: #171717;
            white-space: nowrap;
        }

        /* Tipografi Upacara Utama - selaras dengan Dudonan Acara */
        #upacara-utama {
            font-family: Georgia, "Times New Roman", serif;
            color: #294638;
        }

        #upacara-utama .ceremony-opening {
            font-family: Georgia, "Times New Roman", serif;
            font-size: 14px;
            line-height: 1.9;
            color: #3c463d;
        }

        #upacara-utama .ceremony-priests {
            font-family: Georgia, "Times New Roman", serif;
            font-size: 15px;
            line-height: 1.7;
            color: #294638;
        }

        #upacara-utama .ceremony-main-date h2 {
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(28px, 4vw, 36px);
            font-weight: 600;
            color: #294638;
        }

        #upacara-utama .ceremony-day-name {
            font-family: Georgia, "Times New Roman", serif;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
            color: #725b32;
        }

        #upacara-utama .ceremony-time-main {
            font-family: Georgia, "Times New Roman", serif;
            font-size: 21px;
            color: #294638;
        }

        #upacara-utama .ceremony-location {
            font-family: Georgia, "Times New Roman", serif;
            font-size: 14px;
            line-height: 1.8;
        }

        #upacara-utama .ceremony-location-title {
            color: #a58242;
            font-weight: 700;
            letter-spacing: 2px;
        }

        #upacara-utama .ceremony-closing-message {
            font-family: Georgia, "Times New Roman", serif;
            font-size: 14px;
            line-height: 1.9;
            color: #3c463d;
        }

        #upacara-utama .ceremony-mantra,
        #upacara-utama .closing-mantra {
            font-family: "Noto Sans Balinese", serif;
            color: #294638;
            text-align: center;
        }

        #upacara-utama .ceremony-mantra {
            font-size: clamp(36px, 6vw, 48px);
            line-height: 1.8;
        }

        #upacara-utama .closing-mantra {
            font-size: clamp(28px, 5vw, 42px);
            line-height: 1.8;
            margin: 0;
        }

        @media (max-width: 600px) {
            #upacara-utama .ceremony-opening,
            #upacara-utama .ceremony-closing-message {
                font-size: 13px;
            }

            #upacara-utama .ceremony-priests {
                font-size: 14px;
            }

            #upacara-utama .ceremony-time-main {
                font-size: 19px;
            }
        }

        #prawartaka-karya {
            position: relative;
            overflow: hidden;
            padding: 45px 20px 75px;
            color: #25231f;
            background:
                radial-gradient(ellipse at center, #fffefa 0%, #f6f3e9 75%);
        }

        .prawartaka-inner {
            position: relative;
            z-index: 1;
            max-width: 900px;
            margin: 0 auto;
        }

        /* Ornamen dekoratif sudut */
        #prawartaka-karya::before,
        #prawartaka-karya::after {
            content: "❦";
            position: absolute;
            top: 10px;
            color: #d8cfb4;
            opacity: 0.18;
            font-family: Georgia, serif;
            font-size: clamp(150px, 28vw, 360px);
            line-height: 1;
            pointer-events: none;
        }

        #prawartaka-karya::before {
            left: -75px;
            transform: rotate(-35deg);
        }

        #prawartaka-karya::after {
            right: -75px;
            transform: scaleX(-1) rotate(-35deg);
        }

        .prawartaka-details {
            max-width: 760px;
            margin: 0 auto 32px;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.55;
        }

        .prawartaka-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 17px;
        }

        .prawartaka-group p {
            margin: 0 0 2px;
        }

        .prawartaka-group strong {
            font-weight: 700;
        }

        .prawartaka-organization {
            max-width: 100%;
            overflow-wrap: anywhere;
        }

        .guru-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
            max-width: 730px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.68);
        }

        .guru-card {
            min-width: 0;
            overflow: hidden;
            border-radius: 40px 40px 0 0;
            background: #fff;
            box-shadow: 0 3px 14px rgba(0, 0, 0, 0.07);
        }

        .guru-card img {
            display: block;
            width: 100%;
            aspect-ratio: 3 / 4;
            object-fit: cover;
            object-position: center top;
        }

        .guru-caption {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 58px;
            padding: 7px 4px;
            text-align: center;
            color: #fff;
            background: linear-gradient(110deg, #6b4144, #3c1018 50%, #6b4144);
            font-family: Georgia, serif;
            line-height: 1.35;
        }

        .guru-caption span {
            font-size: 16px;
        }

        .guru-caption strong {
            font-size: 16px;
            font-weight: 600;
        }

        @media (max-width: 600px) {
            #prawartaka-karya {
                padding: 35px 14px 45px;
            }

            .prawartaka-details {
                font-size: 13px;
                margin-bottom: 22px;
            }

            .prawartaka-group {
                margin-bottom: 15px;
            }

            .guru-grid {
                gap: 9px;
                padding: 9px;
            }

            .guru-card {
                border-radius: 23px 23px 0 0;
            }

            .guru-caption {
                min-height: 50px;
                padding: 5px 2px;
            }

            .guru-caption span,
            .guru-caption strong {
                font-size: clamp(10px, 2.8vw, 14px);
            }
        }


        #form-ucapan .rsvp-field {
            margin-bottom: 20px;
            text-align: left;
        }

        #form-ucapan .rsvp-field label {
            display: block;
            margin-bottom: 7px;
            color: #294638;
            font-weight: 600;
        }

        #form-ucapan .rsvp-field input,
        #form-ucapan .rsvp-field textarea {
            display: block;
            width: 100%;
            box-sizing: border-box;
            padding: 12px 14px;
            border: 1px solid #d8d0c3;
            border-radius: 8px;
            background: #fffdf8;
            color: #294638;
            font: inherit;
        }

        #form-ucapan .rsvp-field textarea {
            min-height: 120px;
            resize: vertical;
        }

        #form-ucapan .rsvp-field input:focus,
        #form-ucapan .rsvp-field textarea:focus {
            outline: 2px solid #c8a45d;
            outline-offset: 1px;
        }

        #form-ucapan button {
            max-width: 100%;
        }

        @media (max-width: 600px) {
            #form-ucapan .rsvp-field input,
            #form-ucapan .rsvp-field textarea {
                font-size: 16px;
            }

            #form-ucapan button {
                width: 100%;
            }
        }

        .message-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 6px 12px;
            margin-bottom: 10px;
        }

        .message-header > strong {
            color: #294638;
            font-size: 15px;
        }

        .message-time {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #888477;
            font-size: 12px;
            white-space: nowrap;
        }

        .message-content {
            margin: 0;
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        @media (max-width: 480px) {
            .message-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .message-time {
                font-size: 11px;
            }
        }

        .message-pagination {
            display: flex;
            justify-content: center;
            margin-top: 24px;
        }

        .message-pagination nav {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .message-pagination svg {
            width: 18px;
            height: 18px;
        }

        .bali-pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 24px;
            font-family: Georgia, serif;
        }

        .bali-pagination .page-number,
        .bali-pagination .page-arrow {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 10px;
            border: 1px solid #d8c9a7;
            border-radius: 8px;
            color: #294638;
            background: #f8f7f3;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .bali-pagination .page-number:hover,
        .bali-pagination .page-arrow:hover {
            background: #e9e0ce;
        }

        .bali-pagination .page-number.active {
            background: #294638;
            color: #fff;
            border-color: #294638;
        }

        .bali-pagination .disabled {
            opacity: 0.4;
        }

        .bali-pagination .page-dots {
            color: #817761;
        }

        .matur-suksma {
            margin-top: 24px;
            color: #294638;
            font-family: Georgia, serif;
            font-size: 30px;
            font-weight: 400;
            font-style: italic;
            text-align: center;
            letter-spacing: 1px;
        }

        .matur-suksma::before {
            content: "✦";
            display: block;
            margin-bottom: 12px;
            color: #c8a45d;
            font-size: 18px;
        }
        .music-toggle {
            position: fixed;
            right: 20px;
            bottom: 24px;
            z-index: 9999;
            width: 48px;
            height: 48px;
            border: 1px solid #c8a45d;
            border-radius: 50%;
            background: #294638;
            color: #fff;
            font-size: 25px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
        }

        .music-toggle.playing {
            animation: music-spin 4s linear infinite;
        }

        @keyframes music-spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

    </style>
</head>

<body>
    <header class="hero">
        @if ($invitation->cover_image)
            <img
                class="hero-photo"
                src="{{ \Illuminate\Support\Facades\Storage::url($invitation->cover_image) }}"
                alt=""
            >
        @endif

        <div class="hero-content">
            @if ($invitation->logo_path)
                <div class="invitation-logo">
                    <img
                        src="{{ asset('storage/' . $invitation->logo_path) }}"
                        alt="Logo {{ $invitation->title }}"
                    >
                </div>
            @endif
            <!-- <div class="eyebrow">Undangan {{ $invitation->event_type }}</div> -->
             <div class="eyebrow">{{ $invitation->event_type }}</div>

            <!-- <p>Om Swastyastu</p> -->

            <h1>{{ $invitation->venue_name }}</h1>
            @if ($invitation->event_starts_at)
                <p class="hero-date">
                    {{ $invitation->event_starts_at
                        ->locale('id')->translatedFormat('l, d F Y') }}
                </p>
            @endif
            <div class="ornament">✦ ❧ ✦</div>

            

            

            @if ($guest)
                <div class="guest-label">
                    Majeng ring<br>
                    <div class="guest-name">
                        <strong>{{ $guest->name }}</strong>
                    </div>
                </div>
            @endif

            <div style="margin-top: 30px">
                <button type="button" class="button" id="bukaUndangan">
                    Buka Undangan ↓
                </button>
            </div>
        </div>
    </header>

    <main>
        <section class="section" id="pembuka"
            @if ($invitation->cover_image)
                style="background-image: url('{{ \Illuminate\Support\Facades\Storage::url($invitation->cover_image) }}');"
            @endif
        >
            <div class="section-inner intro">
                <div class="section-heading">
                    <div class="text-uppercase">
                        <p>{{ $invitation->event_type }}</p>
                    </div>
                    <div class="couple text-uppercase text-big">
                        <p>{{ $invitation->venue_name }}</p>
                    </div>
                    <div class="gold-line"></div>
                    <p>{{ $invitation->address }}</p>
                    @if ($invitation->event_starts_at)
                        <p>
                            {{ $invitation->event_starts_at
                                ->locale('id')->translatedFormat('l, d F Y') }}
                        </p>
                    @endif
                </div>

            </div>
            <div class="section-wave" aria-hidden="true">
                <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
                    <path
                        d="M0,65 C240,120 480,10 720,55
                        C960,100 1200,115 1440,45
                        L1440,120 L0,120 Z"
                        fill="#eee7d9"
                    />
                </svg>
            </div>
        </section>

        @if ($invitation->events->isNotEmpty())
            <section class="section events" id="phadiksan">
                <div class="section-inner">
                    @if ($invitation->logo_path)
                        <div class="invitation-logo">
                            <img
                                src="{{ asset('storage/' . $invitation->logo_path) }}"
                                alt="Logo {{ $invitation->title }}"
                            >
                        </div>
                    @endif
                    <div class="section-heading">
                        <h3 class="text-uppercase pb-0">{{ $invitation->event_type }}</h3>
                        <h2 class="text-uppercase">{{ $invitation->venue_name }}</h2>
                        <p>{{ $invitation->address}}</p>
                        @if ($invitation->event_starts_at)
                            <p>
                                {{ $invitation->event_starts_at
                                    ->locale('id')->translatedFormat('l, d F Y') }}
                            </p>
                        @endif
                    </div>
                    @if (
                        ($invitation->partner_photo_mode === 'single' && $invitation->couple_photo)
                        || ($invitation->partner_photo_mode === 'double'
                            && ($invitation->partner_photo_1 || $invitation->partner_photo_2))
                    )
                        <section class="section partner-photos" id="partner">
                            <div class="section-inner">

                                @if ($invitation->partner_photo_mode === 'single')
                                    <div class="couple-photo-card">
                                        <img
                                            src="{{ asset('storage/' . $invitation->couple_photo) }}"
                                            alt="{{ $invitation->host_name }} dan {{ $invitation->partner_name }}"
                                            loading="lazy"
                                        >

                                        <div class="partner-names">
                                            <!-- <span class="partner-caption">Mepandesang / Pasangan</span> -->

                                            <h3>{{ $invitation->host_name }}</h3>

                                            <span class="partner-ampersand">&amp;</span>

                                            <h3>{{ $invitation->partner_name }}</h3>

                                            <!-- <div class="partner-ornament">
                                                <span></span>
                                                ✦
                                                <span></span>
                                            </div> -->
                                        </div>
                                    </div>
                                @else
                                    <div class="partner-photo-grid">
                                        @if ($invitation->partner_photo_1)
                                            <div class="partner-photo-card">
                                                <img
                                                    src="{{ asset('storage/' . $invitation->partner_photo_1) }}"
                                                    alt="{{ $invitation->host_name }}"
                                                    loading="lazy"
                                                >

                                                <h3>{{ $invitation->host_name }}</h3>
                                            </div>
                                        @endif

                                        @if ($invitation->partner_photo_2)
                                            <div class="partner-photo-card">
                                                <img
                                                    src="{{ asset('storage/' . $invitation->partner_photo_2) }}"
                                                    alt="{{ $invitation->partner_name }}"
                                                    loading="lazy"
                                                >

                                                <h3>{{ $invitation->partner_name }}</h3>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                            </div>
                        </section>
                    @endif
                </div>
                
            </section>
            <section class="section" id="dudonan-acara">
                <div class="section-inner">

                    <div class="event-program">
                        <div class="event-program-heading">
                            <p class="event-eyebrow">Rangkaian Kegiatan</p>
                            <h2>Dudonan Acara</h2>
                            <div class="gold-line"></div>

                            @if ($invitation->event_starts_at)
                                <p class="event-date">
                                    {{ $invitation->event_starts_at
                                        ->locale('id')->translatedFormat('l, d F Y') }}
                                </p>
                            @endif
                        </div>

                        <div class="event-program-card">
                            <ol class="event-program-list">
                                <li>Pembukaan</li>
                                <li>Tari-tarian</li>
                                <li>Sambutan-sambutan</li>
                                <li>Pembacaan SK</li>
                                <li>Sambutan Utama</li>
                                <li>Katuran Boga Samatra</li>
                                <li>Hiburan</li>
                            </ol>
                        </div>

                        <div class="event-notes">
                            <h3>Catatan Kehadiran</h3>

                            <ul>
                                <li>Pakaian Adat Madya</li>
                                <li>Mohon hadir 15 menit sebelum acara dimulai</li>
                            </ul>

                            <div class="event-contact">
                                <span>Nomor Info Konfirmasi</span>
                                <strong>{{ $invitation->whatsapp_number }}</strong>
                            </div>

                            @php
                                $waNumber = preg_replace(
                                    '/\D/',
                                    '',
                                    $invitation->whatsapp_number ?? ''
                                );

                                if (str_starts_with($waNumber, '0')) {
                                    $waNumber = '62' . substr($waNumber, 1);
                                } elseif (str_starts_with($waNumber, '8')) {
                                    $waNumber = '62' . $waNumber;
                                }

                                $waMessage = 'Om Swastyastu, saya ingin mengonfirmasi kehadiran pada acara '
                                    . $invitation->title
                                    . ' tanggal '
                                    . ($invitation->event_starts_at
                                        ? $invitation->event_starts_at
                                            ->locale('id')->translatedFormat('d F Y')
                                        : '')
                                    . '. Terima kasih.';
                            @endphp

                            @if ($waNumber)
                                <a
                                    class="event-wa-button"
                                    href="https://wa.me/{{ $waNumber }}?text={{ urlencode($waMessage) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <svg
                                        viewBox="0 0 24 24"
                                        width="20"
                                        height="20"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path d="M20.52 3.48A11.86 11.86 0 0 0 12.07 0C5.5 0 .16 5.34.16 11.91c0 2.1.55 4.15 1.6 5.96L0 24l6.29-1.65a11.9 11.9 0 0 0 5.78 1.47h.01C18.65 23.82 24 18.48 24 11.91c0-3.17-1.24-6.15-3.48-8.43ZM12.08 21.8h-.01a9.87 9.87 0 0 1-5.03-1.38l-.36-.21-3.73.98 1-3.64-.23-.37a9.83 9.83 0 0 1-1.51-5.27c0-5.44 4.43-9.87 9.88-9.87 2.64 0 5.12 1.03 6.99 2.9a9.82 9.82 0 0 1 2.89 6.99c0 5.44-4.43 9.87-9.89 9.87Zm5.42-7.39c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.8-1.49-1.79-1.67-2.09-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.48-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.49 0 1.47 1.07 2.89 1.22 3.09.15.2 2.1 3.2 5.08 4.49.71.31 1.27.5 1.7.64.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2.01-1.42.25-.7.25-1.3.17-1.42-.07-.13-.27-.2-.57-.35Z"/>
                                    </svg>
                                    Konfirmasi via WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="section" id="upacara">
                <div class="section-inner">
                    <div class="section-heading">
                        <p class="ceremony-eyebrow">Rangkaian Karya</p>
                        <h2>Dudonan Upacara</h2>
                        <div class="gold-line"></div>
                        <!-- <p class="ceremony-intro">
                            Berikut adalah rangkaian dudonan upacara
                            Karya Padhiksan.
                        </p> -->
                    </div>

                    <div class="ceremony-timeline">

                        @php
                            $dudonan = [
                                [
                                    'date' => '15 Sep 2026',
                                    'items' => [
                                        ['time' => '16.30', 'title' => 'Matur Piuning ring Pemerajan Griya'],
                                        ['time' => '', 'title' => 'Gurubendu Piduka'],
                                        ['time' => '', 'title' => 'Ngadegan Bhatara Rsi Ring Purwaning Daksina'],
                                        ['time' => '', 'title' => 'Mejaya-jaya Panitia'],
                                    ],
                                ],
                                [
                                    'date' => '30 Sep 2026',
                                    'items' => [
                                        ['time' => '09.00', 'title' => 'Dewasa Naceb Tetaring lan sanggah bilang bucu'],
                                        ['time' => '', 'title' => 'Mekarya Uperenge, Piranti Yadnya'],
                                        ['time' => '', 'title' => 'Ngewastra lan Ngias'],
                                    ],
                                ],
                                [
                                    'date' => '02 Okt 2026',
                                    'items' => [
                                        ['time' => '09.00', 'title' => 'Nunas Tirta Penginsahan'],
                                        ['time' => '', 'title' => 'Nunas Tirta Pekuluh'],
                                    ],
                                ],
                                [
                                    'date' => '03 Okt 2026',
                                    'items' => [
                                        ['time' => '09.00', 'title' => 'Negtegang Manik Galih'],
                                        ['time' => '', 'title' => 'Ngingsah'],
                                        ['time' => '', 'title' => 'Ngadegan Sanggah Pengrajeg Karya, Tapini, Guru Dadi lan Rare Anggon'],
                                    ],
                                ],
                                [
                                    'date' => '11 Okt 2026',
                                    'items' => [
                                        ['time' => '08.00', 'title' => 'Nunas Tirta'],
                                    ],
                                ],
                                [
                                    'date' => '12 Okt 2026',
                                    'items' => [
                                        ['time' => '09.00', 'title' => 'Mecaru'],
                                        ['time' => '', 'title' => 'Panca Mustika'],
                                        ['time' => '', 'title' => 'Jempong Asu'],
                                        ['time' => '', 'title' => 'Melaspas'],
                                        ['time' => '', 'title' => 'Uparenge'],
                                        ['time' => '', 'title' => 'Siwa Upakarane, Busana Kawikon'],
                                    ],
                                ],
                                [
                                    'date' => '15 Okt 2026',
                                    'items' => [
                                        ['time' => '09.00', 'title' => 'Suci Laksana'],
                                        ['time' => '', 'title' => 'Melukat'],
                                        ['time' => '', 'title' => 'Mepinton'],
                                        ['time' => '21.00', 'title' => 'Turu ring lemah'],
                                    ],
                                ],
                                [
                                    'date' => '16 Okt 2026',
                                    'items' => [
                                        ['time' => '21.00', 'title' => 'Suci Laksana — Turu ring lemah'],
                                    ],
                                ],
                                [
                                    'date' => '17 Okt 2026',
                                    'items' => [
                                        ['time' => '21.00', 'title' => 'Suci Laksana — Turu ring lemah'],
                                    ],
                                ],
                                [
                                    'date' => '18 Okt 2026',
                                    'items' => [
                                        ['time' => '09.00', 'title' => 'Ngelukar Suci Laksana Sembah lan Mepamit'],
                                        ['time' => '', 'title' => 'Rama-Rena'],
                                        ['time' => '', 'title' => 'Sanak Kadang'],
                                    ],
                                ],
                                [
                                    'date' => '19 Okt 2026',
                                    'items' => [
                                        ['time' => '09.00', 'title' => 'Mepinton ring Guru Nabe'],
                                        ['time' => '', 'title' => 'Guru Waktra'],
                                        ['time' => '', 'title' => 'Guru Saksi'],
                                    ],
                                ],
                                [
                                    'date' => '20 Okt 2026',
                                    'items' => [
                                        ['time' => '09.00', 'title' => 'Mepinton ring Kahyangan Tiga'],
                                    ],
                                ],
                                [
                                    'date' => '21 Okt 2026',
                                    'items' => [
                                        ['time' => '09.00', 'title' => 'Mono Bratha'],
                                        ['time' => '', 'title' => 'Ngelukar Mono Bratha'],
                                        ['time' => '17.00', 'title' => 'Mepinton lan Mejaya-jaya'],
                                        ['time' => '20.00', 'title' => 'Mecaru Bumi Sudha'],
                                        ['time' => '22.00', 'title' => 'Nyeda Raga (Tapa, Yoga, Semadi)'],
                                    ],
                                ],
                                [
                                    'date' => '22 Okt 2026',
                                    'items' => [
                                        ['time' => '03.00', 'title' => 'Atetangi'],
                                        ['time' => '04.00', 'title' => 'Mesuci lan Busana Wiku'],
                                        ['time' => '06.00', 'title' => 'Padiksan'],
                                        ['time' => '09.00', 'title' => 'Seremonial'],
                                    ],
                                ],
                                [
                                    'date' => '25 Okt 2026',
                                    'items' => [
                                        ['time' => '09.00', 'title' => 'Tangkil Ring Tri Guru'],
                                    ],
                                ],
                                [
                                    'date' => '03 Des 2026',
                                    'items' => [
                                        ['time' => '10.00', 'title' => 'Ngelinggihang Weda'],
                                        ['time' => '', 'title' => 'Pembubaran Panitia Kab. Badung'],
                                    ],
                                ],
                                [
                                    'date' => '06 Des 2026',
                                    'items' => [
                                        ['time' => '09.00', 'title' => 'Tangkil Ring Tri Guru'],
                                    ],
                                ],
                            ];
                        @endphp

                        @foreach ($dudonan as $day)
                            <article class="ceremony-day">
                                <div class="ceremony-date">
                                    <span class="date-icon">✦</span>
                                    <span>{{ $day['date'] }}</span>
                                </div>

                                <div class="ceremony-card">
                                    @foreach ($day['items'] as $item)
                                        <div class="ceremony-item">
                                            @if ($item['time'])
                                                <span class="ceremony-time">
                                                    {{ $item['time'] }}
                                                </span>
                                            @else
                                                <span class="ceremony-time ceremony-time-empty"></span>
                                            @endif

                                            <span class="ceremony-name">
                                                {{ $item['title'] }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </article>
                        @endforeach

                    </div>
                </div>
            </section>
            
        @endif

        <section class="section" id="upacara-utama">
            <div class="ceremony-invitation">

                {{-- Ornamen dekoratif --}}
                <div class="ceremony-ornament ceremony-ornament-left" aria-hidden="true">❧</div>
                <div class="ceremony-ornament ceremony-ornament-right" aria-hidden="true">❧</div>

                <div class="ceremony-invitation-content">

                    <p class="ceremony-mantra">ᬒᬁ ᬲ᭄ᬯᬲ᭄ᬢ᭄ᬬᬲ᭄ᬢᬸ᭟</p>

                    <p class="ceremony-opening">
                        Melarapan manah hening lan suci tur sangkaning asung
                        kertha wara nugraha Ida Sang Hyang Widhi Wasa,
                        mapiranti sewalapatra puniki tityang ngulemin Ratu,
                        Ida, Dane sinareng sami, mangda ledang ugi
                        ngrawuhin tur micayang pangrastiti lan pangestu
                        pemargin <em>“Karya Padhiksan”</em>
                    </p>

                    <div class="ceremony-priests">
                        <strong>{{ $invitation->host_name}}</strong>
                        <strong>{{ $invitation->partner_name }}</strong>
                        <span>sane pacang kemargi anggen nemoning :</span>
                    </div>

                    <div class="ceremony-main-date">
                        <p class="ceremony-day-name">WRESPATI PAING DUKUT (KAMIS)</p>

                        @if ($invitation->event_starts_at)
                            <h2>
                                {{ strtoupper(
                                    $invitation->event_starts_at
                                        ->locale('id')
                                        ->translatedFormat('d F Y')
                                ) }}
                            </h2>
                        @endif

                        <p class="ceremony-time-main">09.00 WITA - PUPUT</p>
                    </div>

                    <div class="ceremony-location">
                        <p class="ceremony-location-title">GENAH</p>
                        <p>{{ $invitation->address }}</p>

                        @if ($invitation->maps_url)
                            <a
                                href="{{ $invitation->maps_url }}"
                                class="ceremony-maps-button"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <svg viewBox="0 0 24 24" width="18" height="18"
                                    fill="currentColor" aria-hidden="true">
                                    <path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5Z"/>
                                </svg>
                                Google Maps
                            </a>
                        @endif
                    </div>

                    {{-- Peta otomatis berdasarkan alamat --}}
                    @if ($invitation->address)
                        <div class="ceremony-map">
                            <iframe
                                src="https://maps.google.com/maps?q={{ urlencode($invitation->address) }}&output=embed"
                                width="100%"
                                height="350"
                                style="border:0"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen
                                title="Peta lokasi {{ $invitation->venue_name }}"
                            ></iframe>
                        </div>
                    @endif
                    <div class="ceremony-closing">
                        <p class="ceremony-closing-message">
                            Inggih, wantah asapunika uleman tityang puniki,
                            dumogi je Ratu, Ida, Dane sinareng sami prasida rawuh.
                        </p>

                        <div class="ceremony-closing-ornament" aria-hidden="true">
                            <!-- <span>❧</span> -->
                            <p class="closing-mantra">ᬒᬁ ᬰᬵᬦ᭄ᬢᬶᬄ ᬰᬵᬦ᭄ᬢᬶᬄ ᬰᬵᬦ᭄ᬢᬶᬄ᭟</p>
                            <!-- <span>❧</span> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        

        @if ($invitation->galleries->isNotEmpty())
            <section class="section" id="galeri">
                <div class="section-inner">
                    <div class="section-heading">
                        <h2>Galeri</h2>
                        <p>Momen istimewa yang ingin kami bagikan.</p>
                    </div>

                    <div class="gallery-grid">
                        @foreach ($invitation->galleries as $photo)
                            <div class="gallery-item">
                                <img
                                    src="{{ \Illuminate\Support\Facades\Storage::url($photo->file_path) }}"
                                    alt="{{ $photo->caption ?: 'Foto galeri undangan' }}"
                                    loading="lazy"
                                >
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif


        <section class="section" id="prawartaka-karya">
            <div class="prawartaka-inner">

                <div class="prawartaka-details">
                    <div class="prawartaka-group">
                        <strong>Prawartaka Karya</strong>
                        <p>Penglingsir</p>
                        <strong>Guru Bagus Rai Waisnawa</strong>
                    </div>

                    <div class="prawartaka-group">
                        <p>Manggala Karya</p>
                        <strong>Guru I Ketut Semara</strong>
                    </div>

                    <div class="prawartaka-group">
                        <p>Turut mengundang:</p>
                        <strong class="prawartaka-organization">
                            MONCOL PUSAT MAHA WARGA BHUJANGGA WAISNAWA
                        </strong>
                    </div>

                    <div class="prawartaka-group">
                        <p>Ketua Umum</p>
                        <strong>Guru Drs. I Gede Alit Widana, SH, M.Si</strong>
                        <strong>Bridjen Polisi (Purn)</strong>
                    </div>
                </div>

                <div class="guru-grid">

                    <article class="guru-card">
                        <img
                            src="{{ asset('images/guru-saksi.jpeg') }}"
                            alt="Pinaka Guru Saksi"
                            loading="lazy"
                        >
                        <div class="guru-caption">
                            <span>Pinaka</span>
                            <strong>Guru Saksi</strong>
                        </div>
                    </article>

                    <article class="guru-card">
                        <img
                            src="{{ asset('images/guru-nabe.jpeg') }}"
                            alt="Pinaka Guru Nabe Tapak"
                            loading="lazy"
                        >
                        <div class="guru-caption">
                            <span>Pinaka</span>
                            <strong>Guru Nabe Tapak</strong>
                        </div>
                    </article>

                    <article class="guru-card">
                        <img
                            src="{{ asset('images/guru-waktra.jpeg') }}"
                            alt="Pinaka Guru Waktra"
                            loading="lazy"
                        >
                        <div class="guru-caption">
                            <span>Pinaka</span>
                            <strong>Guru Waktra</strong>
                        </div>
                    </article>

                </div>
            </div>
        </section>


        
        @if ($invitation->show_messages)
            <section class="section events" id="ucapan">
                <div class="section-inner">
                    <div class="section-heading">
                        <h2>Ucapan & Doa</h2>
                        <p>Bagikan doa terbaik dan konfirmasi kehadiran Anda.</p>
                    </div>

                    @if (session('success'))
                        <div class="message-card" role="status"
                            style="margin-bottom:24px">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="message-card" role="alert"
                            style="margin-bottom:24px">
                            <strong>Mohon periksa kembali data Anda.</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    
                    <form
                        id="form-ucapan"
                        class="location-card"
                        method="POST"
                        action="{{ route('invitations.messages.store', ['slug' => $invitation->slug]) }}"
                    >
                        @csrf

                        @if ($guest)
                            <input
                                type="hidden"
                                name="guest_token"
                                value="{{ $guest->token }}"
                            >
                        @endif

                        <div class="rsvp-field">
                            <label for="guest_name">Nama</label>
                            <input
                                id="guest_name"
                                name="guest_name"
                                type="text"
                                maxlength="100"
                                value="{{ old('guest_name', $guest?->name) }}"
                                {{ $guest ? 'readonly' : '' }}
                                required
                                placeholder="Masukkan nama Anda"
                            >
                        </div>

                        <div class="rsvp-field">
                            <label for="message">Ucapan dan doa</label>
                            <textarea
                                id="message"
                                name="message"
                                maxlength="1000"
                                rows="5"
                                required
                                placeholder="Tuliskan ucapan dan doa terbaik Anda..."
                            >{{ old('message') }}</textarea>
                        </div>

                        <button class="button" type="submit">
                            Kirim Ucapan & Doa
                        </button>
                    </form>


                    <div style="margin-top:40px">
                        <!-- <div class="section-heading">
                            <h2>Doa dari Para Tamu</h2> -->
                    </div>
                    <div id="message-section">
                        <div class="message-list">
                            @forelse ($messages as $message)
                                <article class="message-card">
                                    <div class="message-header">
                                        <strong>{{ $message->guest_name }}</strong>

                                        <span class="message-time">
                                            {{ $message->created_at
                                                ->locale('id')
                                                ->translatedFormat('d M Y, H:i') }}
                                            WITA
                                        </span>
                                    </div>

                                    @if ($message->message)
                                        <p class="message-content">{{ $message->message }}</p>
                                    @endif
                                </article>
                            @empty
                                <p style="text-align:center;color:var(--muted)">
                                    Jadilah yang pertama memberikan ucapan dan doa.
                                </p>
                            @endforelse
                        </div>


                        @if ($messages->hasPages())
                            <div class="message-pagination">
                                {{ $messages->onEachSide(1)->links('vendor.pagination.baliutsava') }}
                            </div>
                        @endif
                    </div>
                        
                </div>
                <br>
                <h3 class="matur-suksma">Matur Suksma</h3>
            </section>
        @endif

    </main>

    <footer class="footer">
        <div class="ornament">✦ ❧ ✦</div>
        <p>{{ $invitation->title }} - {{ $invitation->venue_name }}</p>
        <small>www.baliutsava.com | @2026</small>
    </footer>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const splash = document.querySelector('.hero');
    const tombol = document.getElementById('bukaUndangan');

    if (!splash || !tombol) return;

    // Kunci scroll saat splash screen tampil
    document.body.classList.add('splash-active');

    tombol.addEventListener('click', function () {
        // Cegah tombol ditekan berulang kali
        tombol.disabled = true;

        // Hilangkan splash screen
        splash.classList.add('splash-closed');
        document.body.classList.remove('splash-active');

        // Hapus splash setelah animasi selesai
        setTimeout(function () {
            splash.remove();
        }, 650);
    });
});
</script>
@if ($invitation->music_path)
<script>
document.addEventListener('DOMContentLoaded', function () {
    const music = document.getElementById('background-music');
    const button = document.getElementById('music-toggle');
    const icon = document.getElementById('music-icon');

    if (!music || !button || !icon) return;

    music.volume = 0.5;

    function updateButton() {
        const playing = !music.paused;

        icon.textContent = playing ? '♫' : '♪';
        button.classList.toggle('playing', playing);
        button.setAttribute(
            'aria-label',
            playing ? 'Matikan musik' : 'Putar musik'
        );
        button.title = playing ? 'Matikan musik' : 'Putar musik';
    }

    // Coba putar otomatis ketika halaman undangan dibuka
    music.play()
        .then(updateButton)
        .catch(function () {
            // Autoplay diblokir browser; pengunjung bisa menekan tombol
            updateButton();
        });

    button.addEventListener('click', function () {
        if (music.paused) {
            music.play()
                .then(updateButton)
                .catch(function (error) {
                    console.error('Musik gagal diputar:', error);
                });
        } else {
            music.pause();
            updateButton();
        }
    });

    music.addEventListener('play', updateButton);
    music.addEventListener('pause', updateButton);
});
</script>

@endif
<script>
document.addEventListener('DOMContentLoaded', function () {
    const bukaUndangan = document.getElementById('bukaUndangan');
    const music = document.getElementById('background-music');

    if (!bukaUndangan || !music) return;

    music.volume = 0.5;

    bukaUndangan.addEventListener('click', function () {
        music.play().catch(function (error) {
            console.warn('Musik gagal diputar:', error);
        });
    });
});
</script>

@if ($invitation->music_path)
    <audio id="background-music" loop preload="auto">
        <source
            src="{{ asset('storage/' . $invitation->music_path) }}"
            type="audio/mpeg"
        >
    </audio>

    <button
        type="button"
        id="music-toggle"
        class="music-toggle"
        aria-label="Putar musik"
        title="Putar musik"
    >
        <span id="music-icon">♫</span>
    </button>
@endif
</body>
</html>
