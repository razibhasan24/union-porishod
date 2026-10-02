<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ================== PERMISSIONS ==================
        $permissions = [
            // Union
            ['name' => 'union.view',   'module' => 'core', 'group' => 'union',   'label_bn' => 'ইউনিয়ন দেখা',      'label_en' => 'View Union',     'sort_order' => 1],
            ['name' => 'union.create', 'module' => 'core', 'group' => 'union',   'label_bn' => 'ইউনিয়ন তৈরি',      'label_en' => 'Create Union',   'sort_order' => 2],
            ['name' => 'union.edit',   'module' => 'core', 'group' => 'union',   'label_bn' => 'ইউনিয়ন সম্পাদনা',  'label_en' => 'Edit Union',     'sort_order' => 3],
            ['name' => 'union.delete', 'module' => 'core', 'group' => 'union',   'label_bn' => 'ইউনিয়ন ডিলিট',    'label_en' => 'Delete Union',   'sort_order' => 4],

            // Ward
            ['name' => 'ward.view',    'module' => 'core', 'group' => 'ward',    'label_bn' => 'ওয়ার্ড দেখা',      'label_en' => 'View Ward',      'sort_order' => 5],
            ['name' => 'ward.create',  'module' => 'core', 'group' => 'ward',    'label_bn' => 'ওয়ার্ড তৈরি',      'label_en' => 'Create Ward',    'sort_order' => 6],
            ['name' => 'ward.edit',    'module' => 'core', 'group' => 'ward',    'label_bn' => 'ওয়ার্ড সম্পাদনা',  'label_en' => 'Edit Ward',      'sort_order' => 7],
            ['name' => 'ward.delete',  'module' => 'core', 'group' => 'ward',    'label_bn' => 'ওয়ার্ড ডিলিট',    'label_en' => 'Delete Ward',    'sort_order' => 8],

            // Village
            ['name' => 'village.view',   'module' => 'core', 'group' => 'village', 'label_bn' => 'গ্রাম দেখা',      'label_en' => 'View Village',   'sort_order' => 9],
            ['name' => 'village.create', 'module' => 'core', 'group' => 'village', 'label_bn' => 'গ্রাম তৈরি',      'label_en' => 'Create Village', 'sort_order' => 10],
            ['name' => 'village.edit',   'module' => 'core', 'group' => 'village', 'label_bn' => 'গ্রাম সম্পাদনা',  'label_en' => 'Edit Village',   'sort_order' => 11],
            ['name' => 'village.delete', 'module' => 'core', 'group' => 'village', 'label_bn' => 'গ্রাম ডিলিট',    'label_en' => 'Delete Village', 'sort_order' => 12],

            // User
            ['name' => 'user.view',    'module' => 'core', 'group' => 'user',    'label_bn' => 'ইউজার দেখা',      'label_en' => 'View User',      'sort_order' => 13],
            ['name' => 'user.create',  'module' => 'core', 'group' => 'user',    'label_bn' => 'ইউজার তৈরি',      'label_en' => 'Create User',    'sort_order' => 14],
            ['name' => 'user.edit',    'module' => 'core', 'group' => 'user',    'label_bn' => 'ইউজার সম্পাদনা',  'label_en' => 'Edit User',      'sort_order' => 15],
            ['name' => 'user.delete',  'module' => 'core', 'group' => 'user',    'label_bn' => 'ইউজার ডিলিট',    'label_en' => 'Delete User',    'sort_order' => 16],

            // Role
            ['name' => 'role.view',    'module' => 'core', 'group' => 'role',    'label_bn' => 'রোল দেখা',        'label_en' => 'View Role',      'sort_order' => 17],
            ['name' => 'role.create',  'module' => 'core', 'group' => 'role',    'label_bn' => 'রোল তৈরি',        'label_en' => 'Create Role',    'sort_order' => 18],
            ['name' => 'role.edit',    'module' => 'core', 'group' => 'role',    'label_bn' => 'রোল সম্পাদনা',    'label_en' => 'Edit Role',      'sort_order' => 19],
            ['name' => 'role.delete',  'module' => 'core', 'group' => 'role',    'label_bn' => 'রোল ডিলিট',      'label_en' => 'Delete Role',    'sort_order' => 20],

            // Permission
            ['name' => 'permission.view', 'module' => 'core', 'group' => 'permission', 'label_bn' => 'পারমিশন দেখা', 'label_en' => 'View Permission', 'sort_order' => 21],

            // Setting
            ['name' => 'setting.view', 'module' => 'core', 'group' => 'setting', 'label_bn' => 'সেটিংস দেখা',     'label_en' => 'View Setting', 'sort_order' => 22],
            ['name' => 'setting.edit', 'module' => 'core', 'group' => 'setting', 'label_bn' => 'সেটিংস সম্পাদনা', 'label_en' => 'Edit Setting', 'sort_order' => 23],

            // Report
            ['name' => 'report.view',   'module' => 'core', 'group' => 'report', 'label_bn' => 'রিপোর্ট দেখা',     'label_en' => 'View Report',   'sort_order' => 24],
            ['name' => 'report.export', 'module' => 'core', 'group' => 'report', 'label_bn' => 'রিপোর্ট এক্সপোর্ট', 'label_en' => 'Export Report', 'sort_order' => 25],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['name' => $perm['name'], 'guard_name' => 'web'],
                $perm
            );
        }

        $this->command->info('✅ ' . count($permissions) . ' permissions created');

        // ================== ROLES ==================
        $roles = [
            'Super Admin', 'Chairman', 'Secretary', 'Ward Member',
            'Female Member', 'Accountant', 'Certificate Officer',
            'Office Staff', 'Applicant',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        $this->command->info('✅ ' . count($roles) . ' roles created');

        // ================== ASSIGN ==================
        $superAdmin = Role::where('name', 'Super Admin')->first();
        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::all());
            $this->command->info('✅ Super Admin got all permissions');
        }

        $chairman = Role::where('name', 'Chairman')->first();
        if ($chairman) {
            $chairmanPerms = Permission::whereNotIn('name', [
                'union.delete', 'user.delete', 'role.delete',
            ])->get();
            $chairman->syncPermissions($chairmanPerms);
        }

        $secretary = Role::where('name', 'Secretary')->first();
        if ($secretary) {
            $secretaryPerms = Permission::whereIn('name', [
                'union.view', 'ward.view', 'ward.create', 'ward.edit',
                'village.view', 'village.create', 'village.edit',
                'user.view', 'user.create', 'user.edit',
                'setting.view', 'report.view', 'report.export',
                'permission.view',
            ])->get();
            $secretary->syncPermissions($secretaryPerms);
        }

        $wardMember = Role::where('name', 'Ward Member')->first();
        if ($wardMember) {
            $wardMemberPerms = Permission::whereIn('name', [
                'village.view', 'report.view',
            ])->get();
            $wardMember->syncPermissions($wardMemberPerms);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $this->command->info('✅ All roles and permissions synced');
    }
}