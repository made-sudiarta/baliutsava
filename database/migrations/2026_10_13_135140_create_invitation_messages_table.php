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
        Schema::create('invitation_messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('invitation_id')
                ->constrained('invitations')
                ->cascadeOnDelete();

            $table->foreignId('invitation_guest_id')
                ->nullable()
                ->constrained('invitation_guests')
                ->nullOnDelete();

            $table->string('guest_name');
            $table->text('message')->nullable();

            $table->string('attendance')
                ->default('pending');

            $table->unsignedSmallInteger('guest_count')->default(1);

            $table->string('moderation_status')
                ->default('pending');

            $table->string('ip_hash', 64)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_messages');
    }
};
