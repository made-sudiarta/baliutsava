<?php

namespace App\Filament\Resources\InvitationGalleries\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InvitationGalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Foto Galeri')
                ->schema([
                    Select::make('invitation_id')
                        ->label('Undangan')
                        ->relationship('invitation', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('media_type')
                        ->label('Jenis Media')
                        ->options([
                            'image' => 'Gambar',
                            'video' => 'Video',
                        ])
                        ->default('image')
                        ->required(),

                    FileUpload::make('file_path')
                        ->label('File Media')
                        ->disk('public')
                        ->directory('invitations/gallery')
                        ->visibility('public')
                        ->image()
                        ->maxSize(5120)
                        ->required(),

                    TextInput::make('caption')
                        ->label('Keterangan')
                        ->maxLength(255),

                    TextInput::make('sort_order')
                        ->label('Urutan')
                        ->numeric()
                        ->integer()
                        ->default(0)
                        ->required(),

                    Toggle::make('is_active')
                        ->label('Tampilkan di Undangan')
                        ->default(true),
                ])
                ->columns(2),
        ]);
    }
}