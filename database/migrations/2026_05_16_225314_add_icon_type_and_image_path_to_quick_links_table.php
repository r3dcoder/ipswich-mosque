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
        Schema::table('quick_links', function (Blueprint $table) {
            $table->string('icon_type')->default('svg')->after('icon');
            $table->string('image_path')->nullable()->after('icon_type');
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