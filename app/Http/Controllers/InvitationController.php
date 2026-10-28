<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\InvitationGuest;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function show(Request $request, string $slug)
    {
        
        $invitation = Invitation::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'events' => fn ($query) => $query
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('starts_at'),

                'galleries' => fn ($query) => $query
                    ->where('is_active', true)
                    ->orderBy('sort_order'),

                'gifts' => fn ($query) => $query
                    ->where('is_active', true)
                    ->orderBy('sort_order'),
            ])
            ->firstOrFail();


        // Pagination ucapan dan doa
        $messages = $invitation->messages()
            ->where('moderation_status', 'approved')
            ->latest()
            ->paginate(3)
            ->withQueryString();

        // Tamu undangan berdasarkan token URL
        $guest = null;
        $token = $request->query('to');

        if (is_string($token) && $token !== '') {
            $guest = InvitationGuest::query()
                ->where('invitation_id', $invitation->id)
                ->where('token', $token)
                ->where('is_active', true)
                ->first();

            if ($guest && !$guest->opened_at) {
                $guest->forceFill([
                    'opened_at' => now(),
                ])->save();
            }
        }

        $availableThemes = [
            'bali-elegant' => 'invitations.themes.bali-elegant',
            'modern-minimalis' => 'invitations.themes.modern-minimalis',
            'superior-modern' => 'invitations.themes.superior-modern',
        ];

        $themeView = $availableThemes[$invitation->theme]
            ?? $availableThemes['bali-elegant'];

        return view($themeView, compact(
            'invitation',
            'guest',
            'messages'
        ));
    }

    public function messages(Request $request, string $slug)
    {
        $invitation = Invitation::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        abort_unless($invitation->show_messages, 404);

        $messages = $invitation->messages()
            ->where('moderation_status', 'approved')
            ->latest()
            ->paginate(5)
            ->withPath(route('invitations.messages.index', [
                'slug' => $invitation->slug,
            ]))
            ->withQueryString();

        if ($request->ajax()) {
            return view('invitations.partials.messages', compact('messages'));
        }

        return redirect()->route('invitations.show', $slug);
    }
}