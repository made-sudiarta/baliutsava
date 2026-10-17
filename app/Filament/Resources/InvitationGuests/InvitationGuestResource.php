<?php

namespace App\Filament\Resources\InvitationGuests;

use App\Filament\Resources\InvitationGuests\Pages\CreateInvitationGuest;
use App\Filament\Resources\InvitationGuests\Pages\EditInvitationGuest;
use App\Filament\Resources\InvitationGuests\Pages\ListInvitationGuests;
use App\Filament\Resources\InvitationGuests\Pages\ViewInvitationGuest;
use App\Filament\Resources\InvitationGuests\Schemas\InvitationGuestForm;
use App\Filament\Resources\InvitationGuests\Schemas\InvitationGuestInfolist;
use App\Filament\Resources\InvitationGuests\Tables\InvitationGuestsTable;
use App\Models\InvitationGuest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InvitationGuestResource extends Resource
{
    protected static ?string $model = InvitationGuest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'InvitationGuest';

    public static function form(Schema $schema): Schema
    {
        return InvitationGuestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InvitationGuestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvitationGuestsTable::configure($table);
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
            'index' => ListInvitationGuests::route('/'),
            'create' => CreateInvitationGuest::route('/create'),
            'view' => ViewInvitationGuest::route('/{record}'),
            'edit' => EditInvitationGuest::route('/{record}/edit'),
        ];
    }
}
