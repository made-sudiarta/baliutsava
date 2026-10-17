<?php

namespace App\Filament\Resources\InvitationEvents\Pages;

use App\Filament\Resources\InvitationEvents\InvitationEventResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditInvitationEvent extends EditRecord
{
    protected static string $resource = InvitationEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
