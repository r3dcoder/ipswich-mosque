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
        Schema::create('courses', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AI

            $table->foreignId('course_section_id')
                ->constrained('course_sections')
                ->cascadeOnDelete();

            $table->string('title', 255);
            $table->string('image_path', 255)->nullable();
            $table->unsignedInteger('sort_order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(
                ['course_section_id', 'is_active', 'sort_order'],
                'idx_courses_section_active_order'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
