<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('application_id')
                  ->constrained('certificate_applications')
                  ->cascadeOnDelete();

            $table->foreignId('payer_id')->constrained('users')->cascadeOnDelete();

            // Amount
            $table->decimal('amount', 10, 2);

            // Method
            $table->enum('method', ['online', 'cash'])->default('online');
            $table->string('gateway')->nullable(); // bkash, nagad, rocket, cash

            // Transaction info
            $table->string('transaction_id')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('payer_mobile')->nullable();

            // Status
            $table->enum('status', ['pending', 'success', 'failed', 'cancelled'])->default('pending');

            // Timestamps
            $table->timestamp('initiated_at')->nullable();
            $table->timestamp('paid_at')->nullable();

            // For cash payments - who collected
            $table->foreignId('collected_by')->nullable()->constrained('users')->nullOnDelete();

            // Receipt
            $table->string('receipt_no')->nullable();

            // Gateway response
            $table->json('gateway_response')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['application_id', 'status']);
            $table->index('transaction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};