<?php

namespace App\Filament\Resources\InvitationGalleries\Pages;

use App\Filament\Resources\InvitationGalleries\InvitationGalleryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInvitationGallery extends ViewRecord
{
    protected static string $resource = InvitationGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
