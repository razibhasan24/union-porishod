<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Core\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role.view')->only(['index', 'show']);
        $this->middleware('permission:role.create')->only(['create', 'store']);
        $this->middleware('permission:role.edit')->only(['edit', 'update']);
        $this->middleware('permission:role.delete')->only(['destroy']);
    }

    public function index()
    {
        $roles = Role::withCount(['users', 'permissions'])
            ->when(request('search'), fn($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->orderBy('name')
            ->paginate(20);

        return view('core::roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('module')
            ->orderBy('sort_order')
            ->get()
            ->groupBy(['module', 'group']);

        return view('core::roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()
            ->route('core.roles.index')
            ->with('success', 'রোল সফলভাবে তৈরি হয়েছে।');
    }

    public function show(Role $role)
    {
        $role->load('permissions');

        $permissions = Permission::orderBy('module')
            ->orderBy('sort_order')
            ->get()
            ->groupBy(['module', 'group']);

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('core::roles.show', compact('role', 'permissions', 'rolePermissions'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('module')
            ->orderBy('sort_order')
            ->get()
            ->groupBy(['module', 'group']);

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('core::roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()
            ->route('core.roles.index')
            ->with('success', 'রোল আপডেট হয়েছে।');
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, ['Super Admin', 'Chairman'])) {
            return back()->with('error', 'এই রোল ডিলিট করা যাবে না।');
        }

        $role->delete();

        return redirect()
            ->route('core.roles.index')
            ->with('success', 'রোল ডিলিট হয়েছে।');
    }
}