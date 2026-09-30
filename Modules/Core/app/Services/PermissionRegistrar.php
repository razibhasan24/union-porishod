<?php

namespace Modules\Core\Services;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar as SpatieRegistrar;

class PermissionRegistrar
{
    public function register(array $moduleConfig): void
    {
        if (!isset($moduleConfig['permissions'])) {
            return;
        }

        $sort = 0;
        foreach ($moduleConfig['permissions'] as $groupKey => $group) {
            foreach ($group['actions'] as $permission => $labels) {
                Permission::updateOrCreate(
                    ['name' => $permission, 'guard_name' => 'web'],
                    [
                        'module' => $moduleConfig['module'] ?? null,
                        'group' => $groupKey,
                        'label_bn' => is_array($labels) ? ($labels['bn'] ?? $permission) : $labels,
                        'label_en' => is_array($labels) ? ($labels['en'] ?? $permission) : $labels,
                        'sort_order' => $sort++,
                    ]
                );
            }
        }

        app(SpatieRegistrar::class)->forgetCachedPermissions();
    }
}