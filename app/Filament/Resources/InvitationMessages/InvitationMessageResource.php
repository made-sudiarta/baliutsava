<?php

namespace App\Filament\Resources\InvitationMessages;

use App\Filament\Resources\InvitationMessages\Pages\CreateInvitationMessage;
use App\Filament\Resources\InvitationMessages\Pages\EditInvitationMessage;
use App\Filament\Resources\InvitationMessages\Pages\ListInvitationMessages;
use App\Filament\Resources\InvitationMessages\Pages\ViewInvitationMessage;
use App\Filament\Resources\InvitationMessages\Schemas\InvitationMessageForm;
use App\Filament\Resources\InvitationMessages\Schemas\InvitationMessageInfolist;
use App\Filament\Resources\InvitationMessages\Tables\InvitationMessagesTable;
use App\Models\InvitationMessage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InvitationMessageResource extends Resource
{
    protected static ?string $model = InvitationMessage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'InvitationMessage';

    public static function form(Schema $schema): Schema
    {
        return InvitationMessageForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InvitationMessageInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvitationMessagesTable::configure($table);
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
            'index' => ListInvitationMessages::route('/'),
            'create' => CreateInvitationMessage::route('/create'),
            'view' => ViewInvitationMessage::route('/{record}'),
            'edit' => EditInvitationMessage::route('/{record}/edit'),
        ];
    }
}
