<?php

namespace App\Filament\Resources\Invitations\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
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

            /*
            |--------------------------------------------------------------------------
            | 1. Informasi Undangan
            |--------------------------------------------------------------------------
            */
            Section::make('Informasi Undangan')
                ->description('Atur identitas utama dan alamat URL undangan.')
                ->icon('heroicon-o-envelope')
                ->schema([
                    TextInput::make('title')
                        ->label('Judul Undangan')
                        ->placeholder('Contoh: Elena & Jack Wedding')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, callable $set) {
                            $set('slug', Str::slug($state));
                        }),

                    TextInput::make('slug')
                        ->label('URL Undangan')
                        ->prefix('undangan/')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->helperText('URL unik untuk halaman undangan.'),

                    Select::make('event_type')
                        ->label('Jenis Acara')
                        ->options([
                            'karya padhiksan' => 'Karya Padhiksan',
                            'wedding' => 'Pernikahan',
                            'pawiwahan' => 'Pawiwihan Bali',
                            'birthday' => 'Ulang Tahun',
                            'engagement' => 'Pertunangan',
                            'other' => 'Lainnya',
                        ])
                        ->default('wedding')
                        ->required()
                        ->native(false),

                    TextInput::make('host_name')
                        ->label('Nama Mempelai Pertama')
                        ->placeholder('Nama lengkap mempelai pertama')
                        ->maxLength(255),

                    TextInput::make('partner_name')
                        ->label('Nama Mempelai Kedua')
                        ->placeholder('Nama lengkap mempelai kedua')
                        ->maxLength(255),
                ])
                ->columns([
                    'default' => 1,
                    'lg' => 2,
                ])
                ->columnSpanFull(),

            /*
            |--------------------------------------------------------------------------
            | 2. Waktu dan Lokasi
            |--------------------------------------------------------------------------
            */
            Section::make('Waktu dan Lokasi')
                ->description('Atur jadwal acara, tempat, alamat, dan kontak.')
                ->icon('heroicon-o-map-pin')
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
                        ->placeholder('Nama gedung, griya, atau lokasi acara')
                        ->maxLength(255),

                    Textarea::make('address')
                        ->label('Alamat Lengkap')
                        ->placeholder('Masukkan alamat lokasi acara')
                        ->rows(3)
                        ->columnSpanFull(),

                    TextInput::make('maps_url')
                        ->label('URL Google Maps')
                        ->placeholder('https://maps.app.goo.gl/...')
                        ->url()
                        ->maxLength(255),

                    TextInput::make('whatsapp_number')
                        ->label('Nomor WhatsApp')
                        ->placeholder('08xxxxxxxxxx')
                        ->tel()
                        ->maxLength(30),
                ])
                ->columns([
                    'default' => 1,
                    'lg' => 2,
                ])
                ->columnSpanFull(),

            /*
            |--------------------------------------------------------------------------
            | 3. Konten Undangan
            |--------------------------------------------------------------------------
            */
            Section::make('Konten Undangan')
                ->description('Atur pesan pembuka dan gambar sampul undangan.')
                ->icon('heroicon-o-document-text')
                ->schema([
                    RichEditor::make('description')
                        ->label('Deskripsi Undangan')
                        ->placeholder('Tuliskan pengantar undangan...')
                        ->columnSpanFull(),

                    FileUpload::make('cover_image')
                        ->label('Foto Cover')
                        ->image()
                        ->disk('public')
                        ->directory('invitations/covers')
                        ->visibility('public')
                        ->imagePreviewHeight('240')
                        ->maxSize(5120)
                        ->helperText('Format gambar. Maksimal 5 MB.')
                        ->columnSpanFull(),
                ])
                ->columns([
                    'default' => 1,
                    'lg' => 2,
                ])
                ->columnSpanFull(),

            /*
            |--------------------------------------------------------------------------
            | 4. Identitas Visual
            |--------------------------------------------------------------------------
            */
            Section::make('Identitas Visual')
                ->description('Pilih tema dan unggah logo untuk identitas undangan.')
                ->icon('heroicon-o-swatch')
                ->schema([
                    Select::make('theme')
                        ->label('Tema Undangan')
                        ->options([
                            'bali-elegant' => 'Bali Elegant',
                            'modern-minimalis' => 'Modern Minimalis',
                            'superior-modern' => 'Superior Modern',
                        ])
                        ->default('bali-elegant')
                        ->required()
                        ->native(false),

                    FileUpload::make('logo_path')
                        ->label('Logo Undangan')
                        ->image()
                        ->disk('public')
                        ->directory('invitations/logos')
                        ->visibility('public')
                        ->imagePreviewHeight('180')
                        ->maxSize(2048)
                        ->helperText('Disarankan PNG transparan.')
                        ->columnSpanFull(),
                ])
                ->columns([
                    'default' => 1,
                    'lg' => 2,
                ])
                ->columnSpanFull(),

            /*
            |--------------------------------------------------------------------------
            | 5. Foto Mempelai
            |--------------------------------------------------------------------------
            */
            Section::make('Foto Mempelai')
                ->description('Pilih satu foto bersama atau dua foto terpisah.')
                ->icon('heroicon-o-camera')
                ->schema([
                    Select::make('partner_photo_mode')
                        ->label('Mode Foto')
                        ->options([
                            'single' => 'Satu Foto Bersama',
                            'double' => 'Dua Foto Terpisah',
                        ])
                        ->default('single')
                        ->live()
                        ->required()
                        ->native(false)
                        ->columnSpanFull(),

                    FileUpload::make('couple_photo')
                        ->label('Foto Pasangan Bersama')
                        ->image()
                        ->disk('public')
                        ->directory('invitations/partners')
                        ->visibility('public')
                        ->imagePreviewHeight('240')
                        ->maxSize(5120)
                        ->imageEditor()
                        ->visible(fn ($get) => $get('partner_photo_mode') === 'single')
                        ->columnSpanFull(),

                    FileUpload::make('partner_photo_1')
                        ->label('Foto Partner Pertama')
                        ->image()
                        ->disk('public')
                        ->directory('invitations/partners')
                        ->visibility('public')
                        ->imagePreviewHeight('240')
                        ->maxSize(5120)
                        ->imageEditor()
                        ->visible(fn ($get) => $get('partner_photo_mode') === 'double'),

                    FileUpload::make('partner_photo_2')
                        ->label('Foto Partner Kedua')
                        ->image()
                        ->disk('public')
                        ->directory('invitations/partners')
                        ->visibility('public')
                        ->imagePreviewHeight('240')
                        ->maxSize(5120)
                        ->imageEditor()
                        ->visible(fn ($get) => $get('partner_photo_mode') === 'double'),
                ])
                ->columns([
                    'default' => 1,
                    'lg' => 2,
                ])
                ->columnSpanFull()
                ->collapsible(),

            /*
            |--------------------------------------------------------------------------
            | 6. Musik Latar
            |--------------------------------------------------------------------------
            */
            Section::make('Musik Latar')
                ->description('Unggah musik yang diputar saat undangan dibuka.')
                ->icon('heroicon-o-musical-note')
                ->schema([
                    FileUpload::make('music_path')
                        ->label('File Musik')
                        ->disk('public')
                        ->directory('invitations/music')
                        ->visibility('public')
                        ->acceptedFileTypes([
                            'audio/mpeg',
                            'audio/mp3',
                            'audio/mp4',
                            'video/mp4',
                            'audio/aac',
                            'audio/wav',
                            'audio/x-wav',
                            'audio/ogg',
                            'audio/x-m4a',
                        ])
                        ->maxSize(10240)
                        ->helperText('Maksimal 10 MB. Disarankan menggunakan file MP3.')
                        ->columnSpanFull(),
                ])
                ->columnSpanFull()
                ->collapsible(),

            /*
            |--------------------------------------------------------------------------
            | 7. Hadiah Digital
            |--------------------------------------------------------------------------
            */
            Section::make('Hadiah Digital')
                ->description('Kelola rekening bank untuk hadiah digital.')
                ->icon('heroicon-o-gift')
                ->schema([
                    Toggle::make('show_gifts')
                        ->label('Tampilkan Hadiah Digital')
                        ->default(false)
                        ->live()
                        ->columnSpanFull(),

                    TextInput::make('gift_title')
                        ->label('Judul Bagian')
                        ->placeholder('Hadiah')
                        ->default('Hadiah')
                        ->maxLength(255)
                        ->visible(fn ($get) => $get('show_gifts')),

                    Textarea::make('gift_description')
                        ->label('Deskripsi Hadiah')
                        ->default('Tanpa mengurangi rasa hormat, tanda kasih untuk kami dapat disampaikan melalui:')
                        ->rows(3)
                        ->visible(fn ($get) => $get('show_gifts')),

                    Repeater::make('gifts')
                        ->label('Daftar Rekening')
                        ->relationship()
                        ->schema([
                            TextInput::make('bank_name')
                                ->label('Nama Bank')
                                ->placeholder('Contoh: BCA')
                                ->required()
                                ->maxLength(100),

                            TextInput::make('account_number')
                                ->label('Nomor Rekening')
                                ->required()
                                ->maxLength(100),

                            TextInput::make('account_holder')
                                ->label('Nama Pemilik Rekening')
                                ->required()
                                ->maxLength(255),

                            FileUpload::make('bank_logo')
                                ->label('Logo Bank')
                                ->image()
                                ->disk('public')
                                ->directory('invitations/banks')
                                ->visibility('public')
                                ->imagePreviewHeight('120')
                                ->maxSize(2048),

                            Toggle::make('is_active')
                                ->label('Rekening Aktif')
                                ->default(true),

                            TextInput::make('sort_order')
                                ->label('Urutan Tampilan')
                                ->numeric()
                                ->default(0)
                                ->required(),
                        ])
                        ->columns([
                            'default' => 1,
                            'md' => 2,
                        ])
                        ->reorderable()
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string =>
                            $state['bank_name'] ?? 'Rekening Baru'
                        )
                        ->defaultItems(0)
                        ->addActionLabel('Tambah Rekening')
                        ->visible(fn ($get) => $get('show_gifts'))
                        ->columnSpanFull(),
                ])
                ->columns([
                    'default' => 1,
                    'lg' => 2,
                ])
                ->columnSpanFull()
                ->collapsible(),

            /*
            |--------------------------------------------------------------------------
            | 8. Pengaturan Publikasi
            |--------------------------------------------------------------------------
            */
            Section::make('Pengaturan Publikasi')
                ->description('Atur status undangan dan pengelolaan ucapan tamu.')
                ->icon('heroicon-o-cog-6-tooth')
                ->schema([
                    Toggle::make('is_active')
                        ->label('Publikasikan Undangan')
                        ->helperText('Jika nonaktif, halaman undangan tidak dapat diakses.')
                        ->default(true),

                    Toggle::make('show_messages')
                        ->label('Tampilkan Ucapan dan Doa')
                        ->default(true),

                    Toggle::make('moderate_messages')
                        ->label('Ucapan Harus Disetujui')
                        ->helperText('Aktifkan jika ucapan perlu dimoderasi sebelum tampil.')
                        ->default(true),
                ])
                ->columns([
                    'default' => 1,
                    'lg' => 2,
                ])
                ->columnSpanFull(),

        ]);
    }
}
