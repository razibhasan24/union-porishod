<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unions', function (Blueprint $table) {
            $table->id();
            $table->string('name_bn');
            $table->string('name_en');
            $table->string('code')->unique();
            $table->string('upazila_bn')->nullable();
            $table->string('upazila_en')->nullable();
            $table->string('district_bn')->nullable();
            $table->string('district_en')->nullable();
            $table->string('division_bn')->nullable();
            $table->string('division_en')->nullable();
            $table->string('post_office')->nullable();
            $table->string('post_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('banner')->nullable();
            $table->string('letterhead')->nullable();
            $table->string('chairman_name_bn')->nullable();
            $table->string('chairman_name_en')->nullable();
            $table->string('chairman_phone')->nullable();
            $table->string('chairman_email')->nullable();
            $table->string('chairman_photo')->nullable();
            $table->string('chairman_signature')->nullable();
            $table->date('chairman_from_date')->nullable();
            $table->date('chairman_to_date')->nullable();
            $table->string('secretary_name_bn')->nullable();
            $table->string('secretary_name_en')->nullable();
            $table->string('secretary_phone')->nullable();
            $table->string('secretary_photo')->nullable();
            $table->integer('total_wards')->default(9);
            $table->integer('total_villages')->default(0);
            $table->integer('total_population')->default(0);
            $table->integer('total_voters')->default(0);
            $table->decimal('total_area', 10, 2)->nullable();
            $table->date('established_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unions');
    }
};