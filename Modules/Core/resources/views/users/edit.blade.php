@extends('core::layouts.app')
@section('title', 'ইউজার সম্পাদনা')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>ইউজার সম্পাদনা — {{ $user->display_name }}</h4>
    <a href="{{ route('core.users.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> ফিরে যান</a>
</div>

<form action="{{ route('core.users.update', $user) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">নাম <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">নাম (বাংলা)</label>
                    <input type="text" name="name_bn" value="{{ old('name_bn', $user->name_bn) }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">ফোন</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">ইমেইল</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">নতুন পাসওয়ার্ড (খালি রাখলে পরিবর্তন হবে না)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">নিশ্চিত করুন</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">ইউজার ধরন</label>
                    <select name="user_type" class="form-select">
                        @foreach(\Modules\Core\Enums\UserType::cases() as $t)
                            <option value="{{ $t->value }}" {{ $user->user_type == $t->value ? 'selected' : '' }}>{{ $t->labelBn() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ছবি</label>
                    @if($user->photo)
                        <div class="mb-1"><img src="{{ asset('storage/' . $user->photo) }}" width="50" class="rounded"></div>
                    @endif
                    <input type="file" name="photo" class="form-control" accept="image/*">
                </div>
                <div class="col-md-12">
                    <label class="form-label">রোল</label>
                    <div class="row">
                        @foreach($roles as $role)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="form-check-input" id="role-{{ $role->id }}"
                                    {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                <label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> আপডেট</button>
    </div>
</form>
@endsection