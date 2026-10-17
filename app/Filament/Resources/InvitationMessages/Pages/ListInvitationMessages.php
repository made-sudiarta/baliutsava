<?php

namespace App\Filament\Resources\InvitationMessages\Pages;

use App\Filament\Resources\InvitationMessages\InvitationMessageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInvitationMessages extends ListRecords
{
    protected static string $resource = InvitationMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
