<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('certificate_types', 'renewal_fee')) {
            Schema::table('certificate_types', function (Blueprint $table) {
                $table->decimal('renewal_fee', 10, 2)->nullable()->after('duplicate_fee');
            });
        }

        if (!Schema::hasColumn('certificate_types', 'renewal_validity_days')) {
            Schema::table('certificate_types', function (Blueprint $table) {
                $table->integer('renewal_validity_days')->nullable()->after('validity_days');
            });
        }
    }

    public function down(): void
    {
        Schema::table('certificate_types', function (Blueprint $table) {
            $table->dropColumn(['renewal_fee', 'renewal_validity_days']);
        });
    }
};