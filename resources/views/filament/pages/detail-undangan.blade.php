
<x-filament-panels::page>
    <style>
        .du-page { display: flex; flex-direction: column; gap: 24px; }
        .du-card {
            background: var(--fi-color-bg, white);
            border: 1px solid var(--fi-color-border, #e5e7eb);
            border-radius: 14px;
            padding: 22px;
            min-width: 0;
        }
        .du-heading { font-size: 19px; font-weight: 700; margin: 0 0 5px; }
        .du-muted { color: #6b7280; font-size: 13px; }
        .du-select {
            display: block; width: 100%; max-width: 100%;
            margin-top: 9px; padding: 11px 13px;
            border: 1px solid #d1d5db; border-radius: 8px;
            background: transparent; color: inherit;
        }
        .du-info {
            display: flex; justify-content: space-between;
            align-items: flex-start; gap: 20px; flex-wrap: wrap;
        }
        .du-stats {
            display: grid; grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }
        .du-stat {
            background: var(--fi-color-bg, white);
            border: 1px solid var(--fi-color-border, #e5e7eb);
            border-radius: 12px; padding: 19px;
            min-width: 0;
        }
        .du-stat-label { color: #6b7280; font-size: 13px; line-height: 1.5; }
        .du-stat-value { font-size: 28px; font-weight: 750; margin-top: 8px; }
        .du-table-wrap { overflow-x: auto; width: 100%; }
        .du-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .du-table th {
            text-align: left; font-weight: 600;
            background: rgba(107,114,128,.08);
            white-space: nowrap;
        }
        .du-table th, .du-table td {
            padding: 13px 15px;
            border-bottom: 1px solid var(--fi-color-border, #e5e7eb);
            vertical-align: top;
        }
        .du-table tbody tr:last-child td { border-bottom: 0; }
        .du-badge {
            display: inline-block; padding: 4px 9px;
            border-radius: 999px; font-size: 12px; font-weight: 600;
            white-space: nowrap;
        }
        .du-green { background: #dcfce7; color: #166534; }
        .du-yellow { background: #fef3c7; color: #92400e; }
        .du-gray { background: #f3f4f6; color: #374151; }
        .du-empty { padding: 28px; text-align: center; color: #6b7280; }
        .du-pagination { padding: 16px; }
        @media (max-width: 1100px) {
            .du-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 600px) {
            .du-card { padding: 15px; }
            .du-stats { grid-template-columns: 1fr 1fr; gap: 10px; }
            .du-stat { padding: 13px; }
            .du-stat-value { font-size: 23px; }
            .du-table th, .du-table td { padding: 10px; }
        }
    </style>

    <div class="du-page">
        <section class="du-card">
            <label for="invitationId" style="font-size:14px;font-weight:600">
                Pilih Undangan
            </label>

            <select id="invitationId" wire:model.live="invitationId" class="du-select">
                <option value="">-- Pilih Undangan --</option>
                @foreach ($this->invitations as $item)
                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                @endforeach
            </select>
        </section>

        @if ($this->invitation)
            <section class="du-card">
                <div class="du-info">
                    <div>
                        <h2 class="du-heading">{{ $this->invitation->title }}</h2>
                        <div class="du-muted">
                            {{ ucfirst($this->invitation->event_type ?? 'Acara') }}
                        </div>

                        <p style="margin:14px 0 4px">
                            {{ $this->invitation->venue_name ?? 'Lokasi belum diisi' }}
                        </p>

                        @if ($this->invitation->event_starts_at)
                            <div class="du-muted">
                                {{ $this->invitation->event_starts_at->format('d M Y, H:i') }}
                            </div>
                        @endif
                    </div>

                    <x-filament::button
                        tag="a"
                        href="{{ route('invitations.show', ['slug' => $this->invitation->slug]) }}"
                        target="_blank"
                        icon="heroicon-o-arrow-top-right-on-square"
                    >
                        Lihat Undangan
                    </x-filament::button>
                </div>
            </section>

            <div class="du-stats">
                @foreach ([
                    ['Total Tamu', $this->stats['guests']],
                    ['Ditandai Terkirim', $this->stats['sent']],
                    ['Belum Ditandai', $this->stats['unsent']],
                    ['Menunggu Moderasi', $this->stats['pending']],
                    ['Respons Hadir Disetujui', $this->stats['attending']],
                    ['Perkiraan Orang Hadir', $this->stats['people']],
                    ['Respons Tidak Hadir', $this->stats['not_attending']],
                ] as [$label, $value])
                    <div class="du-stat">
                        <div class="du-stat-label">{{ $label }}</div>
                        <div class="du-stat-value">{{ number_format($value) }}</div>
                    </div>
                @endforeach
            </div>

            <section class="du-card">
                <h2 class="du-heading">Daftar Tamu</h2>
                <p class="du-muted" style="margin-bottom:18px">
                    Daftar tamu dan status pembagian undangan.
                </p>

                <div class="du-table-wrap">
                    <table class="du-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>WhatsApp</th>
                                <th>Kuota</th>
                                <th>Status Pengiriman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->guests as $guest)
                                <tr>
                                    <td>{{ $guest->name }}</td>
                                    <td style="white-space:nowrap">{{ $guest->phone ?? '-' }}</td>
                                    <td>{{ $guest->guest_quota }}</td>
                                    <td>
                                        @if ($guest->invitation_sent_at)
                                            <span class="du-badge du-green">
                                                Terkirim
                                            </span>
                                            <div class="du-muted" style="margin-top:5px">
                                                {{ $guest->invitation_sent_at->format('d/m/Y H:i') }}
                                            </div>
                                        @else
                                            <span class="du-badge du-yellow">
                                                Belum ditandai
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="du-empty">
                                        Belum ada tamu pada undangan ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="du-pagination">
                    {{ $this->guests->links() }}
                </div>
            </section>

            <section class="du-card">
                <h2 class="du-heading">Ucapan dan RSVP Terbaru</h2>
                <p class="du-muted" style="margin-bottom:18px">
                    Respons tamu beserta status moderasinya.
                </p>

                <div class="du-table-wrap">
                    <table class="du-table">
                        <thead>
                            <tr>
                                <th>Nama Tamu</th>
                                <th>Kehadiran</th>
                                <th>Jumlah</th>
                                <th>Moderasi</th>
                                <th>Ucapan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->messages as $message)
                                <tr>
                                    <td>{{ $message->guest_name }}</td>
                                    <td>
                                        {{ $message->attendance === 'attending' ? 'Hadir' : 'Tidak Hadir' }}
                                    </td>
                                    <td>{{ $message->guest_count }}</td>
                                    <td>
                                        @if ($message->moderation_status === 'approved')
                                            <span class="du-badge du-green">Disetujui</span>
                                        @elseif ($message->moderation_status === 'pending')
                                            <span class="du-badge du-yellow">Menunggu</span>
                                        @else
                                            <span class="du-badge du-gray">Ditolak</span>
                                        @endif
                                    </td>
                                    <td style="min-width:180px;white-space:pre-wrap">
                                        {{ $message->message ?: '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="du-empty">
                                        Belum ada RSVP atau ucapan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="du-pagination">
                    {{ $this->messages->links() }}
                </div>
            </section>
        @else
            <section class="du-card du-empty">
                Pilih undangan untuk melihat ringkasan acara, daftar tamu, dan RSVP.
            </section>
        @endif
    </div>
</x-filament-panels::page>
