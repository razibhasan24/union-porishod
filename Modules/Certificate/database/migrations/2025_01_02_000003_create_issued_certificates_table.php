<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('issued_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')
                  ->constrained('certificate_applications')
                  ->cascadeOnDelete();

            $table->string('certificate_no')->unique();

            $table->date('issue_date');
            $table->date('expiry_date')->nullable();

            $table->string('pdf_path')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('verification_code')->unique();

            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('issued_by_name')->nullable();
            $table->string('issued_by_designation')->nullable();
            $table->string('issued_by_signature')->nullable();

            $table->integer('print_count')->default(0);
            $table->timestamp('first_printed_at')->nullable();
            $table->timestamp('last_printed_at')->nullable();

            $table->boolean('is_valid')->default(true);
            $table->boolean('is_cancelled')->default(false);
            $table->text('cancelled_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issued_certificates');
    }
};