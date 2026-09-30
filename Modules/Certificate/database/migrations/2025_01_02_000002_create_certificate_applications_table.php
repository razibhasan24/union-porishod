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
            
            // Certificate type
            $table->foreignId('certificate_type_id')->constrained()->cascadeOnDelete();
            
            // Application data (JSON - flexible)
            $table->json('form_data')->nullable(); 
            // {purpose, address, remarks, ...}
            
            // Applicant snapshot (তার আবেদনের সময়ের তথ্য)
            $table->string('applicant_name_bn');
            $table->string('applicant_name_en')->nullable();
            $table->string('applicant_father_name')->nullable();
            $table->string('applicant_mother_name')->nullable();
            $table->string('applicant_nid')->nullable();
            $table->string('applicant_phone');
            $table->string('applicant_address')->nullable();
            
            // Documents (JSON array of file paths)
            $table->json('documents')->nullable();
            
            // Warish-specific (ওয়ারিশ সনদের জন্য)
            $table->json('deceased_info')->nullable();
            // {name, father, mother, death_date, address, nid, certificate_no}
            $table->json('heirs')->nullable();
            // [{name, relation, age, nid, certificate_no, address}, ...]
            $table->json('property_info')->nullable();
            
            // Payment
            $table->enum('payment_method', ['online', 'cash'])->nullable();
            $table->enum('payment_status', ['unpaid', 'pending', 'paid', 'failed'])
                  ->default('unpaid');
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->string('payment_ref')->nullable(); // bKash trxID / receipt no
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('collected_by')->nullable()
                  ->constrained('users')->nullOnDelete(); // cash হলে কে নিল
            
            // Status workflow
            $table->enum('status', [
                'draft',              // applicant তৈরি করছে
                'submitted',          // submit করেছে, payment বাকি
                'pending_payment',    // payment বাকি
                'paid',               // payment হয়ে গেছে
                'sent_to_ward',       // Ward Member-এ পাঠানো
                'ward_verified',      // Ward Member verify করেছে
                'ward_rejected',      // Ward Member reject করেছে
                'sent_to_chairman',   // Chairman-এ পাঠানো
                'chairman_approved',  // Chairman approve করেছে
                'chairman_rejected',  // Chairman reject করেছে
                'chairman_hold',      // Chairman hold করেছে
                'ready_for_print',    // Print করার জন্য তৈরি
                'printed',            // Print হয়েছে
                'delivered',          // নাগরিক পেয়েছে
                'expired',            // মেয়াদ শেষ
                'cancelled',          // বাতিল
            ])->default('draft');
            
            // Ward Member action
            $table->foreignId('ward_member_id')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->timestamp('ward_action_at')->nullable();
            $table->text('ward_remarks')->nullable();
            
            // Chairman action
            $table->foreignId('chairman_id')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->timestamp('chairman_action_at')->nullable();
            $table->text('chairman_remarks')->nullable();
            
            // Print control
            $table->timestamp('print_available_at')->nullable(); // কখন থেকে print
            $table->boolean('print_allowed')->default(false); // Chairman special permission
            $table->foreignId('print_allowed_by')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->timestamp('print_allowed_at')->nullable();
            
            // Delivery
            $table->timestamp('delivered_at')->nullable();
            $table->string('delivered_to')->nullable();
            $table->string('delivery_signature')->nullable();
            
            // Renewal
            $table->foreignId('parent_application_id')->nullable()
                  ->constrained('certificate_applications')->nullOnDelete();
            $table->integer('renewal_count')->default(0);
            $table->boolean('is_renewal')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['union_id', 'status']);
            $table->index(['applicant_id', 'status']);
            $table->index('tracking_no');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_applications');
    }
};