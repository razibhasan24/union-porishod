<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:permission.view')->only(['index']);
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