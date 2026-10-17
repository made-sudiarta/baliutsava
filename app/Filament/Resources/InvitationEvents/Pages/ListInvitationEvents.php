<?php

namespace App\Filament\Resources\InvitationEvents\Pages;

use App\Filament\Resources\InvitationEvents\InvitationEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInvitationEvents extends ListRecords
{
    protected static string $resource = InvitationEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
