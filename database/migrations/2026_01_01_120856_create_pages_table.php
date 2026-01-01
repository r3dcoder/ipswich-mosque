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
        Schema::create('pages', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED NOT NULL AUTO_INCREMENT
            $table->string('title');
            $table->string('slug')->unique(); // UNIQUE KEY `pages_slug_unique`
            $table->text('excerpt')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_published')->default(false); // TINYINT(1)
            $table->dateTime('published_at')->nullable();
            
            // Timestamps handles both created_at and updated_at with DEFAULT/ON UPDATE
            $table->timestamps(); 

            // Composite Index
            $table->index(['is_published', 'published_at'], 'idx_pages_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
