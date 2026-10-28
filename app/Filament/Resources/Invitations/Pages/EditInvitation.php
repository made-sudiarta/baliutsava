<?php

namespace App\Filament\Resources\Invitations\Pages;

use App\Filament\Resources\Invitations\InvitationResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditInvitation extends EditRecord
{
    protected static string $resource = InvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview')
                ->label('Preview Undangan')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn () => route('invitations.preview', [
                    'invitation' => $this->record->id,
                ]))
                ->openUrlInNewTab(),

            // Pertahankan action lain yang sudah ada di sini.
        ];
    }
}
