@extends('core::layouts.app')
@section('title', 'পারমিশন তালিকা')
@section('content')
<h4 class="mb-3">সিস্টেমের সব পারমিশন</h4>

@foreach($permissions as $module => $groups)
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white">
        <strong class="text-primary">{{ ucfirst($module ?? 'Other') }} Module</strong>
    </div>
    <div class="card-body">
        @foreach($groups as $groupName => $perms)
        <div class="mb-3">
            <small class="text-muted d-block mb-1"><strong>{{ $groupName }}</strong></small>
            @foreach($perms as $p)
                <span class="badge bg-secondary mb-1">{{ $p->name }}</span>
            @endforeach
        </div>
        @endforeach
    </div>
</div>
@endforeach
@endsection