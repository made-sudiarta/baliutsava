<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class InvitationGuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'uuid',
        'name',
        'phone',
        'token',
        'guest_quota',
        'is_active',
        'opened_at',
        'invitation_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'guest_quota' => 'integer',
            'is_active' => 'boolean',
            'opened_at' => 'datetime',
            'invitation_sent_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (InvitationGuest $guest) {
            $guest->uuid ??= (string) Str::uuid();
            $guest->token ??= Str::random(40);
        });
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(InvitationMessage::class);
    }
}