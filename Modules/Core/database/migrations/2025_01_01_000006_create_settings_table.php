<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('union_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('group')->default('general');
            $table->string('key');
            $table->text('value')->nullable();
            $table->string('type')->default('string');
            $table->string('label_bn')->nullable();
            $table->string('label_en')->nullable();
            $table->text('options')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['union_id', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};