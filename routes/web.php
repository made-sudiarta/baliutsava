<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\InvitationMessageController;


Route::redirect('/', '/admin/login'); //UPDATE
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