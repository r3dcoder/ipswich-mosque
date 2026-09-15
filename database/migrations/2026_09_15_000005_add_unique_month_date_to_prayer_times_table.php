<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Clean existing duplicates first: keep the lowest id per (month, date)
        $duplicates = DB::table('prayer_times')
            ->select('month', 'date', DB::raw('MIN(id) as keep_id'))
            ->groupBy('month', 'date')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $dup) {
            DB::table('prayer_times')
                ->where('month', $dup->month)
                ->where('date', $dup->date)
                ->where('id', '!=', $dup->keep_id)
                ->delete();
        }

        // Now safe to add unique index
        Schema::table('prayer_times', function (Blueprint $table) {
            $table->unique(['month', 'date'], 'prayer_times_month_date_unique');
        });
    }

    public function down(): void
    {
        Schema::table('prayer_times', function (Blueprint $table) {
            $table->dropUnique('prayer_times_month_date_unique');
        });
    }
};
