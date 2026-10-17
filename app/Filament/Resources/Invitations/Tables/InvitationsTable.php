<?php

namespace App\Filament\Resources\Invitations\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InvitationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Undangan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('host_name')
                    ->label('Mempelai Pertama')
                    ->searchable(),

                TextColumn::make('partner_name')
                    ->label('Mempelai Kedua')
                    ->searchable(),

                TextColumn::make('event_starts_at')
                    ->label('Tanggal Acara')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('theme')
                    ->label('Tema')
                    ->badge(),

                IconColumn::make('is_active')
                    ->label('Publikasi')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Status Publikasi')
                    ->options([
                        '1' => 'Aktif',
                        '0' => 'Nonaktif',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}