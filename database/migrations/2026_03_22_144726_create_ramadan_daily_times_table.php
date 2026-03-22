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
        Schema::create('ramadan_daily_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ramadan_year_id')->constrained('ramadan_settings')->onDelete('cascade');
            $table->integer('day');                    // 1–30
            $table->date('date');                      // gregorian date
            $table->string('hijri_date')->nullable();  // e.g. 1 Ramadan 1447
            $table->time('sehr_end')->nullable();
            $table->time('fajr')->nullable();
            $table->time('sunrise')->nullable();
            
            $table->time('dhuhr')->nullable();
            $table->time('asr')->nullable();
            $table->time('maghrib')->nullable();       // iftar
            $table->time('isha')->nullable();
            $table->time('tahajjud')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ramadan_daily_times');
    }
};
