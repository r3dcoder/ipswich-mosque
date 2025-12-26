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
        Schema::create('course_features', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AI

            $table->foreignId('course_id')
                ->constrained('courses')
                ->cascadeOnDelete();

            $table->string('text', 255);
            $table->unsignedInteger('sort_order')->default(1);

            $table->index(['course_id', 'sort_order'], 'idx_course_features_course_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_features');
    }
};
