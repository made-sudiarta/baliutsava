<?php

use App\Models\Invitation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\InvitationMessageController;


Route::redirect('/', '/admin/login');
Route::get('/undangan/{slug}', [
    InvitationController::class,
    'show',
])->name('invitations.show');

Route::post('/undangan/{slug}/ucapan', [
    InvitationMessageController::class,
    'store',
])->middleware('throttle:10,1')
  ->name('invitations.messages.store');

 Route::get('/undangan/{slug}/ucapan', [
    \App\Http\Controllers\InvitationController::class,
    'messages',
])->name('invitations.messages.index');

Route::get('/admin/undangan/{invitation}/preview', function (Invitation $invitation) {
    abort_unless(auth()->check(), 403);

    $invitation->load([
        'events' => fn ($query) => $query
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('starts_at'),

        'galleries' => fn ($query) => $query
            ->where('is_active', true)
            ->orderBy('sort_order'),
    ]);

    $messages = $invitation->messages()
        ->where('moderation_status', 'approved')
        ->latest()
        ->paginate(5);

    $guest = null;

    $availableThemes = [
        'bali-elegant' => 'invitations.themes.bali-elegant',
        'modern-minimalis' => 'invitations.themes.modern-minimalis',
    ];

    $themeView = $availableThemes[$invitation->theme]
        ?? $availableThemes['bali-elegant'];

    return view($themeView, compact(
        'invitation',
        'guest',
        'messages'
    ));
})->middleware('auth')->name('invitations.preview');