{{-- 
    Partial: Ucapan & Doa untuk tema Superior Modern
    Simpan sebagai:
    resources/views/invitations/partials/superior-messages.blade.php

    Variabel yang digunakan:
    - $invitation
    - $guest (opsional)
    - $messages (Collection, opsional)

    Catatan:
    Nama route/form mengikuti pola Laravel umum. Jika aplikasi Anda memakai
    route atau nama kolom berbeda, sesuaikan bagian action dan field di bawah.
--}}

<section class="sm-section sm-messages-section" id="ucapan-doa">
    <p class="sm-eyebrow">Love &amp; Wishes</p>
    <h2>Ucapan &amp; Doa</h2>
    <p class="sm-description sm-messages-intro">
        Setiap doa dan ucapan Anda adalah hadiah berharga bagi kami.
    </p>

    <div class="sm-message-form-wrap">
        <h3 class="sm-message-form-title">Kirim Ucapan</h3>
        <p class="sm-muted">Sampaikan doa terbaik Anda untuk kedua mempelai.</p>

        @if (session('success'))
            <div class="sm-message-alert sm-message-alert-success" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="sm-message-alert sm-message-alert-error" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        
        <form
            class="sm-message-form"
            id="form-ucapan"
            method="POST"
            action="{{ route('invitations.messages.store', ['slug' => $invitation->slug]) }}"
        >
            @csrf

            @if (isset($guest) && !empty($guest->token))
                <input
                    type="hidden"
                    name="guest_token"
                    value="{{ $guest->token }}"
                >
            @endif

            <div class="sm-form-field">
                <label for="sm-message-name">Nama Anda</label>
                <input
                    id="sm-message-name"
                    type="text"
                    name="guest_name"
                    value="{{ old('guest_name', $guest->name ?? request('to') ?? '') }}"
                    placeholder="Tuliskan nama Anda"
                    maxlength="100"
                    autocomplete="name"
                    required
                >
                @error('guest_name')
                    <small class="sm-message-field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="sm-form-field">
                <label for="sm-message-text">Ucapan &amp; doa</label>
                <textarea
                    id="sm-message-text"
                    name="message"
                    rows="4"
                    maxlength="1000"
                    placeholder="Tuliskan ucapan dan doa terbaik..."
                    required
                >{{ old('message') }}</textarea>
                @error('message')
                    <small class="sm-message-field-error">{{ $message }}</small>
                @enderror
            </div>

            <button class="sm-open-button sm-message-submit" type="submit">
                Kirim Ucapan <span aria-hidden="true">♡</span>
            </button>
        </form>

    </div>

    <div class="sm-message-list-wrap">
        <h3 class="sm-message-list-title text-center">Ucapan dari Keluarga &amp; Sahabat</h3>

        @php
            $superiorMessages = isset($messages) ? $messages : collect();
        @endphp

        @forelse ($superiorMessages as $message)
            @php
                $messageName = data_get($message, 'name')
                    ?? data_get($message, 'guest_name')
                    ?? data_get($message, 'guest.name')
                    ?? 'Tamu Undangan';

                $messageText = data_get($message, 'message')
                    ?? data_get($message, 'content')
                    ?? data_get($message, 'body')
                    ?? '';

                $messageDate = data_get($message, 'created_at');
                $attendance = data_get($message, 'attendance');
            @endphp

            <article class="sm-message-card">
                <div class="sm-message-card-top">
                    <span class="sm-message-heart" aria-hidden="true">♡</span>
                    <strong>{{ $messageName }}</strong>
                </div>

                @if ($messageText !== '')
                    <p class="sm-message-text">{{ $messageText }}</p>
                @endif

                <!-- @if ($attendance)
                    <span class="sm-message-attendance">
                        {{ $attendance === 'hadir' ? 'Akan hadir' : ($attendance === 'tidak_hadir' ? 'Berhalangan hadir' : $attendance) }}
                    </span>
                @endif -->

                @if ($messageDate)
                    <time class="sm-message-date" datetime="{{ \Illuminate\Support\Carbon::parse($messageDate)->toIso8601String() }}">
                        {{ \Illuminate\Support\Carbon::parse($messageDate)->translatedFormat('d F Y') }}
                    </time>
                @endif
            </article>
        @empty
            <div class="sm-message-empty">
                <span aria-hidden="true">♡</span>
                <p>Belum ada ucapan. Jadilah yang pertama menyampaikan doa terbaik.</p>
            </div>
        @endforelse
    </div>
</section>

<style>
    .sm-messages-section {
        text-align: center;
        overflow-wrap: anywhere;
    }

    .sm-messages-section,
    .sm-messages-section * {
        box-sizing: border-box;
    }

    .sm-messages-section .sm-messages-intro {
        max-width: 480px;
        margin: 0 auto 30px;
    }

    .sm-message-form-wrap,
    .sm-message-list-wrap {
        width: 100%;
        max-width: 620px;
        margin: 0 auto;
        text-align: left;
    }

    .sm-message-form-wrap {
        padding: clamp(20px, 4vw, 30px);
        border: 1px solid var(--sm-line, #e6d9ca);
        background: rgba(255, 253, 249, .82);
    }

    .sm-message-form-title,
    .sm-message-list-title {
        margin: 0 0 8px;
        color: var(--sm-ink, #30231f);
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 27px;
        font-weight: 600;
        line-height: 1.2;
    }

    .sm-message-form-wrap > .sm-muted {
        margin: 0 0 22px;
        line-height: 1.6;
    }

    .sm-message-form {
        display: grid;
        gap: 17px;
        width: 100%;
        min-width: 0;
    }

    .sm-form-field {
        display: grid;
        gap: 7px;
        width: 100%;
        min-width: 0;
    }

    .sm-form-field label {
        color: #5b4539;
        font-size: 12px;
        font-weight: 600;
    }

    .sm-form-field input,
    .sm-form-field textarea,
    .sm-form-field select {
        display: block;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        margin: 0;
        padding: 12px 13px;
        border: 1px solid #dfd0bf;
        border-radius: 2px;
        outline: none;
        background: #fffdf9;
        color: var(--sm-ink, #30231f);
        font: 400 13px/1.55 'DM Sans', sans-serif;
        box-shadow: none;
    }

    .sm-form-field textarea {
        min-height: 112px;
        resize: vertical;
    }

    .sm-form-field input:focus,
    .sm-form-field textarea:focus,
    .sm-form-field select:focus {
        border-color: #a98760;
        box-shadow: 0 0 0 3px rgba(169, 135, 96, .13);
    }

    .sm-message-submit {
        justify-self: start;
        max-width: 100%;
        background: var(--sm-brown, #382821);
        white-space: normal;
    }

    .sm-message-alert {
        margin: 0 0 18px;
        padding: 12px 14px;
        border: 1px solid #dfd0bf;
        font-size: 12px;
        line-height: 1.6;
    }

    .sm-message-alert-success {
        background: #f0f5ec;
        color: #35513a;
    }

    .sm-message-alert-error {
        background: #fff0ed;
        color: #853d35;
    }

    .sm-message-alert ul {
        margin: 0;
        padding-left: 18px;
    }

    .sm-message-list-wrap {
        margin-top: 42px;
    }

    .sm-message-list-title {
        margin-bottom: 18px;
    }

    .sm-message-card {
        margin: 0 0 12px;
        padding: 18px 20px;
        border: 1px solid var(--sm-line, #e6d9ca);
        background: #fffdf9;
    }

    .sm-message-card-top {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #5b4033;
        font-size: 13px;
    }

    .sm-message-heart {
        color: #a98760;
        font-size: 20px;
        line-height: 1;
    }

    .sm-message-text {
        margin: 12px 0 8px;
        color: var(--sm-muted, #87766a);
        font-size: 13px;
        line-height: 1.75;
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    .sm-message-attendance,
    .sm-message-date {
        display: inline-block;
        margin: 5px 10px 0 0;
        color: #987550;
        font-size: 10px;
    }

    .sm-message-empty {
        padding: 24px 18px;
        border: 1px dashed #d8c5af;
        color: var(--sm-muted, #87766a);
        text-align: center;
    }

    .sm-message-empty > span {
        color: #a98760;
        font-size: 25px;
    }

    .sm-message-empty p {
        margin: 8px 0 0;
        font-size: 12px;
        line-height: 1.6;
    }

    @media (max-width: 900px) {
        .sm-message-form-wrap,
        .sm-message-list-wrap {
            max-width: none;
        }

        .sm-message-form-wrap {
            padding: 20px 16px;
        }

        .sm-message-submit {
            justify-self: stretch;
            width: 100%;
        }
    }
    .text-center{
        text-align:center;
    }
    .sm-message-field-error {
        color: #a3332b;
        font-size: 12px;
    }
</style>
