<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ramadan_settings', function (Blueprint $table) {
            $table->boolean('iftar_enabled')->default(true)->after('esha_and_taraweeh');
            $table->string('iftar_title')->nullable()->after('iftar_enabled');
            $table->text('iftar_intro')->nullable()->after('iftar_title');
            $table->text('iftar_sponsor_text')->nullable()->after('iftar_intro');
            $table->string('iftar_cost')->nullable()->after('iftar_sponsor_text');
            $table->text('iftar_items')->nullable()->after('iftar_cost');
            $table->string('iftar_contact')->nullable()->after('iftar_items');
        });
    }

    public function down(): void
    {
        Schema::table('ramadan_settings', function (Blueprint $table) {
            $table->dropColumn([
                'iftar_enabled',
                'iftar_title',
                'iftar_intro',
                'iftar_sponsor_text',
                'iftar_cost',
                'iftar_items',
                'iftar_contact',
            ]);
        });
    }
};
