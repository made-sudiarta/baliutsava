<?php

namespace App\Filament\Pages;

use App\Models\Invitation;
use App\Models\InvitationGuest;
use App\Models\InvitationMessage;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class DetailUndangan extends Page
{
    use WithPagination;

    protected static string|\BackedEnum|null $navigationIcon =
        'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Detail Undangan';

    protected static ?string $title = 'Detail Undangan';

    protected string $view = 'filament.pages.detail-undangan';

    public ?string $invitationId = null;

    public function updatedInvitationId(): void
    {
        $this->resetPage();
    }

    public function getInvitationsProperty()
    {
        return Invitation::query()
            ->orderBy('title')
            ->get(['id', 'title']);
    }

    public function getInvitationProperty(): ?Invitation
    {
        if (! $this->invitationId) {
            return null;
        }

        return Invitation::find($this->invitationId);
    }

    protected function guestQuery(): Builder
    {
        return InvitationGuest::query()
            ->where('invitation_id', $this->invitationId);
    }

    public function getStatsProperty(): array
    {
        if (! $this->invitationId) {
            return [
                'guests' => 0,
                'sent' => 0,
                'unsent' => 0,
                'pending' => 0,
                'attending' => 0,
                'people' => 0,
                'not_attending' => 0,
            ];
        }

        $messages = InvitationMessage::query()
            ->where('invitation_id', $this->invitationId);

        $approved = (clone $messages)
            ->where('moderation_status', 'approved');

        return [
            'guests' => (clone $this->guestQuery())->count(),

            'sent' => (clone $this->guestQuery())
                ->whereNotNull('invitation_sent_at')
                ->count(),

            'unsent' => (clone $this->guestQuery())
                ->whereNull('invitation_sent_at')
                ->count(),

            'pending' => (clone $messages)
                ->where('moderation_status', 'pending')
                ->count(),

            'attending' => (clone $approved)
                ->where('attendance', 'attending')
                ->count(),

            'people' => (clone $approved)
                ->where('attendance', 'attending')
                ->sum('guest_count'),

            'not_attending' => (clone $approved)
                ->where('attendance', 'not_attending')
                ->count(),
        ];
    }

    public function getGuestsProperty()
    {
        if (! $this->invitationId) {
            return InvitationGuest::query()
                ->whereRaw('1 = 0')
                ->paginate(15);
        }

        return $this->guestQuery()
            ->orderBy('name')
            ->paginate(15, ['*'], 'guestsPage');
    }

    public function getMessagesProperty()
    {
        if (! $this->invitationId) {
            return InvitationMessage::query()
                ->whereRaw('1 = 0')
                ->paginate(10, ['*'], 'messagesPage');
        }

        return InvitationMessage::query()
            ->where('invitation_id', $this->invitationId)
            ->latest()
            ->paginate(10, ['*'], 'messagesPage');
    }
}