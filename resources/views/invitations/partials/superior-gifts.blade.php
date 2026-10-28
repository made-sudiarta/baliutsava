{{-- 
    Partial: Hadiah untuk tema Superior Modern
    Simpan sebagai:
    resources/views/invitations/partials/superior-gift.blade.php

    Menggunakan data yang sama dengan partial hadiah Modern Minimalis:
    $invitation->show_gifts, gifts, whatsapp_number, gift_title, gift_description.
--}}

@if ($invitation->show_gifts)
    @php
        $activeSuperiorGifts = $invitation->gifts->where('is_active', true);

        $superiorWaNumber = preg_replace(
            '/\D+/',
            '',
            $invitation->whatsapp_number ?? ''
        );

        if (str_starts_with($superiorWaNumber, '0')) {
            $superiorWaNumber = '62' . substr($superiorWaNumber, 1);
        }
    @endphp

    @if ($activeSuperiorGifts->isNotEmpty())
        <section class="sm-section sm-gifts" id="hadiah">
            <header class="sm-gift-heading">
                <p class="sm-eyebrow">Tanda Kasih</p>
                <h2>{{ $invitation->gift_title ?: 'Hadiah Digital' }}</h2>

                <div class="sm-gift-divider" aria-hidden="true">
                    <span></span><b>✦</b><span></span>
                </div>

                <p class="sm-gift-description">
                    {{ $invitation->gift_description
                        ?: 'Doa dan restu Anda merupakan hadiah terindah bagi kami. Bagi yang ingin berbagi tanda kasih, dapat melalui rekening berikut.' }}
                </p>
            </header>

            <div class="sm-gift-list">
                @foreach ($activeSuperiorGifts as $gift)
                    <article class="sm-gift-card">
                        <div class="sm-gift-card-top">
                            @if ($gift->bank_logo)
                                <div class="sm-gift-bank-logo">
                                    <img
                                        src="{{ asset('storage/' . $gift->bank_logo) }}"
                                        alt="Logo {{ $gift->bank_name }}"
                                        loading="lazy"
                                    >
                                </div>
                            @else
                                <div class="sm-gift-bank-placeholder" aria-hidden="true">✧</div>
                            @endif

                            <div class="sm-gift-bank-info">
                                <h3>{{ $gift->bank_name }}</h3>
                                <span>Rekening bank</span>
                            </div>
                        </div>

                        <div class="sm-gift-card-body">
                            <p class="sm-gift-label">Nomor rekening</p>

                            <div class="sm-gift-number-row">
                                <p class="sm-gift-number">{{ $gift->account_number }}</p>

                                <button
                                    type="button"
                                    class="sm-gift-copy-icon"
                                    data-sm-gift-copy="{{ $gift->account_number }}"
                                    aria-label="Salin nomor rekening {{ $gift->bank_name }}"
                                    title="Salin nomor rekening"
                                >
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <rect x="8" y="8" width="12" height="12" rx="2"></rect>
                                        <path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="sm-gift-holder">
                                <span>a.n.</span>
                                <strong>{{ $gift->account_holder }}</strong>
                            </div>
                        </div>

                        <div class="sm-gift-actions">
                            <button
                                type="button"
                                class="sm-gift-button sm-gift-button-primary"
                                data-sm-gift-copy="{{ $gift->account_number }}"
                            >
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="8" y="8" width="12" height="12" rx="2"></rect>
                                    <path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3"></path>
                                </svg>
                                <span>Salin Rekening</span>
                            </button>

                            @if ($superiorWaNumber)
                                <a
                                    class="sm-gift-button sm-gift-button-secondary"
                                    href="https://wa.me/{{ $superiorWaNumber }}?text={{ urlencode('Halo, saya ingin mengonfirmasi hadiah untuk ' . $invitation->title . '.') }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                   <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M20.52 3.48A11.78 11.78 0 0 0 12.04 0C5.5 0 .18 5.32.18 11.86c0 2.09.55 4.13 1.6 5.93L.08 24l6.37-1.67a11.8 11.8 0 0 0 5.59 1.42h.01c6.54 0 11.86-5.32 11.86-11.86 0-3.17-1.23-6.15-3.39-8.41Z"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.3"
                                            stroke-linejoin="round"
                                        />
                                        <path
                                            d="M8.5 7.2c-.3 0-.6.2-.8.5-.3.4-.8 1-.8 2.1 0 1.2.8 2.4.9 2.6.1.2 1.7 2.7 4.2 3.7 2.1.8 2.5.6 3 .5.5-.1 1.5-.6 1.7-1.2.2-.6.2-1.1.1-1.2-.1-.1-.3-.2-.6-.3l-1.8-.9c-.2-.1-.4-.1-.5.2l-.7.9c-.1.2-.3.2-.5.1-.3-.1-1.1-.4-1.9-1.2-.7-.6-1.1-1.3-1.3-1.6-.1-.2 0-.3.1-.5l.4-.5c.1-.1.2-.3.2-.4.1-.2 0-.3 0-.5l-.8-1.9c-.2-.4-.4-.4-.6-.4Z"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.3"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                    <span>Konfirmasi</span>
                                </a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            <p class="sm-gift-feedback" id="smGiftCopyFeedback" aria-live="polite" role="status"></p>
        </section>

        <style>
            #hadiah.sm-gifts {
                width: 100%;
                margin: 0;
                padding: 64px clamp(18px, 5%, 44px);
                background: var(--sm-white, #fffdf9);
                color: var(--sm-ink, #30231f);
                text-align: center;
                overflow: hidden;
            }

            #hadiah.sm-gifts,
            #hadiah.sm-gifts * {
                box-sizing: border-box;
            }

            #hadiah .sm-gift-heading {
                width: 100%;
                max-width: 560px;
                margin: 0 auto 32px;
            }

            #hadiah .sm-gift-heading .sm-eyebrow {
                margin-bottom: 10px;
                color: #987550;
                font-size: 10px;
                font-weight: 600;
                letter-spacing: .2em;
                text-transform: uppercase;
            }

            #hadiah .sm-gift-heading h2 {
                margin: 8px 0 18px;
                color: #49352c;
                font-family: 'Cormorant Garamond', Georgia, serif;
                font-size: clamp(30px, 4vw, 40px);
                font-weight: 500;
                line-height: 1.15;
                overflow-wrap: anywhere;
            }

            #hadiah .sm-gift-divider {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                margin: 16px auto;
                color: #b9956b;
            }

            #hadiah .sm-gift-divider span {
                width: 34px;
                height: 1px;
                background: #c9a96a;
            }

            #hadiah .sm-gift-divider b {
                font-size: 13px;
                font-weight: 400;
            }

            #hadiah .sm-gift-description {
                max-width: 480px;
                margin: 0 auto;
                color: var(--sm-muted, #87766a);
                font-size: 12px;
                line-height: 1.85;
            }

            #hadiah .sm-gift-list {
                display: grid;
                grid-template-columns: minmax(0, 1fr);
                gap: 16px;
                width: 100%;
                max-width: 560px;
                margin: 0 auto;
            }

            #hadiah .sm-gift-card {
                min-width: 0;
                width: 100%;
                padding: clamp(20px, 4vw, 28px);
                border: 1px solid #dfcfb8;
                border-radius: 4px;
                background: #fff;
                text-align: center;
                box-shadow: 0 8px 24px rgba(56, 40, 33, .035);
            }

            #hadiah .sm-gift-card-top {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 10px;
                padding-bottom: 18px;
                border-bottom: 1px solid #eee7dd;
            }

            #hadiah .sm-gift-bank-logo,
            #hadiah .sm-gift-bank-placeholder {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 82px;
                height: 54px;
                padding: 6px;
                border: 1px solid #eee7dd;
                border-radius: 4px;
                background: #fff;
            }

            #hadiah .sm-gift-bank-logo img {
                display: block;
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            #hadiah .sm-gift-bank-placeholder {
                color: #b9956b;
                font-size: 24px;
            }

            #hadiah .sm-gift-bank-info h3 {
                margin: 0 0 4px;
                color: #49352c;
                font-family: 'Cormorant Garamond', Georgia, serif;
                font-size: 25px;
                font-weight: 600;
                line-height: 1.2;
                overflow-wrap: anywhere;
            }

            #hadiah .sm-gift-bank-info span {
                color: var(--sm-muted, #87766a);
                font-size: 11px;
            }

            #hadiah .sm-gift-card-body {
                padding: 20px 0;
            }

            #hadiah .sm-gift-label {
                margin: 0 0 8px;
                color: var(--sm-muted, #87766a);
                font-size: 9px;
                letter-spacing: .16em;
                text-transform: uppercase;
            }

            #hadiah .sm-gift-number-row {
                display: flex;
                align-items: center;
                justify-content: center;
                flex-wrap: wrap;
                gap: 8px;
                max-width: 100%;
            }

            #hadiah .sm-gift-number {
                max-width: 100%;
                margin: 0;
                color: #49352c;
                font-size: clamp(17px, 2.3vw, 23px);
                font-weight: 600;
                line-height: 1.4;
                overflow-wrap: anywhere;
                word-break: break-word;
            }

            #hadiah .sm-gift-copy-icon {
                display: inline-flex;
                flex: 0 0 32px;
                align-items: center;
                justify-content: center;
                width: 32px;
                height: 32px;
                padding: 7px;
                border: 1px solid #e8dfd2;
                border-radius: 50%;
                background: #faf6f0;
                color: #765b4b;
                cursor: pointer;
            }

            #hadiah .sm-gift-copy-icon svg,
            #hadiah .sm-gift-button svg {
                width: 16px;
                height: 16px;
                fill: none;
                stroke: currentColor;
                stroke-width: 1.7;
                stroke-linecap: round;
                stroke-linejoin: round;
                flex: 0 0 auto;
            }

            #hadiah .sm-gift-holder {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 5px;
                margin-top: 10px;
                color: var(--sm-muted, #87766a);
                font-size: 12px;
                overflow-wrap: anywhere;
            }

            #hadiah .sm-gift-holder strong {
                color: #49352c;
                font-weight: 600;
            }

            #hadiah .sm-gift-actions {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
            }

            #hadiah .sm-gift-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 7px;
                min-height: 42px;
                max-width: 100%;
                padding: 10px 16px;
                border: 1px solid #b9956b;
                border-radius: 3px;
                font: 500 11px/1.4 'DM Sans', sans-serif;
                text-decoration: none;
                cursor: pointer;
                overflow-wrap: anywhere;
            }

            #hadiah .sm-gift-button-primary {
                background: #382821;
                color: #fff8ef;
                border-color: #382821;
            }

            #hadiah .sm-gift-button-primary:hover {
                background: #6f343b;
                border-color: #6f343b;
            }

            #hadiah .sm-gift-button-secondary {
                background: transparent;
                color: #49352c;
            }

            #hadiah .sm-gift-button-secondary:hover {
                background: #f8f1e8;
            }

            #hadiah .sm-gift-feedback {
                min-height: 20px;
                margin: 14px auto 0;
                color: #765b4b;
                font-size: 11px;
                line-height: 1.5;
            }

            @media (max-width: 380px) {
                #hadiah.sm-gifts {
                    padding: 48px 16px;
                }

                #hadiah .sm-gift-card {
                    padding: 20px 15px;
                }

                #hadiah .sm-gift-actions {
                    flex-direction: column;
                }

                #hadiah .sm-gift-button {
                    width: 100%;
                }
            }

            .sm-gift-confirm-btn svg {
                width: 15px;
                height: 15px;
                flex-shrink: 0;
                display: block;
            }
        </style>

        <script>
            (() => {
                if (window.__superiorGiftCopyInitialized) return;
                window.__superiorGiftCopyInitialized = true;

                document.addEventListener('click', async (event) => {
                    const button = event.target.closest('[data-sm-gift-copy]');
                    if (!button) return;

                    const accountNumber = button.dataset.smGiftCopy;
                    const feedback = document.getElementById('smGiftCopyFeedback');

                    try {
                        if (navigator.clipboard && window.isSecureContext) {
                            await navigator.clipboard.writeText(accountNumber);
                        } else {
                            const textarea = document.createElement('textarea');
                            textarea.value = accountNumber;
                            textarea.style.position = 'fixed';
                            textarea.style.opacity = '0';
                            document.body.appendChild(textarea);
                            textarea.select();
                            const copied = document.execCommand('copy');
                            textarea.remove();

                            if (!copied) throw new Error('Copy gagal');
                        }

                        if (feedback) feedback.textContent = 'Nomor rekening berhasil disalin.';

                        document.querySelectorAll('[data-sm-gift-copy] .sm-gift-copy-label')
                            .forEach((label) => label.textContent = 'Salin Rekening');

                        document.querySelectorAll('.sm-gift-button-primary').forEach((item) => {
                            const label = item.querySelector('span');
                            if (label) {
                                label.textContent = item === button
                                    ? 'Berhasil Disalin!'
                                    : 'Salin Rekening';
                            }
                        });

                        window.setTimeout(() => {
                            document.querySelectorAll('.sm-gift-button-primary span')
                                .forEach((label) => label.textContent = 'Salin Rekening');
                            if (feedback) feedback.textContent = '';
                        }, 2500);
                    } catch (error) {
                        if (feedback) {
                            feedback.textContent = 'Tidak dapat menyalin otomatis. Silakan salin nomor rekening secara manual.';
                        }
                    }
                });
            })();
        </script>
    @endif
@endif
