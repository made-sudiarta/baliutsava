<?php

namespace App\Filament\Pages;

use App\Models\Invitation;
use App\Models\InvitationMessage;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class LaporanRsvp extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Laporan RSVP';

    protected static ?string $title = 'Laporan RSVP';

    protected string $view = 'filament.pages.laporan-rsvp';

    public ?string $invitationId = '';

    public function getInvitationsProperty()
    {
        return Invitation::query()
            ->orderBy('title')
            ->get(['id', 'title']);
    }

    public function getRsvpsProperty()
    {
        return $this->approvedRsvpQuery()
            ->with('invitation')
            ->latest()
            ->paginate(20);
    }

    public function getSummaryProperty(): array
    {
        $query = $this->approvedRsvpQuery();

        return [
            'total' => (clone $query)->count(),

            'attending' => (clone $query)
                ->where('attendance', 'attending')
                ->count(),

            'people' => (clone $query)
                ->where('attendance', 'attending')
                ->sum('guest_count'),

            'not_attending' => (clone $query)
                ->where('attendance', 'not_attending')
                ->count(),

            // Tetap hitung pesan pending secara terpisah.
            'pending' => $this->rsvpQuery()
                ->where('moderation_status', 'pending')
                ->count(),
        ];
    }

    protected function rsvpQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return InvitationMessage::query()
            ->when(
                $this->invitationId !== '',
                fn ($query) => $query->where(
                    'invitation_id',
                    $this->invitationId
                )
            );
    }
    protected function approvedRsvpQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->rsvpQuery()
            ->where('moderation_status', 'approved')
            ->where(function ($query) {
                // RSVP tanpa tamu terdaftar tetap ditampilkan.
                $query->whereNull('invitation_guest_id')
                    ->orWhereNotExists(function ($subquery) {
                        $subquery
                            ->selectRaw('1')
                            ->from('invitation_messages as newer')
                            ->whereColumn(
                                'newer.invitation_guest_id',
                                'invitation_messages.invitation_guest_id'
                            )
                            ->whereColumn(
                                'newer.invitation_id',
                                'invitation_messages.invitation_id'
                            )
                            ->where(function ($newer) {
                                $newer
                                    ->whereColumn(
                                        'newer.created_at',
                                        '>',
                                        'invitation_messages.created_at'
                                    )
                                    ->orWhere(function ($tie) {
                                        $tie
                                            ->whereColumn(
                                                'newer.created_at',
                                                '=',
                                                'invitation_messages.created_at'
                                            )
                                            ->whereColumn(
                                                'newer.id',
                                                '>',
                                                'invitation_messages.id'
                                            );
                                    });
                            });
                    });
            });
    }

    public function exportCsv()
    {
        $rows = $this->approvedRsvpQuery()
            ->with('invitation')
            ->latest()
            ->get();

        $filename = 'laporan-rsvp-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');

            // BOM agar karakter Bahasa Indonesia terbaca baik di Excel.
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Undangan',
                'Nama Tamu',
                'Kehadiran',
                'Jumlah Orang',
                'Ucapan',
                'Status Moderasi',
                'Tanggal RSVP',
            ], ';');

            foreach ($rows as $row) {
                $safe = fn ($value) => preg_match(
                    '/^[\s]*[=+\-@]/u',
                    (string) $value
                ) ? "'" . $value : $value;

                fputcsv($handle, [
                    $safe($row->invitation?->title ?? '-'),
                    $safe($row->guest_name),
                    $row->attendance === 'attending'
                        ? 'Hadir'
                        : 'Tidak Hadir',
                    $row->guest_count,
                    $safe($row->message ?? ''),
                    $row->moderation_status,
                    $row->created_at?->format('d-m-Y H:i'),
                ], ';');
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}