<?php

namespace Modules\Certificate\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Union;
use Modules\Certificate\Models\CertificateType;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class CertificateTypeSeeder extends Seeder
{
    public function run(): void
    {
        // ============ Permissions Insert ============
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ['name' => 'certificate_type.view',   'module' => 'certificate', 'group' => 'certificate_type',        'label_bn' => 'ধরন দেখা'],
            ['name' => 'certificate_type.create', 'module' => 'certificate', 'group' => 'certificate_type',        'label_bn' => 'ধরন তৈরি'],
            ['name' => 'certificate_type.edit',   'module' => 'certificate', 'group' => 'certificate_type',        'label_bn' => 'ধরন সম্পাদনা'],
            ['name' => 'certificate_type.delete', 'module' => 'certificate', 'group' => 'certificate_type',        'label_bn' => 'ধরন ডিলিট'],

            ['name' => 'certificate_application.view',    'module' => 'certificate', 'group' => 'certificate_application', 'label_bn' => 'আবেদন দেখা'],
            ['name' => 'certificate_application.create',  'module' => 'certificate', 'group' => 'certificate_application', 'label_bn' => 'আবেদন তৈরি'],
            ['name' => 'certificate_application.edit',    'module' => 'certificate', 'group' => 'certificate_application', 'label_bn' => 'আবেদন সম্পাদনা'],
            ['name' => 'certificate_application.approve', 'module' => 'certificate', 'group' => 'certificate_application', 'label_bn' => 'আবেদন অনুমোদন'],
            ['name' => 'certificate_application.reject',  'module' => 'certificate', 'group' => 'certificate_application', 'label_bn' => 'আবেদন বাতিল'],

            ['name' => 'certificate.issue',   'module' => 'certificate', 'group' => 'certificate', 'label_bn' => 'সার্টিফিকেট ইস্যু'],
            ['name' => 'certificate.reprint', 'module' => 'certificate', 'group' => 'certificate', 'label_bn' => 'পুনঃপ্রিন্ট'],
            ['name' => 'certificate.cancel',  'module' => 'certificate', 'group' => 'certificate', 'label_bn' => 'সার্টিফিকেট বাতিল'],
            ['name' => 'certificate.print',   'module' => 'certificate', 'group' => 'certificate', 'label_bn' => 'সার্টিফিকেট প্রিন্ট'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['name' => $perm['name'], 'guard_name' => 'web'],
                $perm
            );
        }

        // Super Admin-কে সব permission দিন
        $superAdmin = Role::where('name', 'Super Admin')->first();
        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::all());
        }

        // Chairman-কে সব certificate permission দিন
        $chairman = Role::where('name', 'Chairman')->first();
        if ($chairman) {
            $chairmanPerms = Permission::where('module', 'certificate')->get();
            $chairman->syncPermissions($chairmanPerms);
        }

        // Ward Member-কে আবেদন দেখা + approve/reject
        $wardMember = Role::where('name', 'Ward Member')->first();
        if ($wardMember) {
            $wardPerms = Permission::whereIn('name', [
                'certificate_application.view',
                'certificate_application.approve',
                'certificate_application.reject',
            ])->get();
            $wardMember->syncPermissions($wardPerms->merge($wardMember->permissions));
        }

        // ============ Certificate Types ============
        $union = Union::first();
        if (!$union) {
            $this->command->warn('⚠️  কোন ইউনিয়ন নেই। আগে CoreDatabaseSeeder চালান।');
            return;
        }

        $types = [
            ['name_bn' => 'নাগরিকত্ব সনদ', 'name_en' => 'Citizenship Certificate', 'code' => 'CIT', 'fee' => 100, 'validity_days' => 90, 'print_after_days' => 0, 'icon' => 'user-check', 'color' => '#3b82f6'],
            ['name_bn' => 'ওয়ারিশ সনদ',   'name_en' => 'Warish Certificate',       'code' => 'WAR', 'fee' => 200, 'validity_days' => 90, 'print_after_days' => 0, 'icon' => 'users', 'color' => '#8b5cf6', 'is_warish' => true, 'requires_heirs' => true, 'requires_property' => true],
            ['name_bn' => 'চারিত্রিক সনদ', 'name_en' => 'Character Certificate',    'code' => 'CHR', 'fee' => 50,  'validity_days' => 90, 'print_after_days' => 30, 'icon' => 'shield-check', 'color' => '#10b981'],
            ['name_bn' => 'আয় সনদ',       'name_en' => 'Income Certificate',       'code' => 'INC', 'fee' => 50,  'validity_days' => 90, 'print_after_days' => 0, 'icon' => 'dollar-sign', 'color' => '#f59e0b'],
            ['name_bn' => 'বসবাস সনদ',     'name_en' => 'Residence Certificate',    'code' => 'RES', 'fee' => 50,  'validity_days' => 90, 'print_after_days' => 0, 'icon' => 'home', 'color' => '#06b6d4'],
            ['name_bn' => 'অবিবাহিত সনদ', 'name_en' => 'Unmarried Certificate',   'code' => 'UNM', 'fee' => 50,  'validity_days' => 90, 'print_after_days' => 0, 'icon' => 'heart', 'color' => '#ec4899'],
            ['name_bn' => 'প্রত্যয়ন সনদ', 'name_en' => 'Attestation Certificate',  'code' => 'ATT', 'fee' => 50,  'validity_days' => 90, 'print_after_days' => 0, 'icon' => 'file-text', 'color' => '#6366f1'],
            ['name_bn' => 'ভূমিহীন সনদ',  'name_en' => 'Landless Certificate',     'code' => 'LND', 'fee' => 50,  'validity_days' => 90, 'print_after_days' => 0, 'icon' => 'map', 'color' => '#84cc16'],
            ['name_bn' => 'দুস্থ সনদ',     'name_en' => 'Poor Certificate',         'code' => 'POR', 'fee' => 50,  'validity_days' => 90, 'print_after_days' => 0, 'icon' => 'heart-handshake', 'color' => '#ef4444'],
        ];

        foreach ($types as $i => $type) {
            CertificateType::updateOrCreate(
                ['union_id' => $union->id, 'code' => $type['code']],
                array_merge([
                    'serial_prefix' => 'UP/' . $type['code'],
                    'serial_start' => 1,
                    'current_serial' => 0,
                    'serial_padding' => 4,
                    'renewal_fee' => $type['fee'],
                    'duplicate_fee' => $type['fee'] * 2,
                    'needs_ward_verification' => true,
                    'needs_chairman_approval' => true,
                    'sort_order' => $i + 1,
                    'is_active' => true,
                ], $type)
            );
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('✅ Certificate permissions + types created');
    }
}