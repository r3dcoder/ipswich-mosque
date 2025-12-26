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
        Schema::create('course_sections', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AI
            $table->string('page', 50)->default('home');
            $table->string('title', 255);
            $table->string('subtitle', 255)->nullable();
            $table->string('slug', 80)->default('courses');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(1);
            $table->timestamps();

            $table->unique(['page', 'slug'], 'uniq_course_sections_page_slug');
            $table->index(['page', 'is_active', 'sort_order'], 'idx_course_sections_page_active_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_sections');
    }
};
