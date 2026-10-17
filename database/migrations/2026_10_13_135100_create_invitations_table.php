<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('event_type')->default('wedding');

            $table->string('host_name')->nullable();
            $table->string('partner_name')->nullable();

            $table->string('venue_name')->nullable();
            $table->text('address')->nullable();
            $table->string('maps_url')->nullable();

            $table->dateTime('event_starts_at')->nullable();
            $table->dateTime('event_ends_at')->nullable();

            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('music_path')->nullable();
            $table->string('whatsapp_number')->nullable();

            $table->string('theme')->default('bali-elegant');
            $table->json('settings')->nullable();

            $table->boolean('is_active')->default(true);
            $table->boolean('show_messages')->default(true);
            $table->boolean('moderate_messages')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
