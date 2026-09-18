<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * These columns are already part of the authoritative `quick_links`
     * definition in 2026_05_16_223324_create_quick_links_table.php, which runs
     * earlier. On a fresh database they therefore already exist and adding them
     * again would fail with a duplicate column error, so only environments that
     * predate those columns get the change.
     */
    public function up(): void
    {
        Schema::table('quick_links', function (Blueprint $table) {
            if (! Schema::hasColumn('quick_links', 'icon_type')) {
                $table->string('icon_type')->default('svg')->after('icon');
            }

            if (! Schema::hasColumn('quick_links', 'image_path')) {
                $table->string('image_path')->nullable()->after('icon_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quick_links', function (Blueprint $table) {
            $table->dropColumn(['icon_type', 'image_path']);
        });
    }
};