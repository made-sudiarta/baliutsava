<?php

namespace App\Filament\Resources\InvitationMessages\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InvitationMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('guest_name')
                    ->label('Nama Tamu')
                    ->searchable(),

                TextColumn::make('invitation.title')
                    ->label('Undangan')
                    ->searchable(),

                TextColumn::make('attendance')
                    ->label('Kehadiran')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'attending' => 'Hadir',
                        'not_attending' => 'Tidak Hadir',
                        default => $state,
                    }),

                TextColumn::make('guest_count')
                    ->label('Jumlah Tamu'),

                TextColumn::make('moderation_status')
                    ->label('Status Moderasi')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'warning',
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('moderation_status')
                    ->label('Status Moderasi')
                    ->options([
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ]),

                SelectFilter::make('attendance')
                    ->label('Kehadiran')
                    ->options([
                        'attending' => 'Hadir',
                        'not_attending' => 'Tidak Hadir',
                    ]),

                SelectFilter::make('invitation')
                    ->relationship('invitation', 'title')
                    ->label('Undangan'),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Setujui')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn ($record) => $record->moderation_status !== 'approved')
                    ->action(fn ($record) => $record->update([
                        'moderation_status' => 'approved',
                    ])),

                Action::make('reject')
                    ->label('Tolak')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->visible(fn ($record) => $record->moderation_status !== 'rejected')
                    ->action(fn ($record) => $record->update([
                        'moderation_status' => 'rejected',
                    ])),

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);       
        }
}