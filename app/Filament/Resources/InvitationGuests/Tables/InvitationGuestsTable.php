<?php

namespace App\Filament\Resources\InvitationGuests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Actions\Action;

class InvitationGuestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Tamu')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('invitation.title')
                    ->label('Undangan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('guest_quota')
                    ->label('Kuota')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('token')
                    ->label('Token Tamu')
                    ->copyable()
                    ->wrap(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable(),

                
                TextColumn::make('invitation.title')
                    ->label('Undangan')
                    ->searchable(),

                TextColumn::make('personal_link')
                    ->label('Tautan Personal')
                    ->state(function ($record): string {
                        return route('invitations.show', [
                            'slug' => $record->invitation->slug,
                        ]) . '?to=' . urlencode($record->token);
                    })
                    ->copyable()
                    ->copyMessage('Tautan undangan disalin')
                    ->limit(30),

                TextColumn::make('invitation_sent_at')
                    ->label('Status Pengiriman')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Sudah ditandai terkirim' : 'Belum dikirim')
                    ->color(fn ($state) => $state ? 'success' : 'warning')
                    ->dateTime('d M Y H:i'),

            ])
            ->filters([
                SelectFilter::make('invitation')
                    ->label('Undangan')
                    ->relationship('invitation', 'title'),
            ])
            ->recordActions([
                EditAction::make(),
                
                Action::make('whatsapp')
                    ->label('Kirim WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(function ($record): ?string {
                        if (blank($record->phone) || ! $record->invitation) {
                            return null;
                        }

                        $phone = preg_replace('/\D+/', '', $record->phone);

                        if (str_starts_with($phone, '0')) {
                            $phone = '62' . substr($phone, 1);
                        } elseif (str_starts_with($phone, '8')) {
                            $phone = '62' . $phone;
                        }

                        if (blank($phone)) {
                            return null;
                        }

                        $link = route('invitations.show', [
                            'slug' => $record->invitation->slug,
                        ]) . '?to=' . urlencode($record->token);

                        $message = "Om Swastyastu 🙏\n\n"
                            . "Kepada Yth. {$record->name},\n\n"
                            . "Dengan hormat, kami mengundang Anda "
                            . "untuk menghadiri acara {$record->invitation->title}.\n\n"
                            . "Silakan buka undangan personal Anda:\n"
                            . $link . "\n\n"
                            . "Om Santih, Santih, Santih Om.";

                        return 'https://wa.me/' . $phone
                            . '?text=' . urlencode($message);
                    })
                    ->openUrlInNewTab()
                    ->disabled(fn ($record) => blank($record->phone))
                    ->tooltip(fn ($record) => blank($record->phone)
                        ? 'Isi nomor WhatsApp tamu terlebih dahulu'
                        : 'Klik untuk membuka WhatsApp'),
                
                Action::make('mark_sent')
                    ->label('Tandai Terkirim')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Tandai undangan sudah dikirim?')
                    ->modalDescription('Pastikan pesan undangan sudah dikirim melalui WhatsApp.')
                    ->visible(fn ($record) => $record->invitation_sent_at === null)
                    ->action(function ($record) {
                        $record->update([
                            'invitation_sent_at' => now(),
                        ]);
                    }),

                Action::make('mark_unsent')
                    ->label('Batalkan Status')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->invitation_sent_at !== null)
                    ->action(function ($record) {
                        $record->update([
                            'invitation_sent_at' => null,
                        ]);
                    }),


            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}