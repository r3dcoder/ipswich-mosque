<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ramadan_settings', function (Blueprint $table) {
            $table->string('fitrana')->nullable()->after('countdown_target');
            $table->string('eid_jamat')->nullable()->after('fitrana');
            $table->string('esha_and_taraweeh')->nullable()->after('eid_jamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ramadan_settings', function (Blueprint $table) {
            $table->string('fitrana')->nullable()->after('countdown_target');
            $table->string('eid_jamat')->nullable()->after('fitrana');
            $table->string('esha_and_taraweeh')->nullable()->after('eid_jamat');
        });
    }
};
