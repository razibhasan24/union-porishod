<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('union_id')->nullable()->after('id')
                  ->constrained()->nullOnDelete();
            $table->string('user_type')->default('applicant')->after('union_id');
            $table->string('name_bn')->nullable()->after('name');
            $table->string('phone')->nullable()->unique()->after('email');
            $table->string('nid')->nullable()->after('phone');
            $table->string('photo')->nullable()->after('nid');
            $table->foreignId('ward_id')->nullable()->after('photo')
                  ->constrained()->nullOnDelete();
            $table->foreignId('village_id')->nullable()
                  ->constrained()->nullOnDelete();
            $table->boolean('phone_verified')->default(false);
            $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->string('locale')->default('bn');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['union_id']);
            $table->dropForeign(['ward_id']);
            $table->dropForeign(['village_id']);
            $table->dropColumn([
                'union_id', 'user_type', 'name_bn', 'phone', 'nid',
                'photo', 'ward_id', 'village_id', 'phone_verified',
                'otp', 'otp_expires_at', 'is_active', 'last_login_at',
                'last_login_ip', 'locale', 'deleted_at'
            ]);
        });
    }
};