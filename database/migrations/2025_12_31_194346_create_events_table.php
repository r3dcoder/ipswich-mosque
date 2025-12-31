<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('title', 255);
            $table->dateTime('starts_at'); // date + time
            $table->string('location', 255)->nullable(); // "Main Prayer Hall"
            $table->text('description')->nullable();

            $table->unsignedInteger('sort_order')->default(1);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['is_active', 'starts_at', 'sort_order'], 'idx_events_active_date_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
