<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Core\Http\Requests\UserRequest;
use Modules\Core\Models\Union;
use Modules\Core\Models\Village;
use Modules\Core\Models\Ward;
use Modules\Core\Services\UserService;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(
        protected UserService $service
    ) {
        $this->middleware('permission:user.view')->only(['index', 'show']);
        $this->middleware('permission:user.create')->only(['create', 'store']);
        $this->middleware('permission:user.edit')->only(['edit', 'update']);
        $this->middleware('permission:user.delete')->only(['destroy']);
    }

    public function index()
    {
        $users = User::with(['union', 'ward', 'roles'])
            ->when(request('user_type'), fn($q, $type) => $q->where('user_type', $type))
            ->when(request('union_id'), fn($q, $id) => $q->where('union_id', $id))
            ->when(request('search'), function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('name_bn', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20);

        $unions = Union::orderBy('name_bn')->get();

        return view('core::users.index', compact('users', 'unions'));
    }

    public function create()
    {
        $unions = Union::orderBy('name_bn')->get();
        $wards = Ward::orderBy('ward_no')->get();
        $villages = Village::orderBy('name_bn')->get();
        $roles = Role::orderBy('name')->get();

        return view('core::users.create', compact('unions', 'wards', 'villages', 'roles'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        $user = $this->service->create($data);

        return redirect()
            ->route('core.users.show', $user)
            ->with('success', 'ইউজার সফলভাবে তৈরি হয়েছে।');
    }

    public function show(User $user)
    {
        $user->load(['union', 'ward', 'village', 'roles', 'permissions']);
        return view('core::users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $unions = Union::orderBy('name_bn')->get();
        $wards = Ward::orderBy('ward_no')->get();
        $villages = Village::orderBy('name_bn')->get();
        $roles = Role::orderBy('name')->get();

        return view('core::users.edit', compact('user', 'unions', 'wards', 'villages', 'roles'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($user->photo) Storage::disk('public')->delete($user->photo);
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        $this->service->update($user, $data);

        return redirect()
            ->route('core.users.show', $user)
            ->with('success', 'ইউজার আপডেট হয়েছে।');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'নিজেকে ডিলিট করা যাবে না।');
        }

        $user->delete();

        return redirect()
            ->route('core.users.index')
            ->with('success', 'ইউজার ডিলিট হয়েছে।');
    }

    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        return back()->with('success', 'স্ট্যাটাস পরিবর্তন হয়েছে।');
    }
}