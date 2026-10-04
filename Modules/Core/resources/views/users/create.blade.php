@extends('core::layouts.app')
@section('title', 'নতুন ইউজার')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>নতুন ইউজার</h4>
    <a href="{{ route('core.users.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> ফিরে যান</a>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>অনুগ্রহ করে নিচের সমস্যাগুলো ঠিক করুন:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('core.users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">নাম <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">নাম (বাংলা)</label>
                    <input type="text" name="name_bn" value="{{ old('name_bn') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">ফোন</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">ইমেইল</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">পাসওয়ার্ড <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">পাসওয়ার্ড নিশ্চিত <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ইউজার ধরন <span class="text-danger">*</span></label>
                    <select name="user_type" class="form-select" required>
                        @foreach(\Modules\Core\Enums\UserType::cases() as $t)
                            <option value="{{ $t->value }}" {{ old('user_type') == $t->value ? 'selected' : '' }}>{{ $t->labelBn() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ইউনিয়ন</label>
                    <select name="union_id" class="form-select">
                        <option value="">--</option>
                        @foreach($unions as $u)
                            <option value="{{ $u->id }}">{{ $u->name_bn }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ওয়ার্ড</label>
                    <select name="ward_id" class="form-select">
                        <option value="">--</option>
                        @foreach($wards as $w)
                            <option value="{{ $w->id }}">{{ $w->name_bn }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ছবি</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                </div>
                <div class="col-md-12">
                    <label class="form-label">রোল</label>
                    <div class="row">
                        @foreach($roles as $role)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="form-check-input" id="role-{{ $role->id }}">
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
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> সংরক্ষণ</button>
    </div>
</form>
@endsection
