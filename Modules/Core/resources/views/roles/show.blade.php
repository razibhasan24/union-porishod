@extends('core::layouts.app')
@section('title', $role->name)
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>রোল — {{ $role->name }}</h4>
    <a href="{{ route('core.roles.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> ফিরে যান</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><strong>পারমিশন তালিকা</strong></div>
    <div class="card-body">
        @forelse($role->permissions->groupBy('module') as $module => $perms)
        <div class="mb-3">
            <h6 class="text-primary">{{ $module ?? 'Other' }}</h6>
            @foreach($perms as $p)
                <span class="badge bg-success mb-1">{{ $p->label_bn ?? $p->name }}</span>
            @endforeach
        </div>
        @empty
        <p class="text-muted">কোন পারমিশন নেই</p>
        @endforelse
    </div>
</div>
@endsection