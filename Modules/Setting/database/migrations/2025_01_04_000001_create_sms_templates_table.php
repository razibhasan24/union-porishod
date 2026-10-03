<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_templates', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();         // e.g., application_submitted
            $table->string('name_bn');               // human readable
            $table->string('name_en')->nullable();
            $table->text('body_bn');                 // message body (bangla)
            $table->text('body_en')->nullable();
            $table->json('variables')->nullable();   // ['{tracking_no}', '{name}', ...]
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_templates');
    }
};