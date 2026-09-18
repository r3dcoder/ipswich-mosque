<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This is one of three migrations that were committed for the same
     * `quick_links` table. Only the full definition in
     * 2026_05_16_223324_create_quick_links_table.php is authoritative;
     * this stub exists purely so already-migrated environments keep a
     * consistent migration history. Creating the table here would either
     * fail on a fresh database ("table already exists") or produce a table
     * missing every column the QuickLink model needs, so it does nothing.
     */
    public function up(): void
    {
        // Intentionally left blank. See class docblock.
    }

    /**
     * Reverse the migrations.
     *
     * Dropping the table here would be destructive: this migration never
     * created it. The authoritative migration owns the rollback.
     */
    public function down(): void
    {
        // Intentionally left blank. See class docblock.
    }
};
