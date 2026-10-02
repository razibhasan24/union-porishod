<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:permission.view', only: ['index']),
        ];
    }

    public function index()
    {
        $permissions = Permission::orderBy('module')
            ->orderBy('sort_order')
            ->get()
            ->groupBy(['module', 'group']);

        return view('core::permissions.index', compact('permissions'));
    }
}