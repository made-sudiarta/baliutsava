<?php

namespace App\Filament\Resources\InvitationEvents\Pages;

use App\Filament\Resources\InvitationEvents\InvitationEventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInvitationEvent extends CreateRecord
{
    protected static string $resource = InvitationEventResource::class;
}
