<?php

namespace Modules\Report\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ReportPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ['name' => 'report.view',   'module' => 'report', 'group' => 'report', 'label_bn' => 'রিপোর্ট দেখা'],
            ['name' => 'report.export', 'module' => 'report', 'group' => 'report', 'label_bn' => 'রিপোর্ট এক্সপোর্ট'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['name' => $perm['name'], 'guard_name' => 'web'],
                $perm
            );
        }

        foreach (['Super Admin', 'Chairman', 'Secretary', 'Accountant'] as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->syncPermissions(
                    Permission::where('module', 'report')->get()->merge($role->permissions)
                );
            }
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('✅ Report permissions created');
    }
}