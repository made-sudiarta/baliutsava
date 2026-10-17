<?php

namespace App\Filament\Resources\InvitationMessages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InvitationMessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('invitation.title')
                    ->label('Invitation'),
                TextEntry::make('invitation_guest_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('guest_name'),
                TextEntry::make('message')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('attendance'),
                TextEntry::make('guest_count')
                    ->numeric(),
                TextEntry::make('moderation_status'),
                TextEntry::make('ip_hash')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
