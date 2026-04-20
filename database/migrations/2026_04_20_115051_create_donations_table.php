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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name')->nullable();
            $table->string('donor_email')->nullable();
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['one-off', 'regular']);
            $table->enum('frequency', ['monthly', 'quarterly', 'annually'])->nullable();
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->boolean('gift_aid')->default(false);
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('stripe_price_id')->nullable();
            $table->timestamp('next_payment_date')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['type', 'status']);
            $table->index('stripe_customer_id');
            $table->index('stripe_subscription_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};