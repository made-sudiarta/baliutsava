<?php

namespace App\Filament\Resources\Invitations\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class InvitationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Undangan')
                ->schema([
                    TextInput::make('title')
                        ->label('Judul Undangan')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, callable $set) {
                            $set('slug', Str::slug($state));
                        }),

                    TextInput::make('slug')
                        ->label('URL Undangan')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->helperText('Contoh: pawiwahan-made-dan-sari'),

                    Select::make('event_type')
                        ->label('Jenis Acara')
                        ->options([
                            'karya padhiksan' => 'Karya Padhiksan',
                            'wedding' => 'Pernikahan',
                            'pawiwahan' => 'Pawiwahan Bali',
                            'birthday' => 'Ulang Tahun',
                            'engagement' => 'Pertunangan',
                            'other' => 'Lainnya',
                        ])
                        ->default('wedding')
                        ->required(),

                    TextInput::make('host_name')
                        ->label('Nama Mempelai Pertama')
                        ->maxLength(255),

                    TextInput::make('partner_name')
                        ->label('Nama Mempelai Kedua')
                        ->maxLength(255),
                ])
                ->columns(2),

            Section::make('Waktu dan Lokasi')
                ->schema([
                    DateTimePicker::make('event_starts_at')
                        ->label('Tanggal dan Waktu Mulai')
                        ->seconds(false)
                        ->native(false),

                    DateTimePicker::make('event_ends_at')
                        ->label('Tanggal dan Waktu Selesai')
                        ->seconds(false)
                        ->native(false),

                    TextInput::make('venue_name')
                        ->label('Nama Tempat')
                        ->maxLength(255),

                    Textarea::make('address')
                        ->label('Alamat')
                        ->rows(3),

                    TextInput::make('maps_url')
                        ->label('URL Google Maps')
                        ->url()
                        ->maxLength(255),

                    TextInput::make('whatsapp_number')
                        ->label('Nomor WhatsApp')
                        ->tel()
                        ->maxLength(30),
                ])
                ->columns(2),

            Section::make('Konten dan Tampilan')
                ->schema([
                    RichEditor::make('description')
                        ->label('Deskripsi Undangan')
                        ->columnSpanFull(),

                    FileUpload::make('cover_image')
                        ->label('Foto Cover')
                        ->image()
                        ->disk('public')
                        ->directory('invitations/covers')
                        ->visibility('public')
                        ->maxSize(5120),


                    FileUpload::make('music_path')
                        ->label('Musik Latar')
                        ->disk('public')
                        ->directory('invitations/music')
                        ->visibility('public')
                        ->acceptedFileTypes([
                            'audio/mpeg',
                            'audio/mp3',
                            'audio/mp4',
                            'audio/aac',
                            'audio/wav',
                            'audio/x-wav',
                            'audio/ogg',
                        ])
                        ->maxSize(10240),

                    Select::make('theme')
                        ->label('Tema')
                        ->options([
                            'bali-elegant' => 'Bali Elegant',
                            'classic' => 'Classic',
                            'modern' => 'Modern',
                        ])
                        ->default('bali-elegant')
                        ->required(),

                    FileUpload::make('logo_path')
                        ->label('Logo Undangan')
                        ->image()
                        ->disk('public')
                        ->directory('invitations/logos')
                        ->visibility('public')
                        ->maxSize(2048)
                        ->helperText('Logo PNG transparan disarankan.'),

                    Toggle::make('is_active')
                        ->label('Publikasikan Undangan')
                        ->default(true),

                    Toggle::make('show_messages')
                        ->label('Tampilkan Ucapan')
                        ->default(true),

                    Toggle::make('moderate_messages')
                        ->label('Ucapan Harus Disetujui')
                        ->default(true),
                    
                    Select::make('partner_photo_mode')
                        ->label('Mode Foto Partner')
                        ->options([
                            'single' => 'Satu Foto Bersama',
                            'double' => 'Dua Foto Terpisah',
                        ])
                        ->default('single')
                        ->live()
                        ->required(),

                    FileUpload::make('couple_photo')
                        ->label('Foto Pasangan Bersama')
                        ->image()
                        ->disk('public')
                        ->directory('invitations/partners')
                        ->visibility('public')
                        ->imagePreviewHeight('200')
                        ->maxSize(5120)
                        ->imageEditor()
                        ->visible(fn ($get) => $get('partner_photo_mode') === 'single'),

                    FileUpload::make('partner_photo_1')
                        ->label('Foto Partner Pertama')
                        ->image()
                        ->disk('public')
                        ->directory('invitations/partners')
                        ->visibility('public')
                        ->maxSize(5120)
                        ->imageEditor()
                        ->visible(fn ($get) => $get('partner_photo_mode') === 'double'),

                    FileUpload::make('partner_photo_2')
                        ->label('Foto Partner Kedua')
                        ->image()
                        ->disk('public')
                        ->directory('invitations/partners')
                        ->visibility('public')
                        ->maxSize(5120)
                        ->imageEditor()
                        ->visible(fn ($get) => $get('partner_photo_mode') === 'double'),
                                    ])
                ->columns(2),
        ]);
    }
}