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
        Schema::create('ramadan_settings', function (Blueprint $table) {
            $table->id();
            $table->year('year')->unique();               // e.g. 2026
            $table->date('start_date')->nullable();       // first fast day
            $table->string('title')->default('Ramadan Mubarak 1447 AH / 2026');
            $table->text('hero_message')->nullable();
            $table->string('timetable_image')->nullable(); // path e.g. ramadan-timetables/2026.jpg
            $table->string('countdown_target')->nullable(); // ISO date for JS countdown
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ramadan_settings');
    }
};
