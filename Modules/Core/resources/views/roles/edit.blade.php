@extends('core::layouts.app')
@section('title', 'রোল সম্পাদনা')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>রোল সম্পাদনা — {{ $role->name }}</h4>
    <a href="{{ route('core.roles.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> ফিরে যান</a>
</div>

<form action="{{ route('core.roles.update', $role) }}" method="POST">
    @csrf @method('PUT')

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <label class="form-label">রোল নাম <span class="text-danger">*</span></label>
            <input type="text" name="name" value="{{ old('name', $role->name) }}" class="form-control" required>
        </div>
    </div>

    @include('core::roles._permissions')

    <div class="mt-3">
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> আপডেট</button>
    </div>
</form>
@endsection