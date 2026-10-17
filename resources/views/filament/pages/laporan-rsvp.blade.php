
<x-filament-panels::page>
    <style>
        .lr-page {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .lr-card {
            background: var(--fi-color-bg, white);
            border: 1px solid var(--fi-color-border, #e5e7eb);
            border-radius: 14px;
            padding: 22px;
            min-width: 0;
        }

        .lr-heading {
            font-size: 19px;
            font-weight: 700;
            margin: 0 0 6px;
        }

        .lr-muted {
            color: #6b7280;
            font-size: 13px;
        }

        .lr-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .lr-select {
            display: block;
            width: 100%;
            padding: 11px 13px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: transparent;
            color: inherit;
            font-size: 14px;
        }

        .lr-stats {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 15px;
        }

        .lr-stat {
            border: 1px solid var(--fi-color-border, #e5e7eb);
            border-radius: 12px;
            padding: 18px;
            background: var(--fi-color-bg, white);
            min-width: 0;
        }

        .lr-stat-label {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.5;
        }

        .lr-stat-value {
            font-size: 27px;
            font-weight: 750;
            margin-top: 8px;
        }

        .lr-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .lr-table-wrap {
            overflow-x: auto;
            width: 100%;
        }

        .lr-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .lr-table th {
            text-align: left;
            font-weight: 600;
            white-space: nowrap;
            background: rgba(107, 114, 128, .08);
        }

        .lr-table th,
        .lr-table td {
            padding: 13px 15px;
            border-bottom: 1px solid var(--fi-color-border, #e5e7eb);
            vertical-align: top;
        }

        .lr-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .lr-badge {
            display: inline-block;
            padding: 4px 9px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .lr-green {
            background: #dcfce7;
            color: #166534;
        }

        .lr-yellow {
            background: #fef3c7;
            color: #92400e;
        }

        .lr-gray {
            background: #f3f4f6;
            color: #374151;
        }

        .lr-empty {
            padding: 28px !important;
            text-align: center;
            color: #6b7280;
        }

        .lr-pagination {
            padding-top: 18px;
        }

        @media (max-width: 1200px) {
            .lr-stats {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .lr-card {
                padding: 16px;
            }

            .lr-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .lr-stat {
                padding: 13px;
            }

            .lr-stat-value {
                font-size: 23px;
            }
        }
    </style>

    <div class="lr-page">
        {{-- Filter undangan --}}
        <section class="lr-card">
            <label for="invitationId" class="lr-label">
                Pilih Undangan
            </label>

            <select
                id="invitationId"
                wire:model.live="invitationId"
                class="lr-select"
            >
                <option value="">Semua Undangan</option>

                @foreach ($this->invitations as $invitation)
                    <option value="{{ $invitation->id }}">
                        {{ $invitation->title }}
                    </option>
                @endforeach
            </select>
        </section>

        {{-- Statistik --}}
        <div class="lr-stats">
            @foreach ([
                ['Total RSVP', $this->summary['total']],
                ['Respons Hadir', $this->summary['attending']],
                ['Perkiraan Orang Hadir', $this->summary['people']],
                ['Respons Tidak Hadir', $this->summary['not_attending']],
                ['Menunggu Moderasi', $this->summary['pending']],
            ] as [$label, $value])
                <div class="lr-stat">
                    <div class="lr-stat-label">{{ $label }}</div>
                    <div class="lr-stat-value">{{ number_format($value) }}</div>
                </div>
            @endforeach
        </div>

        {{-- Tabel laporan --}}
        <section class="lr-card">
            <div class="lr-toolbar" style="margin-bottom:20px">
                <div>
                    <h2 class="lr-heading">Daftar RSVP</h2>
                    <p class="lr-muted">
                        Data konfirmasi kehadiran dan ucapan tamu.
                    </p>
                </div>

                <x-filament::button
                    wire:click="exportCsv"
                    icon="heroicon-o-arrow-down-tray"
                >
                    Ekspor CSV untuk Excel
                </x-filament::button>
            </div>

            <div class="lr-table-wrap">
                <table class="lr-table">
                    <thead>
                        <tr>
                            <th>Nama Tamu</th>
                            <th>Undangan</th>
                            <th>Kehadiran</th>
                            <th>Jumlah Orang</th>
                            <th>Moderasi</th>
                            <th>Tanggal RSVP</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($this->rsvps as $rsvp)
                            <tr>
                                <td>{{ $rsvp->guest_name }}</td>

                                <td>
                                    {{ $rsvp->invitation?->title ?? '-' }}
                                </td>

                                <td>
                                    @if ($rsvp->attendance === 'attending')
                                        <span class="lr-badge lr-green">Hadir</span>
                                    @else
                                        <span class="lr-badge lr-gray">Tidak Hadir</span>
                                    @endif
                                </td>

                                <td>{{ $rsvp->guest_count }}</td>

                                <td>
                                    @if ($rsvp->moderation_status === 'approved')
                                        <span class="lr-badge lr-green">Disetujui</span>
                                    @elseif ($rsvp->moderation_status === 'pending')
                                        <span class="lr-badge lr-yellow">Menunggu</span>
                                    @else
                                        <span class="lr-badge lr-gray">Ditolak</span>
                                    @endif
                                </td>

                                <td style="white-space:nowrap">
                                    {{ $rsvp->created_at?->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="lr-empty">
                                    Belum ada data RSVP untuk filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="lr-pagination">
                {{ $this->rsvps->links() }}
            </div>
        </section>
    </div>
</x-filament-panels::page>
