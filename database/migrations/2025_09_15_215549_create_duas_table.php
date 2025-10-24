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
        if (!Schema::hasTable('duas')) {
            Schema::create('duas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('dua_category_id')->constrained()->onDelete('cascade');
                $table->string('title');
                $table->text('arabic');
                $table->text('pronunciation')->nullable();
                $table->text('translation');
                $table->string('keywords')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duas');
    }
};
