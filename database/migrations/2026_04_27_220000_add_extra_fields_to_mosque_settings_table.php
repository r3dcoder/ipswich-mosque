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
            // Add Registered Charity No and Company No
            $table->string('charity_number')->nullable()->after('email');
            $table->string('company_number')->nullable()->after('charity_number');
            
            // Add logo and favicon paths
            $table->string('logo_path')->nullable()->after('company_number');
            $table->string('favicon_path')->nullable()->after('logo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mosque_settings', function (Blueprint $table) {
            $table->dropColumn(['charity_number', 'company_number', 'logo_path', 'favicon_path']);
        });
    }
};