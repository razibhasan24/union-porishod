<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_applications', function (Blueprint $table) {
            $table->id();

            // Tracking
            $table->string('tracking_no')->unique();
            $table->foreignId('union_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ward_id')->constrained()->cascadeOnDelete();
            $table->foreignId('village_id')->nullable()->constrained()->nullOnDelete();

            // Applicant
            $table->foreignId('applicant_id')->constrained('users')->cascadeOnDelete();

            // Certificate Type
            $table->foreignId('certificate_type_id')->constrained()->cascadeOnDelete();

            // Form data (JSON)
            $table->json('form_data')->nullable();

            // Applicant snapshot
            $table->string('applicant_name_bn');
            $table->string('applicant_name_en')->nullable();
            $table->string('applicant_father_name')->nullable();
            $table->string('applicant_mother_name')->nullable();
            $table->string('applicant_nid')->nullable();
            $table->string('applicant_phone');
            $table->string('applicant_address')->nullable();

            // Documents
            $table->json('documents')->nullable();

            // Warish-specific
            $table->json('deceased_info')->nullable();
            $table->json('heirs')->nullable();
            $table->json('property_info')->nullable();

            // Payment
            $table->enum('payment_method', ['online', 'cash'])->nullable();
            $table->enum('payment_status', ['unpaid', 'pending', 'paid', 'failed'])->default('unpaid');
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->string('payment_ref')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('collected_by')->nullable()->constrained('users')->nullOnDelete();

            // Status
            $table->enum('status', [
                'draft',
                'submitted',
                'pending_payment',
                'paid',
                'sent_to_ward',
                'ward_verified',
                'ward_rejected',
                'sent_to_chairman',
                'chairman_approved',
                'chairman_rejected',
                'chairman_hold',
                'ready_for_print',
                'printed',
                'delivered',
                'expired',
                'cancelled',
            ])->default('draft');

            // Ward action
            $table->foreignId('ward_member_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('ward_action_at')->nullable();
            $table->text('ward_remarks')->nullable();

            // Chairman action
            $table->foreignId('chairman_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('chairman_action_at')->nullable();
            $table->text('chairman_remarks')->nullable();

            // Print control
            $table->timestamp('print_available_at')->nullable();
            $table->boolean('print_allowed')->default(false);
            $table->foreignId('print_allowed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('print_allowed_at')->nullable();

            // Delivery
            $table->timestamp('delivered_at')->nullable();
            $table->string('delivered_to')->nullable();
            $table->string('delivery_signature')->nullable();

            // Renewal
            $table->foreignId('parent_application_id')->nullable()
                  ->references('id')->on('certificate_applications')->nullOnDelete();
            $table->integer('renewal_count')->default(0);
            $table->boolean('is_renewal')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['union_id', 'status']);
            $table->index(['applicant_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_applications');
    }
};