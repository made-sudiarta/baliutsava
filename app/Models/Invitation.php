<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'slug',
        'title',
        'event_type',
        'host_name',
        'partner_name',
        'venue_name',
        'address',
        'maps_url',
        'event_starts_at',
        'event_ends_at',
        'description',
        'cover_image',
        'music_path',
        'whatsapp_number',
        'theme',
        'settings',
        'is_active',
        'show_messages',
        'moderate_messages',
        'logo_path',
        'partner_photo_mode',
        'couple_photo',
        'partner_photo_1',
        'partner_photo_2',
    ];

    protected function casts(): array
    {
        return [
            'event_starts_at' => 'datetime',
            'event_ends_at' => 'datetime',
            'settings' => 'array',
            'is_active' => 'boolean',
            'show_messages' => 'boolean',
            'moderate_messages' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Invitation $invitation) {
            $invitation->uuid ??= (string) Str::uuid();
        });
    }

    public function events(): HasMany
    {
        return $this->hasMany(InvitationEvent::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(InvitationGallery::class);
    }

    public function guests(): HasMany
    {
        return $this->hasMany(InvitationGuest::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(InvitationMessage::class);
    }
}