@extends('core::layouts.app')
@section('title', 'রোল তালিকা')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>রোল তালিকা</h4>
    @can('role.create')
    <a href="{{ route('core.roles.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> নতুন রোল</a>
    @endcan
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>রোল নাম</th>
                    <th>পারমিশন</th>
                    <th>ইউজার</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr>
                    <td>{{ bangla_number($loop->iteration) }}</td>
                    <td><strong>{{ $role->name }}</strong></td>
                    <td><span class="badge bg-info">{{ bangla_number($role->permissions_count) }}</span></td>
                    <td><span class="badge bg-primary">{{ bangla_number($role->users_count) }}</span></td>
                    <td>
                        <a href="{{ route('core.roles.show', $role) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                        @can('role.edit')
                        <a href="{{ route('core.roles.edit', $role) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">কোন রোল নেই</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $roles->links() }}
    </div>
</div>
@endsection