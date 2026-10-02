<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Modules\Core\Models\Union;
use Modules\Core\Models\Ward;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // ১. Union তৈরি
        $union = Union::firstOrCreate(
            ['code' => 'DEMO-UP-001'],
            [
                'name_bn' => 'ডেমো ইউনিয়ন পরিষদ',
                'name_en' => 'Demo Union Parishad',
                'upazila_bn' => 'ডেমো উপজেলা',
                'upazila_en' => 'Demo Upazila',
                'district_bn' => 'ডেমো জেলা',
                'district_en' => 'Demo District',
                'division_bn' => 'ঢাকা',
                'division_en' => 'Dhaka',
                'phone' => '01700000000',
                'email' => 'info@demo-up.gov.bd',
                'total_wards' => 9,
                'is_active' => true,
            ]
        );

        // ২. Wards তৈরি (যদি না থাকে)
        if ($union->wards()->count() === 0) {
            $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
            for ($i = 1; $i <= 9; $i++) {
                Ward::create([
                    'union_id' => $union->id,
                    'ward_no' => $i,
                    'name_bn' => "ওয়ার্ড নং " . $bn[$i],
                    'name_en' => "Ward No {$i}",
                ]);
            }
        }

        // ৩. Super Admin তৈরি
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@demo-up.gov.bd'],
            [
                'name' => 'Super Admin',
                'name_bn' => 'সুপার অ্যাডমিন',
                'phone' => '01700000001',
                'password' => bcrypt('password'),
                'user_type' => 'super_admin',
                'union_id' => $union->id,
                'is_active' => true,
                'phone_verified' => true,
            ]
        );
        $superAdmin->syncRoles(['Super Admin']);

        // ৪. Chairman
        $chairman = User::updateOrCreate(
            ['email' => 'chairman@demo-up.gov.bd'],
            [
                'name' => 'Chairman',
                'name_bn' => 'চেয়ারম্যান',
                'phone' => '01700000002',
                'password' => bcrypt('password'),
                'user_type' => 'chairman',
                'union_id' => $union->id,
                'is_active' => true,
                'phone_verified' => true,
            ]
        );
        $chairman->syncRoles(['Chairman']);

        // ৫. Secretary
        $secretary = User::updateOrCreate(
            ['email' => 'secretary@demo-up.gov.bd'],
            [
                'name' => 'Secretary',
                'name_bn' => 'সেক্রেটারি',
                'phone' => '01700000004',
                'password' => bcrypt('password'),
                'user_type' => 'secretary',
                'union_id' => $union->id,
                'is_active' => true,
                'phone_verified' => true,
            ]
        );
        $secretary->syncRoles(['Secretary']);

        // ৬. Ward Member (ward 1)
        $ward1 = $union->wards()->where('ward_no', 1)->first();
        $wardMember = User::updateOrCreate(
            ['email' => 'ward1@demo-up.gov.bd'],
            [
                'name' => 'Ward Member 1',
                'name_bn' => '১ নং ওয়ার্ড সদস্য',
                'phone' => '01700000003',
                'password' => bcrypt('password'),
                'user_type' => 'ward_member',
                'union_id' => $union->id,
                'ward_id' => $ward1?->id,
                'is_active' => true,
                'phone_verified' => true,
            ]
        );
        $wardMember->syncRoles(['Ward Member']);

        // ৭. Applicant (test user)
        $applicant = User::updateOrCreate(
            ['email' => 'applicant@demo-up.gov.bd'],
            [
                'name' => 'Test Applicant',
                'name_bn' => 'টেস্ট আবেদনকারী',
                'phone' => '01700000005',
                'password' => bcrypt('password'),
                'user_type' => 'applicant',
                'union_id' => $union->id,
                'ward_id' => $ward1?->id,
                'is_active' => true,
                'phone_verified' => true,
            ]
        );
        $applicant->syncRoles(['Applicant']);

        $this->command->info('');
        $this->command->info('====================================');
        $this->command->info('  Default Login Credentials');
        $this->command->info('====================================');
        $this->command->info('Super Admin : superadmin@demo-up.gov.bd / password');
        $this->command->info('Chairman    : chairman@demo-up.gov.bd / password');
        $this->command->info('Secretary   : secretary@demo-up.gov.bd / password');
        $this->command->info('Ward Member : ward1@demo-up.gov.bd / password');
        $this->command->info('Applicant   : applicant@demo-up.gov.bd / password');
        $this->command->info('====================================');
    }
}