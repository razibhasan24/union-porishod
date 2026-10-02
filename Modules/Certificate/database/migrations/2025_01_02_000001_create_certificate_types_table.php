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

            // নাম (সব customizable)
            $table->string('name_bn');
            $table->string('name_en');
            $table->string('code')->nullable();
            $table->text('description_bn')->nullable();
            $table->text('description_en')->nullable();

            // Serial format
            $table->string('serial_prefix')->default('UP/CERT');
            $table->integer('serial_start')->default(1);
            $table->integer('current_serial')->default(0);
            $table->integer('serial_padding')->default(4);

            // Fee
            $table->decimal('fee', 10, 2)->default(0);
            $table->decimal('renewal_fee', 10, 2)->nullable();
            $table->decimal('duplicate_fee', 10, 2)->nullable();

            // Validity
            $table->integer('validity_days')->default(90);
            $table->integer('renewal_validity_days')->nullable();

            // Print control
            $table->integer('print_after_days')->default(0);

            // Special flags
            $table->boolean('is_warish')->default(false);
            $table->boolean('requires_heirs')->default(false);
            $table->boolean('requires_property')->default(false);

            // Verification
            $table->boolean('needs_ward_verification')->default(true);
            $table->boolean('needs_chairman_approval')->default(true);
            $table->boolean('needs_secretary_approval')->default(false);

            // Template
            $table->string('template')->nullable();
            $table->text('template_data')->nullable();

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