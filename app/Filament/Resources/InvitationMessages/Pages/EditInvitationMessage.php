<?php

namespace App\Filament\Resources\InvitationMessages\Pages;

use App\Filament\Resources\InvitationMessages\InvitationMessageResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditInvitationMessage extends EditRecord
{
    protected static string $resource = InvitationMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
