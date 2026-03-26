<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_url')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('role');
            $table->timestamps();

            $table->index(['role']);
            $table->index(['name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};