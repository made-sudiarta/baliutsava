<?php

namespace App\Filament\Resources\InvitationGuests\Pages;

use App\Filament\Resources\InvitationGuests\InvitationGuestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditInvitationGuest extends EditRecord
{
    protected static string $resource = InvitationGuestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
