
@if ($invitation->show_gifts)
    @php
        $activeGifts = $invitation->gifts->where('is_active', true);

        $waNumber = preg_replace(
            '/\D+/',
            '',
            $invitation->whatsapp_number ?? ''
        );

        if (str_starts_with($waNumber, '0')) {
            $waNumber = '62' . substr($waNumber, 1);
        }
    @endphp

    @if ($activeGifts->isNotEmpty())
        <section class="modern-section modern-gifts" id="hadiah">
            <div class="modern-gift-heading">
                <span class="modern-gift-eyebrow">TANDA KASIH</span>

                <h2>{{ $invitation->gift_title ?: 'Hadiah Digital' }}</h2>

                <div class="modern-gift-divider">
                    <span></span>
                    <span class="modern-gift-divider-icon">✦</span>
                    <span></span>
                </div>

                <p class="modern-gift-description">
                    {{ $invitation->gift_description
                        ?: 'Doa dan restu Anda merupakan hadiah terindah bagi kami. Bagi yang ingin berbagi tanda kasih, dapat melalui rekening berikut.' }}
                </p>
            </div>

            <div class="modern-gift-list">
                @foreach ($activeGifts as $gift)
                    <article class="modern-gift-card">
                        <div class="modern-gift-card-top">
                            @if ($gift->bank_logo)
                                <div class="modern-gift-bank-logo">
                                    <img
                                        src="{{ asset('storage/' . $gift->bank_logo) }}"
                                        alt="Logo {{ $gift->bank_name }}"
                                        loading="lazy"
                                    >
                                </div>
                            @else
                                <div class="modern-gift-bank-placeholder">
                                    <span>✧</span>
                                </div>
                            @endif

                            <div class="modern-gift-bank-info">
                                <h3>{{ $gift->bank_name }}</h3>
                                <span>Rekening bank</span>
                            </div>

                            <span class="modern-gift-card-icon">✦</span>
                        </div>

                        <div class="modern-gift-card-body">
                            <p class="modern-gift-label">NOMOR REKENING</p>

                            <div class="modern-gift-number-row">
                                <p class="modern-gift-number">
                                    {{ $gift->account_number }}
                                </p>

                                <button
                                    type="button"
                                    class="modern-gift-copy-icon"
                                    data-copy="{{ $gift->account_number }}"
                                    aria-label="Salin nomor rekening {{ $gift->bank_name }}"
                                    title="Salin nomor rekening"
                                >
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <rect x="8" y="8" width="12" height="12" rx="2"></rect>
                                        <path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="modern-gift-holder">
                                <span>a.n.</span>
                                <strong>{{ $gift->account_holder }}</strong>
                            </div>
                        </div>

                        <div class="modern-gift-actions">
                            <button
                                type="button"
                                class="modern-gift-button modern-gift-button-primary"
                                data-copy="{{ $gift->account_number }}"
                            >
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="8" y="8" width="12" height="12" rx="2"></rect>
                                    <path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3"></path>
                                </svg>
                                <span>Salin Rekening</span>
                            </button>

                            @if ($waNumber)
                                <a
                                    class="modern-gift-button modern-gift-button-secondary"
                                    href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo, saya ingin mengonfirmasi hadiah untuk ' . $invitation->title . '.') }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M21 11.5a8.4 8.4 0 0 1-12.8 7.2L3 20l1.3-5.1A8.4 8.4 0 1 1 21 11.5Z"></path>
                                        <path d="M8.5 9.2c.5 2.3 2.1 3.9 4.4 4.5l1.1-1.1 2 .9c-.2 1.2-1.1 2-2.4 1.9-3.5-.4-6.4-3.3-6.8-6.8-.1-1.3.7-2.2 1.9-2.4l.9 2-1.1 1Z"></path>
                                    </svg>
                                    <span>Konfirmasi</span>
                                </a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            <p
                class="modern-gift-feedback"
                id="giftCopyFeedback"
                aria-live="polite"
                role="status"
            ></p>
        </section>

        
        <style>
            /* SECTION HADIAH */
            #hadiah.modern-gifts {
                position: relative;
                width: 100%;
                margin: 0;
                padding: 80px 24px;
                box-sizing: border-box;
                background: #faf9f6;
                color: #34483d;
                text-align: center;
            }

            /* JUDUL SECTION */
            #hadiah .modern-gift-heading {
                width: 100%;
                max-width: 600px;
                margin: 0 auto 36px;
                text-align: center;
            }

            .modern-gift-eyebrow {
                display: block;
                margin-bottom: 12px;
                color: #718477;
                font-size: 10px;
                font-weight: 600;
                letter-spacing: 3px;
            }

            .modern-gift-heading h2 {
                margin: 0;
                color: #34483d;
                font-family: Georgia, 'Times New Roman', serif;
                font-size: clamp(32px, 5vw, 44px);
                font-weight: 400;
            }

            .modern-gift-divider {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                margin: 18px auto;
            }

            .modern-gift-divider span:not(.modern-gift-divider-icon) {
                width: 32px;
                height: 1px;
                background: #c9a96a;
            }

            .modern-gift-divider-icon {
                color: #c9a96a;
                font-size: 13px;
            }

            #hadiah .modern-gift-description {
                max-width: 480px;
                margin: 0 auto;
                color: #77746e;
                font-size: 14px;
                line-height: 1.8;
                text-align: center;
            }

            /* DAFTAR KARTU: SELALU DI TENGAH */
            #hadiah .modern-gift-list {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: stretch;
                gap: 24px;

                width: 100%;
                max-width: 1100px;
                margin: 0 auto;
                padding: 0;
                box-sizing: border-box;
            }

            /* KARTU REKENING */
            #hadiah .modern-gift-card {
                flex: 0 1 690px;
                width: 100%;
                max-width: 100%;
                min-width: 0;
                margin: 0;
                padding: 26px 22px;
                box-sizing: border-box;

                background: #fff;
                border: 1px solid #c9a96a;
                border-radius: 12px;
                text-align: center;

                transition: border-color .2s ease;
            }

            #hadiah .modern-gift-card:hover {
                border-color: #b18d4d;
            }

            /* INFORMASI BANK */
            .modern-gift-card-top {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 12px;
                padding-bottom: 20px;
                border-bottom: 1px solid #eeeae2;
            }

            .modern-gift-bank-logo,
            .modern-gift-bank-placeholder {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 88px;
                height: 56px;
                padding: 6px;
                box-sizing: border-box;
                background: #fff;
                border: 1px solid #f0eee8;
                border-radius: 8px;
            }

            .modern-gift-bank-logo img {
                display: block;
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .modern-gift-bank-placeholder {
                color: #c9a96a;
                font-size: 24px;
            }

            .modern-gift-bank-info h3 {
                margin: 0 0 5px;
                color: #34483d;
                font-family: Georgia, 'Times New Roman', serif;
                font-size: 22px;
                font-weight: 400;
                overflow-wrap: anywhere;
            }

            .modern-gift-bank-info > span {
                color: #89867f;
                font-size: 12px;
            }

            .modern-gift-card-icon {
                display: none;
            }

            /* NOMOR REKENING */
            .modern-gift-card-body {
                padding: 22px 0;
            }

            .modern-gift-label {
                margin: 0 0 8px;
                color: #89867f;
                font-size: 10px;
                letter-spacing: 1.5px;
            }

            .modern-gift-number-row {
                display: flex;
                align-items: center;
                justify-content: center;
                flex-wrap: wrap;
                gap: 8px;
                max-width: 100%;
            }

            .modern-gift-number {
                max-width: 100%;
                margin: 0;
                color: #34483d;
                font-size: clamp(19px, 2.5vw, 24px);
                font-weight: 600;
                overflow-wrap: anywhere;
                word-break: break-word;
            }

            .modern-gift-copy-icon {
                display: inline-flex;
                flex: 0 0 32px;
                align-items: center;
                justify-content: center;
                width: 32px;
                height: 32px;
                padding: 7px;
                color: #718477;
                background: #faf9f6;
                border: 1px solid #e8e4db;
                border-radius: 50%;
                cursor: pointer;
            }

            .modern-gift-copy-icon svg,
            .modern-gift-button svg {
                width: 16px;
                height: 16px;
                fill: none;
                stroke: currentColor;
                stroke-width: 1.7;
                stroke-linecap: round;
                stroke-linejoin: round;
            }

            .modern-gift-holder {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 5px;
                margin-top: 12px;
                color: #89867f;
                font-size: 13px;
                overflow-wrap: anywhere;
            }

            .modern-gift-holder strong {
                color: #4b514a;
                font-weight: 600;
            }

            /* TOMBOL AKSI */
            #hadiah .modern-gift-actions {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
            }

            .modern-gift-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 7px;
                min-height: 42px;
                padding: 10px 18px;
                border: 1px solid #c9a96a;
                border-radius: 24px;
                font-family: inherit;
                font-size: 12px;
                font-weight: 500;
                text-decoration: none;
                cursor: pointer;
                transition: background .2s ease, color .2s ease;
            }

            .modern-gift-button-primary {
                color: #fff;
                background: #34483d;
                border-color: #34483d;
            }

            .modern-gift-button-primary:hover {
                color: #fff;
                background: #26382e;
            }

            .modern-gift-button-secondary {
                color: #34483d;
                background: transparent;
            }

            .modern-gift-button-secondary:hover {
                background: #f5f0e6;
            }

            .modern-gift-feedback {
                min-height: 20px;
                margin: 16px auto 0;
                color: #718477;
                font-size: 12px;
                text-align: center;
            }

            /* TABLET DAN HP */
            @media (max-width: 600px) {
                #hadiah.modern-gifts {
                    padding: 56px 18px;
                }

                #hadiah .modern-gift-heading {
                    margin-bottom: 28px;
                }

                #hadiah .modern-gift-list {
                    gap: 16px;
                }

                #hadiah .modern-gift-card {
                    flex-basis: 100%;
                    padding: 24px 18px;
                }

                .modern-gift-number {
                    font-size: clamp(18px, 5vw, 23px);
                }

                .modern-gift-button {
                    padding: 10px 15px;
                }
            }

            @media (max-width: 360px) {
                #hadiah .modern-gift-actions {
                    flex-direction: column;
                }

                #hadiah .modern-gift-button {
                    width: 100%;
                    box-sizing: border-box;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .modern-gift-card,
                .modern-gift-button {
                    transition: none;
                }
            }
        </style>


        <script>
            (() => {
                if (window.__modernGiftCopyInitialized) return;
                window.__modernGiftCopyInitialized = true;

                document.addEventListener('click', async (event) => {
                    const button = event.target.closest('[data-copy]');
                    if (!button) return;

                    const number = button.dataset.copy;
                    const feedback = document.getElementById('giftCopyFeedback');

                    try {
                        if (navigator.clipboard && window.isSecureContext) {
                            await navigator.clipboard.writeText(number);
                        } else {
                            const textarea = document.createElement('textarea');
                            textarea.value = number;
                            textarea.style.position = 'fixed';
                            textarea.style.opacity = '0';
                            document.body.appendChild(textarea);
                            textarea.select();

                            const copied = document.execCommand('copy');
                            textarea.remove();

                            if (!copied) throw new Error('Copy gagal');
                        }

                        if (feedback) feedback.textContent = 'Nomor rekening berhasil disalin.';

                        document.querySelectorAll('[data-copy]').forEach((item) => {
                            const label = item.querySelector('span');

                            if (label && item.classList.contains('modern-gift-button-primary')) {
                                label.textContent = item === button
                                    ? 'Berhasil Disalin!'
                                    : 'Salin Rekening';
                            }
                        });

                        window.setTimeout(() => {
                            document.querySelectorAll('.modern-gift-button-primary span')
                                .forEach((label) => {
                                    label.textContent = 'Salin Rekening';
                                });

                            if (feedback) feedback.textContent = '';
                        }, 2500);
                    } catch (error) {
                        if (feedback) {
                            feedback.textContent =
                                'Tidak dapat menyalin otomatis. Silakan salin nomor rekening secara manual.';
                        }
                    }
                });
            })();
        </script>
    @endif
@endif
