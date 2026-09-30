<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('union_id')->constrained()->cascadeOnDelete();
            
            // নাম (dynamic, সব customizable)
            $table->string('name_bn');
            $table->string('name_en');
            $table->string('code')->nullable();
            $table->text('description_bn')->nullable();
            $table->text('description_en')->nullable();
            
            // Serial format: UP/CERT/2025/0001
            $table->string('serial_prefix')->default('UP/CERT');
            $table->integer('serial_start')->default(1);
            $table->integer('current_serial')->default(0);
            $table->integer('serial_padding')->default(4); // 0001
            
            // Fee (customizable)
            $table->decimal('fee', 10, 2)->default(0);
            $table->decimal('renewal_fee', 10, 2)->nullable();
            $table->decimal('duplicate_fee', 10, 2)->nullable();
            
            // Validity (3 মাস default, কিন্তু customizable)
            $table->integer('validity_days')->default(90); // 3 মাস = 90 দিন
            $table->integer('renewal_validity_days')->nullable();
            
            // Print control (dynamic)
            $table->integer('print_after_days')->default(0); 
            // 0 = সাথে সাথে, 30 = ৩০ দিন পর, 90 = ৩ মাস পর
            
            // Special type flag
            $table->boolean('is_warish')->default(false); // ওয়ারিশ সনদ
            $table->boolean('requires_heirs')->default(false); // উত্তরাধিকারী লাগবে
            $table->boolean('requires_property')->default(false);
            
            // Verification level
            $table->boolean('needs_ward_verification')->default(true);
            $table->boolean('needs_chairman_approval')->default(true);
            $table->boolean('needs_secretary_approval')->default(false);
            
            // Template
            $table->string('template')->nullable(); // blade template name
            $table->text('template_data')->nullable(); // JSON
            
            // UI
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->integer('sort_order')->default(0);
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_types');
    }
};