<?php

namespace App\Filament\Resources\InvitationGalleries\Pages;

use App\Filament\Resources\InvitationGalleries\InvitationGalleryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditInvitationGallery extends EditRecord
{
    protected static string $resource = InvitationGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
