<?php

namespace App\Filament\Resources\InvitationGuests\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InvitationGuestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Data Tamu')
                ->schema([
                    Select::make('invitation_id')
                        ->label('Undangan')
                        ->relationship('invitation', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),

                    TextInput::make('name')
                        ->label('Nama Tamu')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('phone')
                        ->label('Nomor WhatsApp')
                        ->tel()
                        ->placeholder('081234567890')
                        ->maxLength(20)
                        ->helperText('Gunakan nomor WhatsApp aktif milik tamu.')
                        ->nullable(),

                    TextInput::make('guest_quota')
                        ->label('Kuota Orang')
                        ->numeric()
                        ->integer()
                        ->minValue(1)
                        ->maxValue(100)
                        ->default(1)
                        ->required(),

                    Toggle::make('is_active')
                        ->label('Tautan Aktif')
                        ->default(true),
                ])
                ->columns(2),
        ]);
    }
}