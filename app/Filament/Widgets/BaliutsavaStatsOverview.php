<?php

namespace App\Filament\Widgets;

use App\Models\Invitation;
use App\Models\InvitationGuest;
use App\Models\InvitationMessage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BaliutsavaStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalInvitations = Invitation::count();

        $totalGuests = InvitationGuest::count();

        $totalAttending = InvitationMessage::where(
            'attendance',
            'attending'
        )->count();

        $totalAttendees = InvitationMessage::where(
            'attendance',
            'attending'
        )->sum('guest_count');

        $totalNotAttending = InvitationMessage::where(
            'attendance',
            'not_attending'
        )->count();

        $pendingMessages = InvitationMessage::where(
            'moderation_status',
            'pending'
        )->count();

        return [
            Stat::make('Total Undangan', $totalInvitations)
                ->description('Semua undangan yang tersimpan')
                ->descriptionIcon('heroicon-o-envelope')
                ->color('primary'),

            Stat::make('Tamu Terdaftar', $totalGuests)
                ->description('Daftar tamu undangan')
                ->descriptionIcon('heroicon-o-users')
                ->color('info'),

            Stat::make('Konfirmasi Hadir', $totalAttending)
                ->description('Respons yang menyatakan hadir')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Total Orang Hadir', $totalAttendees)
                ->description('Akumulasi jumlah tamu RSVP hadir')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),

            Stat::make('Tidak Hadir', $totalNotAttending)
                ->description('Respons yang menyatakan tidak hadir')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger'),

            Stat::make('Menunggu Moderasi', $pendingMessages)
                ->description('Ucapan yang belum ditinjau')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),
        ];
    }
}