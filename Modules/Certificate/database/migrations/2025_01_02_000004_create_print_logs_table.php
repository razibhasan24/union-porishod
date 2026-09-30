<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('print_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_id')->constrained('issued_certificates')
                  ->cascadeOnDelete();
            $table->foreignId('printed_by')->nullable()
                  ->constrained('users')->nullOnDelete();
            
            $table->enum('print_type', ['first', 'reprint', 'duplicate'])->default('first');
            $table->text('reason')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('print_logs');
    }
};