<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->string('mobile', 20);
            $table->text('message');
            $table->string('template_key')->nullable();
            $table->string('gateway')->nullable();          // mock, bulksmsbd, twilio
            $table->string('status')->default('pending');   // pending, sent, failed
            $table->string('reference_id')->nullable();     // gateway response id
            $table->text('response')->nullable();           // raw response
            $table->string('error_message')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('related_type')->nullable();     // morph - CertificateApplication
            $table->unsignedBigInteger('related_id')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['mobile', 'status']);
            $table->index(['related_type', 'related_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};