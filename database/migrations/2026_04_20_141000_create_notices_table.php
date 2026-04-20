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
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->text('summary')->nullable();
            $table->string('category')->default('general'); // general, prayer, event, announcement, urgent
            $table->boolean('is_active')->default(true);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('send_email_notification')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('image_path')->nullable();
            $table->integer('view_count')->default(0);
            $table->timestamps();
            
            $table->index(['is_active', 'published_at']);
            $table->index(['category', 'is_pinned']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};