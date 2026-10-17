<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\InvitationGuest;
use App\Models\InvitationMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class InvitationMessageController extends Controller
{
    public function store(
        Request $request,
        string $slug
    ): RedirectResponse {
        $invitation = Invitation::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        abort_unless($invitation->show_messages, 404);

        $validated = $request->validate([
            'guest_token' => ['nullable', 'string'],
            'guest_name'  => ['required', 'string', 'max:100'],
            'message'     => ['required', 'string', 'max:1000'],
        ]);

        // Batasi pengiriman berulang dari alamat IP yang sama.
        $rateLimitKey = 'invitation-message:'
            . $invitation->id . ':'
            . hash('sha256', $request->ip());

        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            throw ValidationException::withMessages([
                'message' => 'Terlalu banyak pengiriman. Silakan coba lagi nanti.',
            ]);
        }

        $guest = null;

        // Validasi token jika undangan dibuka melalui tautan tamu.
        if (!empty($validated['guest_token'])) {
            $guest = InvitationGuest::query()
                ->where('invitation_id', $invitation->id)
                ->where('token', $validated['guest_token'])
                ->where('is_active', true)
                ->first();

            if (!$guest) {
                throw ValidationException::withMessages([
                    'guest_token' => 'Tautan tamu tidak valid atau sudah tidak aktif.',
                ]);
            }
        }

        // Simpan ucapan dan doa.
        $message = InvitationMessage::create([
            'invitation_id'       => $invitation->id,
            'invitation_guest_id' => $guest?->id,
            'guest_name'          => $validated['guest_name'],
            'message'             => $validated['message'],

            // Nilai kompatibilitas dengan struktur database lama.
            'attendance'          => 'pending',
            'guest_count'         => 1,

            'moderation_status' => 'approved',

            'ip_hash'             => hash(
                'sha256',
                $request->ip() . config('app.key')
            ),
        ]);

        RateLimiter::hit($rateLimitKey, 60);

        return redirect()
            ->route('invitations.show', ['slug' => $slug])
            ->with(
                'success',
                $invitation->moderate_messages
                    ? 'Terima kasih! Ucapan dan doa Anda berhasil dikirim.'
                    : 'Terima kasih! Ucapan dan doa Anda berhasil dikirim.'
            )
            ->withFragment('form-ucapan');
    }
}