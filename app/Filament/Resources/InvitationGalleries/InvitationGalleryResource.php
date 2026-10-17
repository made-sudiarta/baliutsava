<?php

namespace App\Filament\Resources\InvitationGalleries;

use App\Filament\Resources\InvitationGalleries\Pages\CreateInvitationGallery;
use App\Filament\Resources\InvitationGalleries\Pages\EditInvitationGallery;
use App\Filament\Resources\InvitationGalleries\Pages\ListInvitationGalleries;
use App\Filament\Resources\InvitationGalleries\Pages\ViewInvitationGallery;
use App\Filament\Resources\InvitationGalleries\Schemas\InvitationGalleryForm;
use App\Filament\Resources\InvitationGalleries\Schemas\InvitationGalleryInfolist;
use App\Filament\Resources\InvitationGalleries\Tables\InvitationGalleriesTable;
use App\Models\InvitationGallery;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InvitationGalleryResource extends Resource
{
    protected static ?string $model = InvitationGallery::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'InvitationGallery';

    public static function form(Schema $schema): Schema
    {
        return InvitationGalleryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InvitationGalleryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvitationGalleriesTable::configure($table);
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
            'index' => ListInvitationGalleries::route('/'),
            'create' => CreateInvitationGallery::route('/create'),
            'view' => ViewInvitationGallery::route('/{record}'),
            'edit' => EditInvitationGallery::route('/{record}/edit'),
        ];
    }
}
