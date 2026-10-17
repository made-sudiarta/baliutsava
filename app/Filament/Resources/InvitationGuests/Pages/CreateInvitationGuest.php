<?php

namespace App\Filament\Resources\InvitationGuests\Pages;

use App\Filament\Resources\InvitationGuests\InvitationGuestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInvitationGuest extends CreateRecord
{
    protected static string $resource = InvitationGuestResource::class;
}
