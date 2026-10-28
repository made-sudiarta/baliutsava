<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $invitation->title }}</title>
    <link rel="stylesheet" href="{{ asset('css/themes/superior-modern.css') }}">
</head>
<body class="sm-page">
    <div class="sm-layout">
        {{-- Splash screen desktop: tetap terlihat saat panel undangan digulir. --}}
        <aside class="sm-splash" aria-label="Sampul pernikahan">
            @if ($invitation->cover_image)
                <img class="sm-splash-image"
                     src="{{ asset('storage/' . $invitation->cover_image) }}"
                     alt="" fetchpriority="high">
            @endif
            <div class="sm-splash-overlay"></div>
            <div class="sm-splash-content">
                <p class="sm-eyebrow">THE WEDDING OF</p>
                @if ($invitation->logo_path)
                    <img class="sm-logo" src="{{ asset('storage/' . $invitation->logo_path) }}"
                         alt="{{ $invitation->title }}">
                @else
                    <h1>{{ $invitation->title }}</h1>
                @endif
                <div class="sm-splash-rule"><span>✦</span></div>
                <p class="sm-splash-names">
                    {{ $invitation->host_name }}
                    @if ($invitation->partner_name)
                        <span>&amp;</span>{{ $invitation->partner_name }}
                    @endif
                </p>
                @if ($invitation->event_starts_at)
                    <p class="sm-splash-date">
                        {{ $invitation->event_starts_at->locale('id')->translatedFormat('l, d F Y') }}
                    </p>
                @endif
                <p class="sm-splash-note">Sebuah hari istimewa, sebuah kisah selamanya.</p>
            </div>
            <div class="sm-splash-bottom">DENGAN CINTA · BALIUTSAVA</div>
        </aside>

        {{-- Panel kanan berukuran mobile tanpa bingkai perangkat. --}}
        <div class="sm-preview-area">
            <div class="sm-invitation" id="smInvitation">
                <header class="sm-cover" id="smCover">
                    @if ($invitation->cover_image)
                        <img
                            class="sm-cover-image"
                            src="{{ asset('storage/' . $invitation->cover_image) }}"
                            alt=""
                        >
                    @endif

                    <div class="sm-cover-shade"></div>
                    <div class="sm-cover-content">
                        <p class="sm-eyebrow">UNDANGAN PERNIKAHAN</p>
                        @if ($invitation->logo_path)
                            <img class="sm-cover-logo" src="{{ asset('storage/' . $invitation->logo_path) }}"
                                 alt="{{ $invitation->title }}">
                        @else
                            <h1>{{ $invitation->title }}</h1>
                        @endif
                        <div class="sm-ornament">✦</div>
                        <p class="sm-cover-names">
                            {{ $invitation->host_name }}
                            @if ($invitation->partner_name)
                                <span>&amp;</span>{{ $invitation->partner_name }}
                            @endif
                        </p>
                        @if ($invitation->event_starts_at)
                            <p class="sm-cover-date">
                                {{ $invitation->event_starts_at->locale('id')->translatedFormat('l, d F Y') }}
                            </p>
                        @endif
                        <p class="sm-cover-invite">Kepada Yth. Bapak/Ibu/Saudara/i</p>
                        <button type="button" class="sm-open-button" id="smOpenButton">
                            Buka Undangan <span aria-hidden="true">↓</span>
                        </button>
                    </div>
                </header>

                <main class="sm-content" id="smContent" aria-hidden="true">
                    <section class="sm-section sm-intro">
                        <p class="sm-eyebrow">OM SWASTIASTU</p>
                        <div class="sm-ornament">✦</div>
                        <h2>Atas Asung Kertha Wara Nugraha Ida Sang Hyang Widhi Wasa</h2>
                        @if ($invitation->description)
                            <div class="sm-description">{!! $invitation->description !!}</div>
                        @endif

                        <div class="sm-couple">
                            @if ($invitation->partner_photo_mode === 'single')
                                @if ($invitation->couple_photo)
                                    <img class="sm-couple-shared"
                                         src="{{ asset('storage/' . $invitation->couple_photo) }}"
                                         alt="{{ $invitation->host_name }} dan {{ $invitation->partner_name }}"
                                         loading="lazy">
                                @endif
                                <div class="sm-couple-person">
                                    <p class="sm-person-label">Mempelai</p>
                                    <h3>{{ $invitation->host_name }}</h3>
                                    <p class="sm-person-and">&amp;</p>
                                    <h3>{{ $invitation->partner_name }}</h3>
                                </div>
                            @else
                                <div class="sm-couple-grid">
                                    <div class="sm-couple-person">
                                        @if ($invitation->partner_photo_1)
                                            <img class="sm-person-photo"
                                                 src="{{ asset('storage/' . $invitation->partner_photo_1) }}"
                                                 alt="{{ $invitation->host_name }}" loading="lazy">
                                        @endif
                                        <p class="sm-person-label">Mempelai Pria</p>
                                        <h3>{{ $invitation->host_name }}</h3>
                                    </div>
                                    <div class="sm-couple-amp">&amp;</div>
                                    <div class="sm-couple-person">
                                        @if ($invitation->partner_photo_2)
                                            <img class="sm-person-photo"
                                                 src="{{ asset('storage/' . $invitation->partner_photo_2) }}"
                                                 alt="{{ $invitation->partner_name }}" loading="lazy">
                                        @endif
                                        <p class="sm-person-label">Mempelai Wanita</p>
                                        <h3>{{ $invitation->partner_name }}</h3>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </section>

                    @if ($invitation->events->isNotEmpty())
                        <section class="sm-section sm-countdown-section">
                            <p class="sm-eyebrow">SAVE THE DATE</p>
                            <h2>Menuju Hari Bahagia</h2>
                            @php
                                $smCountdownEvent = $invitation->events
                                    ->whereNotNull('starts_at')->sortBy('starts_at')->first();
                            @endphp
                            @if ($smCountdownEvent)
                                <div class="sm-countdown" id="smCountdown"
                                     data-start="{{ $smCountdownEvent->starts_at->toIso8601String() }}">
                                    <div><strong id="smDays">00</strong><span>Hari</span></div>
                                    <div><strong id="smHours">00</strong><span>Jam</span></div>
                                    <div><strong id="smMinutes">00</strong><span>Menit</span></div>
                                    <div><strong id="smSeconds">00</strong><span>Detik</span></div>
                                </div>
                                <p class="sm-event-date">
                                    {{ $smCountdownEvent->starts_at->locale('id')->translatedFormat('l, d F Y · H:i') }} WITA
                                </p>
                                <p id="smCountdownMessage" class="sm-muted"></p>
                            @endif

                            <div class="sm-event-list">
                                @foreach ($invitation->events as $event)
                                    <article class="sm-event">
                                        <h3>{{ $event->title }}</h3>
                                        @if ($event->starts_at)
                                            <p>{{ $event->starts_at->locale('id')->translatedFormat('l, d F Y') }}</p>
                                            <p>{{ $event->starts_at->format('H:i') }} WITA
                                                @if ($event->ends_at) – {{ $event->ends_at->format('H:i') }} WITA @endif
                                            </p>
                                        @endif
                                        @if ($event->venue_name ?? false)
                                            <p>{{ $event->venue_name }}</p>
                                        @endif
                                        @if ($event->address ?? false)
                                            <p>{{ $event->address }}</p>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if ($invitation->venue_name || $invitation->address)
                        <section class="sm-section sm-location" id="smLokasi">
                            <p class="sm-eyebrow">LOKASI ACARA</p>
                            <h2>{{ $invitation->venue_name }}</h2>
                            @if ($invitation->address)
                                <p class="sm-muted">{{ $invitation->address }}</p>
                            @endif
                            @if ($invitation->maps_url)
                                <div class="sm-map">
                                    <iframe
                                        src="https://maps.google.com/maps?q={{ urlencode($invitation->address ?: $invitation->venue_name) }}&output=embed"
                                        width="100%" height="240" style="border:0"
                                        allowfullscreen loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        title="Peta lokasi acara"></iframe>
                                </div>
                                <a class="sm-link-button" href="{{ $invitation->maps_url }}"
                                   target="_blank" rel="noopener noreferrer">Buka Petunjuk Arah ↗</a>
                            @endif
                        </section>
                    @endif

                    @if ($invitation->galleries->isNotEmpty())
                        <section class="sm-section">
                            <p class="sm-eyebrow">MOMEN KAMI</p>
                            <h2>Galeri</h2>

                            <div class="sm-gallery">
                                @foreach ($invitation->galleries as $gallery)
                                    <figure>
                                        <img
                                            src="{{ asset('storage/' . $gallery->file_path) }}"
                                            alt="{{ $gallery->caption ?: 'Foto galeri' }}"
                                            loading="lazy"
                                            class="sm-gallery-image"
                                            data-full-image="{{ asset('storage/' . $gallery->file_path) }}"
                                            role="button"
                                            tabindex="0"
                                            aria-label="Perbesar foto {{ $gallery->caption ?: 'galeri' }}"
                                        >

                                        @if ($gallery->caption)
                                            <figcaption>{{ $gallery->caption }}</figcaption>
                                        @endif
                                    </figure>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    {{-- Popup Galeri --}}
                    <div class="sm-lightbox" id="smLightbox" aria-hidden="true">
                        <button type="button" class="sm-lightbox-close" aria-label="Tutup popup">
                            &times;
                        </button>

                        <button type="button" class="sm-lightbox-prev" aria-label="Foto sebelumnya">
                            &#10094;
                        </button>

                        <img src="" alt="Foto galeri" class="sm-lightbox-image">

                        <button type="button" class="sm-lightbox-next" aria-label="Foto berikutnya">
                            &#10095;
                        </button>

                        <div class="sm-lightbox-caption"></div>
                    </div>

                    @include('invitations.partials.superior-gifts', [
                        'invitation' => $invitation,
                    ])
                    @include('invitations.partials.superior-messages', [
                        'invitation' => $invitation,
                        'guest' => $guest,
                        'messages' => $messages,
                    ])

                    <footer class="sm-footer">
                        <p>Terima kasih atas doa dan kehadiran Anda.</p>
                        <h2>Matur Suksma</h2>
                        <div class="sm-ornament">✦</div>
                        <p class="sm-muted">Dibuat dengan ♥ melalui</p>
                        <a href="https://www.baliutsava.com" target="_blank" rel="noopener noreferrer">Baliutsava.com</a>
                        <small>© {{ date('Y') }} Baliutsava.com. All rights reserved.</small>
                    </footer>
                </main>
            </div>
        </div>
    </div>

    @if ($invitation->music_path)
        <audio id="smMusic" loop preload="auto">
            <source src="{{ asset('storage/' . $invitation->music_path) }}">
        </audio>
        <button type="button" id="smMusicToggle" class="sm-music-toggle"
                aria-label="Putar musik" title="Putar musik">♫</button>
    @endif

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const page = document.documentElement;
        const openButton = document.getElementById('smOpenButton');
        const cover = document.getElementById('smCover');
        const content = document.getElementById('smContent');
        const panel = document.getElementById('smInvitation');
        const music = document.getElementById('smMusic');
        const musicToggle = document.getElementById('smMusicToggle');

        if (content) content.setAttribute('aria-hidden', 'true');

        function updateMusicButton() {
            if (!musicToggle || !music) return;
            const playing = !music.paused;
            musicToggle.textContent = playing ? 'Ⅱ' : '♫';
            musicToggle.classList.toggle('is-playing', playing);
            musicToggle.setAttribute('aria-label', playing ? 'Jeda musik' : 'Putar musik');
            musicToggle.title = playing ? 'Jeda musik' : 'Putar musik';
        }

        if (music) {
            music.volume = 0.5;
            music.addEventListener('play', updateMusicButton);
            music.addEventListener('pause', updateMusicButton);
        }

        if (openButton && cover && content) {
            openButton.addEventListener('click', function () {
                // Tampilkan isi undangan.
                content.setAttribute('aria-hidden', 'false');

                // Mulai animasi menghilangkan sampul.
                cover.classList.add('is-closing');

                // Putar musik jika tersedia.
                if (music && music.paused) {
                    music.play().catch(function () {});
                }

                // Hapus sampul dari layout setelah animasi selesai.
                window.setTimeout(function () {
                    cover.hidden = true;
                    cover.classList.remove('is-closing');

                    // Arahkan panel ke awal isi undangan.
                    if (panel) {
                        panel.scrollTo({
                            top: content.offsetTop,
                            behavior: 'smooth'
                        });
                    }
                }, 450);
            }, { once: true });
        }

        if (musicToggle && music) {
            musicToggle.addEventListener('click', function () {
                if (music.paused) music.play().catch(function () {});
                else music.pause();
            });
        }

        const countdown = document.getElementById('smCountdown');
        if (countdown) {
            const target = new Date(countdown.dataset.start).getTime();
            const fields = {
                days: document.getElementById('smDays'),
                hours: document.getElementById('smHours'),
                minutes: document.getElementById('smMinutes'),
                seconds: document.getElementById('smSeconds')
            };
            const message = document.getElementById('smCountdownMessage');
            function tick() {
                const distance = target - Date.now();
                if (distance <= 0) {
                    Object.values(fields).forEach(function (field) { if (field) field.textContent = '00'; });
                    if (message) message.textContent = 'Acara telah dimulai. Sampai jumpa!';
                    return;
                }
                if (fields.days) fields.days.textContent = String(Math.floor(distance / 86400000)).padStart(2, '0');
                if (fields.hours) fields.hours.textContent = String(Math.floor(distance / 3600000) % 24).padStart(2, '0');
                if (fields.minutes) fields.minutes.textContent = String(Math.floor(distance / 60000) % 60).padStart(2, '0');
                if (fields.seconds) fields.seconds.textContent = String(Math.floor(distance / 1000) % 60).padStart(2, '0');
            }
            tick();
            const timer = window.setInterval(function () {
                tick();
                if (target <= Date.now()) window.clearInterval(timer);
            }, 1000);
        }

        if (panel && 'IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            panel.querySelectorAll('.sm-section, .sm-footer').forEach(function (section) {
                section.classList.add('sm-reveal');
            });
            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.08 });
            panel.querySelectorAll('.sm-reveal').forEach(function (section) { observer.observe(section); });
        }

        document.addEventListener('click', async function (event) {
            const button = event.target.closest('[data-copy]');
            if (!button) return;
            const number = button.dataset.copy;
            const feedback = document.getElementById('giftCopyFeedback');
            try {
                await navigator.clipboard.writeText(number);
                const original = button.textContent;
                button.textContent = 'Tersalin ✓';
                if (feedback) feedback.textContent = 'Nomor berhasil disalin.';
                window.setTimeout(function () { button.textContent = original || 'Salin'; }, 1800);
            } catch (error) {
                if (feedback) feedback.textContent = 'Silakan salin nomor secara manual: ' + number;
            }
        });
    });
        document.addEventListener('DOMContentLoaded', function () {
            const lightbox = document.getElementById('smLightbox');

            if (!lightbox) return;

            const images = Array.from(document.querySelectorAll('.sm-gallery-image'));
            const preview = lightbox.querySelector('.sm-lightbox-image');
            const caption = lightbox.querySelector('.sm-lightbox-caption');
            const closeButton = lightbox.querySelector('.sm-lightbox-close');
            const prevButton = lightbox.querySelector('.sm-lightbox-prev');
            const nextButton = lightbox.querySelector('.sm-lightbox-next');

            let currentIndex = 0;

            function showImage(index) {
                if (!images.length) return;

                currentIndex = (index + images.length) % images.length;

                const image = images[currentIndex];
                preview.src = image.dataset.fullImage || image.src;
                preview.alt = image.alt;
                caption.textContent =
                    image.closest('figure')?.querySelector('figcaption')?.textContent || '';

                prevButton.hidden = images.length < 2;
                nextButton.hidden = images.length < 2;
            }

            function openLightbox(index) {
                showImage(index);
                lightbox.classList.add('is-open');
                lightbox.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
                closeButton.focus();
            }

            function closeLightbox() {
                lightbox.classList.remove('is-open');
                lightbox.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
                preview.src = '';
            }

            images.forEach((image, index) => {
                image.addEventListener('click', () => openLightbox(index));

                image.addEventListener('keydown', (event) => {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        openLightbox(index);
                    }
                });
            });

            closeButton.addEventListener('click', closeLightbox);
            prevButton.addEventListener('click', () => showImage(currentIndex - 1));
            nextButton.addEventListener('click', () => showImage(currentIndex + 1));

            lightbox.addEventListener('click', (event) => {
                if (event.target === lightbox) closeLightbox();
            });

            document.addEventListener('keydown', (event) => {
                if (!lightbox.classList.contains('is-open')) return;

                if (event.key === 'Escape') closeLightbox();
                if (event.key === 'ArrowLeft') showImage(currentIndex - 1);
                if (event.key === 'ArrowRight') showImage(currentIndex + 1);
            });
        });
        </script>
</body>
</html>
