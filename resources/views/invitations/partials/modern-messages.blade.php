
@if ($invitation->show_messages)
    <section class="modern-section modern-rsvp" id="ucapan">
        <div class="rsvp-heading">
            <span class="rsvp-heading-icon">✦</span>
            <p class="modern-eyebrow">LOVE & WISHES</p>
            <h2>Ucapan & Doa</h2>
            <p class="rsvp-subtitle">
                Setiap doa dan ucapan Anda adalah hadiah berharga bagi kami.
            </p>
        </div>

        @if (session('success'))
            <div class="rsvp-alert rsvp-alert-success" role="status">
                <span class="rsvp-alert-icon">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="rsvp-alert rsvp-alert-error" role="alert">
                <div>
                    <strong>Mohon periksa kembali</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="rsvp-layout">
            <div class="rsvp-form-card">
                <div class="rsvp-card-heading">
                    <span class="rsvp-card-icon">♡</span>
                    <div>
                        <h3>Kirim Ucapan</h3>
                        <p>Sampaikan doa terbaik Anda</p>
                    </div>
                </div>

                <form
                    id="form-ucapan"
                    method="POST"
                    action="{{ route('invitations.messages.store', ['slug' => $invitation->slug]) }}"
                >
                    @csrf

                    @if ($guest)
                        <input type="hidden" name="guest_token" value="{{ $guest->token }}">
                    @endif

                    <div class="rsvp-field">
                        <label for="guest_name">Nama Anda</label>
                        <input
                            id="guest_name"
                            name="guest_name"
                            type="text"
                            maxlength="100"
                            value="{{ old('guest_name', $guest?->name) }}"
                            {{ $guest ? 'readonly' : '' }}
                            required
                            placeholder="Tuliskan nama Anda"
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
                            placeholder="Semoga menjadi keluarga yang bahagia..."
                        >{{ old('message') }}</textarea>
                        <div class="rsvp-field-note">
                            Tuliskan harapan dan doa terbaik untuk kedua mempelai.
                        </div>
                    </div>

                    <button class="modern-button rsvp-submit" type="submit">
                        <span>Kirim Ucapan</span>
                        <span aria-hidden="true">↗</span>
                    </button>
                </form>
            </div>

            <div class="rsvp-messages-card">
                <div class="rsvp-card-heading rsvp-messages-heading">
                    <span class="rsvp-card-icon">✉</span>
                    <div>
                        <h3>Doa dari Tamu</h3>
                        <p>Pesan hangat dari keluarga dan sahabat</p>
                    </div>
                </div>

                <div id="message-section">
                    @include('invitations.partials.messages', [
                        'messages' => $messages
                    ])
                </div>
            </div>
        </div>
    </section>
@endif
