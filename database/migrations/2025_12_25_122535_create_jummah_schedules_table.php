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
        Schema::create('jummah_schedules', function (Blueprint $table) {
            $table->id();
        
            $table->date('effective_from');
            $table->date('effective_till')->nullable();
        
            $table->time('khutbah_time')->nullable();
            $table->time('salah_time')->nullable();
        
            $table->string('note')->nullable();
            $table->boolean('is_active')->default(true);
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jummah_schedules');
    }
};
