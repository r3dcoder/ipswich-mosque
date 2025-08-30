<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prayer_times', function (Blueprint $table) {
            $table->id();
            $table->integer('date'); // Gregorian date
            $table->string('day'); // Day e.g. TUE
            $table->string('fajr_begins')->nullable();
            $table->string('fajr_jamaat')->nullable();
            $table->string('sunrise')->nullable();
            $table->string('zuhr_begins')->nullable();
            $table->string('zuhr_jamaat')->nullable();
            $table->string('asr_begins')->nullable();
            $table->string('asr_jamaat')->nullable();
            $table->string('maghrib_begins')->nullable();
            $table->string('maghrib_jamaat')->nullable();
            $table->string('isha_begins')->nullable();
            $table->string('isha_jamaat')->nullable();
            $table->integer('hijri_date')->nullable();
            $table->string('hijri_month')->nullable();
            $table->integer('hijri_year')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prayer_times');
    }
};
