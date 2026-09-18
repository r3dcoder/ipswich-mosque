<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Three migrations were committed for the same `quick_links` table.
     * This one is the authoritative definition: it carries every column the
     * QuickLink model declares. The sibling stubs
     * (2026_05_16_223321 / 2026_05_16_223608) are intentionally inert so a
     * fresh database is not created twice.
     *
     * The hasTable() guard keeps the migration re-runnable: environments that
     * already have `quick_links` (from an older deployment of one of the other
     * two migrations) skip the create instead of failing with
     * "table quick_links already exists".
     */
    public function up(): void
    {
        if (Schema::hasTable('quick_links')) {
            return;
        }

        Schema::create('quick_links', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('url');
            $table->string('icon')->default('book'); // Icon name/class
            $table->string('icon_type')->default('svg'); // svg, image
            $table->string('image_path')->nullable(); // For uploaded images
            $table->string('color')->default('green'); // Color theme (green, blue, amber, etc.)
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quick_links');
    }
};