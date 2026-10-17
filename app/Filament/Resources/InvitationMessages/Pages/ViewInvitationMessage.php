<?php

namespace App\Filament\Resources\InvitationMessages\Pages;

use App\Filament\Resources\InvitationMessages\InvitationMessageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInvitationMessage extends ViewRecord
{
    protected static string $resource = InvitationMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
