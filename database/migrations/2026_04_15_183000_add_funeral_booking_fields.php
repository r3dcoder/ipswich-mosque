<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('funeral_bookings', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('message');
            $table->boolean('read')->default(false)->after('status');
            $table->timestamp('read_at')->nullable()->after('read');
            $table->text('admin_notes')->nullable()->after('read_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('funeral_bookings', function (Blueprint $table) {
            $table->dropColumn(['status', 'read', 'read_at', 'admin_notes']);
        });
    }
};