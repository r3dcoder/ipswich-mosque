<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('carousel_slides', function (Blueprint $table) {
            $table->id();

            // Which page this carousel belongs to (home, donate, events, etc.)
            $table->string('page')->index(); // e.g. "home"

            $table->string('title');
            $table->string('category')->nullable();
            $table->string('subtitle')->nullable();

            // Image stored in storage/public
            $table->string('image_path');

            // Button
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();

            // Display controls
            $table->unsignedInteger('sort_order')->default(1);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['page', 'is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carousel_slides');
    }
};
