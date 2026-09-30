<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('union_id')->constrained()->cascadeOnDelete();
            $table->integer('ward_no');
            $table->string('name_bn')->nullable();
            $table->string('name_en')->nullable();
            $table->string('member_name_bn')->nullable();
            $table->string('member_name_en')->nullable();
            $table->string('member_phone')->nullable();
            $table->string('member_photo')->nullable();
            $table->string('member_signature')->nullable();
            $table->string('female_member_name_bn')->nullable();
            $table->string('female_member_phone')->nullable();
            $table->integer('total_villages')->default(0);
            $table->integer('total_population')->default(0);
            $table->integer('total_voters')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['union_id', 'ward_no']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wards');
    }
};