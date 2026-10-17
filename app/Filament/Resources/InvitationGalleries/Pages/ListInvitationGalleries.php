<?php

namespace App\Filament\Resources\InvitationGalleries\Pages;

use App\Filament\Resources\InvitationGalleries\InvitationGalleryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInvitationGalleries extends ListRecords
{
    protected static string $resource = InvitationGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
