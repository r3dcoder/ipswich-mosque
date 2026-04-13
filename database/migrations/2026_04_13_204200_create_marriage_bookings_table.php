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
        Schema::create('marriage_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('proposed_date')->nullable();
            $table->string('proposed_time')->nullable();
            $table->integer('expected_guests')->nullable();
            $table->string('service_type')->nullable(); // nikah, reception, both
            $table->text('message')->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('status')->default('pending'); // pending, confirmed, cancelled, completed
            $table->boolean('read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marriage_bookings');
    }
};