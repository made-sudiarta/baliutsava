<?php

namespace App\Filament\Resources\InvitationEvents\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InvitationEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Acara')
                ->schema([
                    Select::make('invitation_id')
                        ->label('Undangan')
                        ->relationship('invitation', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),

                    TextInput::make('title')
                        ->label('Nama Acara')
                        ->required()
                        ->maxLength(255),

                    Textarea::make('description')
                        ->label('Keterangan')
                        ->rows(3)
                        ->columnSpanFull(),

                    DateTimePicker::make('starts_at')
                        ->label('Waktu Mulai')
                        ->seconds(false)
                        ->native(false),

                    DateTimePicker::make('ends_at')
                        ->label('Waktu Selesai')
                        ->seconds(false)
                        ->native(false),

                    TextInput::make('sort_order')
                        ->label('Urutan')
                        ->numeric()
                        ->integer()
                        ->default(0)
                        ->required(),

                    Toggle::make('is_active')
                        ->label('Tampilkan Acara')
                        ->default(true),
                ])
                ->columns(2),
        ]);
    }
}