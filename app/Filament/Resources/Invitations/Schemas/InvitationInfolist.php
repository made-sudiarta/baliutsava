<?php

namespace App\Filament\Resources\Invitations\Schemas;

use App\Models\Invitation;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InvitationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('uuid')
                    ->label('UUID'),
                TextEntry::make('slug'),
                TextEntry::make('title'),
                TextEntry::make('event_type'),
                TextEntry::make('host_name')
                    ->placeholder('-'),
                TextEntry::make('partner_name')
                    ->placeholder('-'),
                TextEntry::make('venue_name')
                    ->placeholder('-'),
                TextEntry::make('address')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('maps_url')
                    ->placeholder('-'),
                TextEntry::make('event_starts_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('event_ends_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('cover_image')
                    ->placeholder('-'),
                TextEntry::make('music_path')
                    ->placeholder('-'),
                TextEntry::make('whatsapp_number')
                    ->placeholder('-'),
                TextEntry::make('theme'),
                IconEntry::make('is_active')
                    ->boolean(),
                IconEntry::make('show_messages')
                    ->boolean(),
                IconEntry::make('moderate_messages')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Invitation $record): bool => $record->trashed()),
            ]);
    }
}
