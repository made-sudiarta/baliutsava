<?php

namespace App\Filament\Resources\InvitationMessages\Pages;

use App\Filament\Resources\InvitationMessages\InvitationMessageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInvitationMessage extends CreateRecord
{
    protected static string $resource = InvitationMessageResource::class;
}
