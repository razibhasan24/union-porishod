<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PaymentPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ['name' => 'payment.view',   'module' => 'payment', 'group' => 'payment', 'label_bn' => 'পেমেন্ট দেখা'],
            ['name' => 'payment.create', 'module' => 'payment', 'group' => 'payment', 'label_bn' => 'পেমেন্ট তৈরি'],
            ['name' => 'payment.cash',   'module' => 'payment', 'group' => 'payment', 'label_bn' => 'নগদ পেমেন্ট গ্রহণ'],
            ['name' => 'payment.receipt', 'module' => 'payment', 'group' => 'payment', 'label_bn' => 'রিসিট প্রিন্ট'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['name' => $perm['name'], 'guard_name' => 'web'],
                $perm
            );
        }

        // Super Admin + Chairman সব পাবে
        foreach (['Super Admin', 'Chairman'] as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->syncPermissions(
                    Permission::where('module', 'payment')->get()->merge($role->permissions)
                );
            }
        }

        // Accountant
        $accountant = Role::where('name', 'Accountant')->first();
        if ($accountant) {
            $accountant->syncPermissions(Permission::where('module', 'payment')->get());
        }

        // Certificate Officer
        $officer = Role::where('name', 'Certificate Officer')->first();
        if ($officer) {
            $officer->syncPermissions(
                Permission::whereIn('name', ['payment.view', 'payment.cash', 'payment.receipt'])->get()
            );
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('✅ Payment permissions created');
    }
}