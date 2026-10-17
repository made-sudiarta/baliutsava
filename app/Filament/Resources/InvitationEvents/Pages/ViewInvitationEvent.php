<?php

namespace App\Filament\Resources\InvitationEvents\Pages;

use App\Filament\Resources\InvitationEvents\InvitationEventResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInvitationEvent extends ViewRecord
{
    protected static string $resource = InvitationEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
