@extends('core::layouts.app')
@section('title', 'ইউজার তালিকা')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>ইউজার তালিকা</h4>
    @can('user.create')
    <a href="{{ route('core.users.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> নতুন ইউজার</a>
    @endcan
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="নাম, ফোন, ইমেইল...">
            </div>
            <div class="col-md-3">
                <select name="user_type" class="form-select">
                    <option value="">সব ধরন</option>
                    @foreach(\Modules\Core\Enums\UserType::cases() as $t)
                        <option value="{{ $t->value }}" {{ request('user_type') == $t->value ? 'selected' : '' }}>{{ $t->labelBn() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary"><i class="bi bi-search"></i> খুঁজুন</button>
                <a href="{{ route('core.users.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>নাম</th>
                    <th>ফোন</th>
                    <th>ধরন</th>
                    <th>রোল</th>
                    <th>স্ট্যাটাস</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ bangla_number($loop->iteration) }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ $user->photo_url }}" width="35" height="35" class="rounded-circle me-2">
                            <div>
                                <strong>{{ $user->display_name }}</strong><br>
                                <small class="text-muted">{{ $user->email ?? $user->phone }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td><span class="badge bg-secondary">{{ $user->user_type }}</span></td>
                    <td>
                        @foreach($user->roles as $r)
                            <span class="badge bg-primary">{{ $r->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('core.users.show', $user) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                        @can('user.edit')
                        <a href="{{ route('core.users.edit', $user) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">কোন ইউজার নেই</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection