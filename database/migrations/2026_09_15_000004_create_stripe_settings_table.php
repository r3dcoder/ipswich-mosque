<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stripe_settings', function (Blueprint $table) {
            $table->id();
            // Active mode: test | live
            $table->string('mode', 10)->default('test');

            // Test credentials (secrets stored encrypted via model casts)
            $table->text('test_public_key')->nullable();
            $table->text('test_secret_key')->nullable();
            $table->text('test_webhook_secret')->nullable();

            // Live / production credentials
            $table->text('live_public_key')->nullable();
            $table->text('live_secret_key')->nullable();
            $table->text('live_webhook_secret')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stripe_settings');
    }
};
