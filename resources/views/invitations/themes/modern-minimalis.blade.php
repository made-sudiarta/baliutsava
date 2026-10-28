
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $invitation->title }}</title>

    <link rel="stylesheet" href="{{ asset('css/themes/modern-minimalis.css') }}">
</head>
<body>

    
    <header class="modern-cover" id="coverUndangan">
        @if ($invitation->cover_image)
            <img
                class="modern-cover-image"
                src="{{ asset('storage/' . $invitation->cover_image) }}"
                alt="Sampul undangan"
            >
        @endif

        <div class="modern-cover-content">
            
            <p class="modern-eyebrow">UNDANGAN</p>

            @if ($invitation->logo_path)
                <div class="modern-invitation-logo">
                    <img
                        src="{{ asset('storage/' . $invitation->logo_path) }}"
                        alt="{{ $invitation->title }}"
                    >
                </div>
            @else
                <h1>{{ $invitation->title }}</h1>
            @endif

            <p class="modern-host">
                {{ $invitation->host_name }}

                @if ($invitation->partner_name)
                    <span>&amp;</span>
                    {{ $invitation->partner_name }}
                @endif
            </p>


            @if ($invitation->event_starts_at)
                <p class="modern-date">
                    {{ $invitation->event_starts_at
                        ->locale('id')
                        ->translatedFormat('l, d F Y') }}
                </p>
            @endif

            
            <button type="button" class="modern-button" id="bukaUndangan">
                Buka Undangan ↓
            </button>
        </div>
    </header>

    <main id="isiUndangan">


        <section class="modern-section modern-intro">
            <p class="modern-eyebrow">DENGAN RASA SYUKUR</p>
            @if ($invitation->logo_path)
                <div class="modern-invitation-logo">
                    <img
                        src="{{ asset('storage/' . $invitation->logo_path) }}"
                        alt="{{ $invitation->title }}"
                    >
                </div>
            @else
                <h2>{{ $invitation->title }}</h2>
            @endif

            @if ($invitation->description)
                <div class="modern-description">
                    {!! $invitation->description !!}
                </div>
            @endif

            
            {{-- Informasi Bride & Groom --}}
            <div class="modern-couple">
                <div class="modern-couple-divider">
                    <span></span>
                    <span class="modern-couple-heart">♥</span>
                    <span></span>
                </div>

                @if ($invitation->partner_photo_mode === 'single')
                    {{-- Mode foto bersama --}}
                    @if ($invitation->couple_photo)
                        <div class="modern-couple-shared-photo">
                            <img
                                src="{{ asset('storage/' . $invitation->couple_photo) }}"
                                alt="{{ $invitation->host_name }} dan {{ $invitation->partner_name }}"
                                loading="lazy"
                            >
                        </div>
                    @endif

                    <div class="modern-couple-info">
                        <div class="modern-couple-person">
                            <p class="modern-couple-label">Mempelai Pria</p>
                            <h3>{{ $invitation->host_name }}</h3>
                        </div>

                        <div class="modern-couple-ampersand">&</div>

                        <div class="modern-couple-person">
                            <p class="modern-couple-label">Mempelai Wanita</p>
                            <h3>{{ $invitation->partner_name }}</h3>
                        </div>
                    </div>

                @else
                    {{-- Mode dua foto terpisah --}}
                    <div class="modern-couple-info">
                        <div class="modern-couple-person">
                            @if ($invitation->partner_photo_1)
                                <div class="modern-couple-photo">
                                    <img
                                        src="{{ asset('storage/' . $invitation->partner_photo_1) }}"
                                        alt="{{ $invitation->host_name }}"
                                        loading="lazy"
                                    >
                                </div>
                            @endif

                            <p class="modern-couple-label">Mempelai Pria</p>
                            <h3>{{ $invitation->host_name }}</h3>
                        </div>

                        <div class="modern-couple-ampersand">&</div>

                        <div class="modern-couple-person">
                            @if ($invitation->partner_photo_2)
                                <div class="modern-couple-photo">
                                    <img
                                        src="{{ asset('storage/' . $invitation->partner_photo_2) }}"
                                        alt="{{ $invitation->partner_name }}"
                                        loading="lazy"
                                    >
                                </div>
                            @endif

                            <p class="modern-couple-label">Mempelai Wanita</p>
                            <h3>{{ $invitation->partner_name }}</h3>
                        </div>
                    </div>
                @endif

                <p class="modern-couple-caption">
                    Together with our families, we invite you to celebrate our special day.
                </p>
            </div>

        </section>


        
        @if ($invitation->events->isNotEmpty())
            <section class="modern-section modern-countdown-section">
                <p class="modern-eyebrow">SAVE THE DATE</p>
                <h2>Menuju Hari Bahagia</h2>
                <p class="modern-countdown-intro">
                    Kami menantikan kehadiran Anda di hari istimewa kami.
                </p>

                @php
                    $countdownEvent = $invitation->events
                        ->whereNotNull('starts_at')
                        ->sortBy('starts_at')
                        ->first();
                @endphp

                @if ($countdownEvent)
                    <div
                        class="modern-countdown"
                        id="modernCountdown"
                        data-start="{{ $countdownEvent->starts_at->toIso8601String() }}"
                    >
                        <div class="modern-countdown-item">
                            <span id="countdownDays">00</span>
                            <small>Hari</small>
                        </div>

                        <div class="modern-countdown-item">
                            <span id="countdownHours">00</span>
                            <small>Jam</small>
                        </div>

                        <div class="modern-countdown-item">
                            <span id="countdownMinutes">00</span>
                            <small>Menit</small>
                        </div>

                        <div class="modern-countdown-item">
                            <span id="countdownSeconds">00</span>
                            <small>Detik</small>
                        </div>
                    </div>

                    <p class="modern-countdown-date">
                        {{ $countdownEvent->starts_at
                            ->locale('id')
                            ->translatedFormat('l, d F Y · H:i') }} WITA
                    </p>

                    <p id="countdownMessage" class="modern-countdown-message"></p>
                @endif
            </section>
        @endif


        
        @if ($invitation->venue_name || $invitation->address)
            <section class="modern-section modern-location" id="lokasi">
                <p class="modern-eyebrow">LOKASI ACARA</p>

                <h2>{{ $invitation->venue_name }}</h2>

                @if ($invitation->address)
                    <p class="modern-location-address">
                        {{ $invitation->address }}
                    </p>
                @endif

                @if ($invitation->maps_url)
                    <div class="modern-map-wrapper">
                        <iframe
                            src="https://maps.google.com/maps?q={{ urlencode($invitation->address ?: $invitation->venue_name) }}&output=embed"
                            width="100%"
                            height="300"
                            style="border:0;"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Peta lokasi acara">
                        </iframe>
                    </div>

                    <a
                        class="modern-button modern-map-button"
                        href="{{ $invitation->maps_url }}"
                        target="_blank"
                        rel="noopener noreferrer">
                        ↗ Buka Petunjuk Arah
                    </a>
                @endif
            </section>
        @endif


        @if ($invitation->galleries->isNotEmpty())
            <section class="modern-section">
                <p class="modern-eyebrow">MOMEN</p>
                <h2>Galeri</h2>

                <div class="modern-gallery">
                    @foreach ($invitation->galleries as $gallery)
                        <figure>
                            <img
                                src="{{ asset('storage/' . $gallery->file_path) }}"
                                alt="{{ $gallery->caption ?: 'Foto galeri' }}"
                                loading="lazy"
                            >

                            @if ($gallery->caption)
                                <figcaption>{{ $gallery->caption }}</figcaption>
                            @endif
                        </figure>
                    @endforeach
                </div>
            </section>
        @endif

        @include('invitations.partials.modern-gifts', [
            'invitation' => $invitation,
        ])

        @include('invitations.partials.modern-messages', [
            'invitation' => $invitation,
            'guest' => $guest,
            'messages' => $messages,
        ])
        
        <footer class="modern-footer">
            <p class="modern-footer-thanks">
                Terima kasih atas perhatian dan doa Anda.
            </p>

            <h2>Matur Suksma</h2>

            <div class="modern-footer-divider">
                <span></span>
                <span>✦</span>
                <span></span>
            </div>

            <p class="modern-footer-brand">
                Dibuat dengan <span class="footer-heart">♥</span> melalui
            </p>

            <a
                href="https://www.baliutsava.com"
                class="modern-footer-logo"
                target="_blank"
                rel="noopener noreferrer"
            >
                Baliutsava<span>.com</span>
            </a>

            <p class="modern-footer-copyright">
                &copy; {{ date('Y') }} Baliutsava.com. All rights reserved.
            </p>
        </footer>

    </main>

    @if ($invitation->music_path)
        <audio id="background-music" loop preload="auto">
            <source src="{{ asset('storage/' . $invitation->music_path) }}">
        </audio>

        <button
            type="button"
            id="music-toggle"
            class="modern-music-toggle"
            aria-label="Putar musik"
            title="Putar musik"
        >
            <span id="music-icon">♫</span>
        </button>
    @endif

    
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openButton = document.getElementById('bukaUndangan');
        const music = document.getElementById('background-music');
        const musicToggle = document.getElementById('music-toggle');
        const musicIcon = document.getElementById('music-icon');

        function updateMusicButton() {
            if (!music || !musicToggle || !musicIcon) return;

            const isPlaying = !music.paused;

            musicIcon.textContent = isPlaying ? '♫' : '♪';
            musicToggle.classList.toggle('playing', isPlaying);

            musicToggle.setAttribute(
                'aria-label',
                isPlaying ? 'Jeda musik' : 'Putar musik'
            );

            musicToggle.title = isPlaying ? 'Jeda musik' : 'Putar musik';
        }

        if (music) {
            music.volume = 0.5;

            music.addEventListener('play', updateMusicButton);
            music.addEventListener('pause', updateMusicButton);
            music.addEventListener('ended', updateMusicButton);
        }

        // Musik mulai ketika tombol Buka Undangan ditekan
        openButton?.addEventListener('click', function () {
            if (music && music.paused) {
                music.play().catch(function (error) {
                    console.info('Musik belum dapat diputar:', error);
                });
            }

            document.getElementById('isiUndangan')?.scrollIntoView({
                behavior: 'smooth'
            });
        });

        // Tombol musik mengambang: play/pause
        musicToggle?.addEventListener('click', function () {
            if (!music) return;

            if (music.paused) {
                music.play().catch(function (error) {
                    console.warn('Musik gagal diputar:', error);
                });
            } else {
                music.pause();
            }
        });

        updateMusicButton();
    });

    document.addEventListener('DOMContentLoaded', function () {
        const countdown = document.getElementById('modernCountdown');

        if (!countdown) return;

        const targetDate = new Date(countdown.dataset.start).getTime();
        const message = document.getElementById('countdownMessage');

        const fields = {
            days: document.getElementById('countdownDays'),
            hours: document.getElementById('countdownHours'),
            minutes: document.getElementById('countdownMinutes'),
            seconds: document.getElementById('countdownSeconds'),
        };

        function updateCountdown() {
            const now = Date.now();
            const distance = targetDate - now;

            if (distance <= 0) {
                Object.values(fields).forEach(function (field) {
                    field.textContent = '00';
                });

                message.textContent = 'Acara telah dimulai. Sampai jumpa di lokasi acara!';
                clearInterval(timer);
                return;
            }

            fields.days.textContent = String(
                Math.floor(distance / (1000 * 60 * 60 * 24))
            ).padStart(2, '0');

            fields.hours.textContent = String(
                Math.floor((distance / (1000 * 60 * 60)) % 24)
            ).padStart(2, '0');

            fields.minutes.textContent = String(
                Math.floor((distance / (1000 * 60)) % 60)
            ).padStart(2, '0');

            fields.seconds.textContent = String(
                Math.floor((distance / 1000) % 60)
            ).padStart(2, '0');

            message.textContent = '';
        }

        updateCountdown();
        const timer = setInterval(updateCountdown, 1000);
    });

    
    document.addEventListener('DOMContentLoaded', function () {
        const bukaButton = document.getElementById('bukaUndangan');
        const cover = document.getElementById('coverUndangan');
        const isiUndangan = document.getElementById('isiUndangan');
        const music = document.getElementById('background-music');

        if (!bukaButton || !cover) return;

        // Kunci halaman sebelum undangan dibuka.
        document.documentElement.classList.add('invitation-locked');

        bukaButton.addEventListener('click', function () {
            // Cegah tombol diklik berkali-kali.
            bukaButton.disabled = true;

            // Buka kunci halaman.
            document.documentElement.classList.remove('invitation-locked');
            document.documentElement.classList.add('invitation-opened');

            // Putar musik jika tersedia.
            if (music) {
                music.volume = 0.5;

                music.play().catch(function (error) {
                    console.info('Musik belum dapat diputar:', error);
                });
            }

            // Jalankan animasi cover.
            cover.classList.add('cover-closing');

            // Setelah animasi selesai, hapus cover dari layout.
            setTimeout(function () {
                cover.classList.add('cover-hidden');
                cover.classList.remove('cover-closing');

                // Mulai isi undangan dari bagian paling atas.
                window.scrollTo({
                    top: 0,
                    behavior: 'instant'
                });

                // Pastikan isi undangan dapat diakses.
                if (isiUndangan) {
                    isiUndangan.setAttribute('tabindex', '-1');
                }
            }, 800);
        }, { once: true });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const sections = document.querySelectorAll(
            '#isiUndangan > .modern-section, ' +
            '#isiUndangan > section, ' +
            '#isiUndangan > footer.modern-footer'
        );

        // Browser tidak mendukung IntersectionObserver:
        // tampilkan semua konten tanpa animasi.
        if (!('IntersectionObserver' in window)) {
            return;
        }

        // Hormati preferensi pengguna yang mengurangi animasi.
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            return;
        }

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');

                    // Animasi cukup sekali setiap section.
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.08,
            rootMargin: '0px 0px -40px 0px'
        });

        sections.forEach(function (section) {
            section.classList.add('reveal-on-scroll');
            observer.observe(section);
        });
    });
    
    document.addEventListener('click', async function (event) {
        const button = event.target.closest('[data-copy]');

        if (!button) return;

        const number = button.dataset.copy;
        const feedback = document.getElementById('giftCopyFeedback');

        try {
            await navigator.clipboard.writeText(number);

            button.textContent = 'Tersalin ✓';

            if (feedback) {
                feedback.textContent = 'Nomor rekening berhasil disalin.';
            }

            setTimeout(function () {
                button.textContent = 'Salin';
            }, 1800);
        } catch (error) {
            if (feedback) {
                feedback.textContent =
                    'Tidak dapat menyalin otomatis. Silakan salin nomor rekening secara manual: ' + number;
            }
        }
    });
    </script>



</body>
</html>
