<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('module')->nullable()->after('guard_name');
            $table->string('group')->nullable()->after('module');
            $table->string('label_bn')->nullable()->after('group');
            $table->string('label_en')->nullable()->after('label_bn');
            $table->integer('sort_order')->default(0)->after('label_en');
        });
    }

    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['module', 'group', 'label_bn', 'label_en', 'sort_order']);
        });
    }
};