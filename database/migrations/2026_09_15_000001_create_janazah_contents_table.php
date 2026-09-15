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
        Schema::create('janazah_contents', function (Blueprint $table) {
            $table->id();
            // Which part of the Janazah page this block belongs to:
            // hero | rite | prayer | terms | terms_point
            $table->string('section')->index();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('janazah_contents');
    }
};
