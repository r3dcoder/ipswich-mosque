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
        Schema::table('mosque_settings', function (Blueprint $table) {
            $table->string('office_monday_friday')->nullable()->after('address');
            $table->string('office_saturday')->nullable()->after('office_monday_friday');
            $table->string('office_sunday')->nullable()->after('office_saturday');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mosque_settings', function (Blueprint $table) {
            $table->dropColumn(['office_monday_friday', 'office_saturday', 'office_sunday']);
        });
    }
};