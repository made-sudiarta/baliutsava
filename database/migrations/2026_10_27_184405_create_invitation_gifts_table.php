
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_gifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_holder');
            $table->string('bank_logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::table('invitations', function (Blueprint $table) {
            $table->boolean('show_gifts')->default(false);
            $table->string('gift_title')->nullable();
            $table->text('gift_description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn([
                'show_gifts',
                'gift_title',
                'gift_description',
            ]);
        });

        Schema::dropIfExists('invitation_gifts');
    }
};
