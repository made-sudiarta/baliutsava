<?php

namespace App\Filament\Resources\InvitationEvents;

use App\Filament\Resources\InvitationEvents\Pages\CreateInvitationEvent;
use App\Filament\Resources\InvitationEvents\Pages\EditInvitationEvent;
use App\Filament\Resources\InvitationEvents\Pages\ListInvitationEvents;
use App\Filament\Resources\InvitationEvents\Pages\ViewInvitationEvent;
use App\Filament\Resources\InvitationEvents\Schemas\InvitationEventForm;
use App\Filament\Resources\InvitationEvents\Schemas\InvitationEventInfolist;
use App\Filament\Resources\InvitationEvents\Tables\InvitationEventsTable;
use App\Models\InvitationEvent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InvitationEventResource extends Resource
{
    protected static ?string $model = InvitationEvent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'InvitationEvent';

    public static function form(Schema $schema): Schema
    {
        return InvitationEventForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InvitationEventInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvitationEventsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInvitationEvents::route('/'),
            'create' => CreateInvitationEvent::route('/create'),
            'view' => ViewInvitationEvent::route('/{record}'),
            'edit' => EditInvitationEvent::route('/{record}/edit'),
        ];
    }
}
