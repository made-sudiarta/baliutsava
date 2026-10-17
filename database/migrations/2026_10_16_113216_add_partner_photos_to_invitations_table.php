<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('partner_photo_mode')
                ->default('single')
                ->after('partner_name');

            $table->string('couple_photo')->nullable();

            $table->string('partner_photo_1')->nullable();
            $table->string('partner_photo_2')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn([
                'partner_photo_mode',
                'couple_photo',
                'partner_photo_1',
                'partner_photo_2',
            ]);
        });
    }
};