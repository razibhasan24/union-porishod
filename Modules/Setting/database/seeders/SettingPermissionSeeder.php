<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SettingPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ['name' => 'sms.view',    'module' => 'setting', 'group' => 'sms', 'label_bn' => 'SMS লগ দেখা'],
            ['name' => 'sms.send',    'module' => 'setting', 'group' => 'sms', 'label_bn' => 'SMS পাঠানো'],
            ['name' => 'sms.template', 'module' => 'setting', 'group' => 'sms', 'label_bn' => 'SMS টেমপ্লেট'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['name' => $perm['name'], 'guard_name' => 'web'],
                $perm
            );
        }

        foreach (['Super Admin', 'Chairman', 'Secretary'] as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->syncPermissions(
                    Permission::where('module', 'setting')->get()->merge($role->permissions)
                );
            }
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('✅ Setting/SMS permissions created');
    }
}