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
        Schema::create('gift_aid_declarations', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name');
            $table->string('donor_email');
            $table->string('donor_address')->nullable();
            $table->string('donor_postcode')->nullable();
            $table->string('donor_phone')->nullable();
            $table->text('declaration_text');
            $table->enum('status', ['active', 'cancelled', 'expired'])->default('active');
            $table->date('declared_at');
            $table->date('expires_at')->nullable(); // Gift Aid declarations typically last indefinitely, but can be cancelled
            $table->date('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->decimal('total_donated', 10, 2)->default(0);
            $table->decimal('total_gift_aid_claimed', 10, 2)->default(0);
            $table->string('hmrc_reference')->nullable(); // HMRC reference for this declaration
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['donor_email', 'status']);
            $table->index(['status', 'declared_at']);
            $table->index('hmrc_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_aid_declarations');
    }
};