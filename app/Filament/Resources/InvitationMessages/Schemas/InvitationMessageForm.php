<?php

namespace App\Filament\Resources\InvitationMessages\Schemas;


use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InvitationMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Ucapan')
                    ->schema([
                        Select::make('invitation_id')
                            ->label('Undangan')
                            ->relationship('invitation', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('guest_name')
                            ->label('Nama Tamu')
                            ->required()
                            ->maxLength(100),

                        Textarea::make('message')
                            ->label('Ucapan')
                            ->rows(5)
                            ->maxLength(1000),

                        Select::make('attendance')
                            ->label('Kehadiran')
                            ->options([
                                'attending' => 'Hadir',
                                'not_attending' => 'Tidak Hadir',
                            ])
                            ->required(),

                        TextInput::make('guest_count')
                            ->label('Jumlah Tamu')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(10)
                            ->required(),

                        Select::make('moderation_status')
                            ->label('Status Moderasi')
                            ->options([
                                'pending' => 'Menunggu',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                            ])
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }
}