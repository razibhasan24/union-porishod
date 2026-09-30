<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Services\PermissionRegistrar;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Register core permissions
        $permissionsConfig = require module_path('Core', 'config/permissions.php');
        app(PermissionRegistrar::class)->register($permissionsConfig);

        // Create roles
        $roles = [
            'Super Admin',
            'Chairman',
            'Secretary',
            'Ward Member',
            'Female Member',
            'Accountant',
            'Certificate Officer',
            'Office Staff',
            'Applicant',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Super Admin gets all permissions
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $superAdmin->syncPermissions(\Spatie\Permission\Models\Permission::all());

        $this->command->info('✅ Roles and permissions created');
    }
}