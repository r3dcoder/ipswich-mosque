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
        Schema::create('page_blocks', function (Blueprint $table) {
            $table->id();
            // Foreign Key to the 'pages' table
            $table->foreignId('page_id')
                  ->constrained('pages')
                  ->onDelete('cascade');

            $table->string('type', 50);
            $table->unsignedInteger('sort_order')->default(1);
            $table->json('data'); // MySQL JSON type
            
            $table->timestamps();

            // Composite Index for efficient sorting within a page
            $table->index(['page_id', 'sort_order'], 'idx_blocks_page_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_blocks');
    }
};
