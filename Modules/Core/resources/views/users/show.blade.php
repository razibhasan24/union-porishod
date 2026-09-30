@extends('core::layouts.app')
@section('title', $user->display_name)
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>ইউজার প্রোফাইল</h4>
    <a href="{{ route('core.users.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> ফিরে যান</a>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body">
                <img src="{{ $user->photo_url }}" class="rounded-circle mb-2" width="100" height="100">
                <h5>{{ $user->display_name }}</h5>
                <p class="text-muted">{{ $user->user_type }}</p>
                @if($user->is_active)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <table class="table table-sm">
                    <tr><th width="30%">ফোন:</th><td>{{ $user->phone ?? '-' }}</td></tr>
                    <tr><th>ইমেইল:</th><td>{{ $user->email ?? '-' }}</td></tr>
                    <tr><th>NID:</th><td>{{ $user->nid ?? '-' }}</td></tr>
                    <tr><th>ইউনিয়ন:</th><td>{{ $user->union->name_bn ?? '-' }}</td></tr>
                    <tr><th>ওয়ার্ড:</th><td>{{ $user->ward->name_bn ?? '-' }}</td></tr>
                    <tr>
                        <th>রোল:</th>
                        <td>
                            @foreach($user->roles as $r)
                                <span class="badge bg-primary">{{ $r->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr><th>যোগদান:</th><td>{{ bangla_date($user->created_at) }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection