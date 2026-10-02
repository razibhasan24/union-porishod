@extends('applicant::layouts.app')

@section('title', 'প্রোফাইল')

@section('content')
<h4 class="mb-3"><i class="bi bi-person"></i> আমার প্রোফাইল</h4>

<form action="{{ route('applicant.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <img src="{{ $user->photo_url ?? asset('images/default-avatar.png') }}"
                         class="rounded-circle mb-2" width="120" height="120" style="object-fit: cover;">
                    <input type="file" name="photo" class="form-control form-control-sm" accept="image/*">
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><strong>মূল তথ্য</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">নাম <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">নাম (বাংলা)</label>
                            <input type="text" name="name_bn" value="{{ old('name_bn', $user->name_bn) }}"
                                   class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ফোন <span class="text-danger">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ইমেইল</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NID</label>
                            <input type="text" name="nid" value="{{ old('nid', $user->nid) }}"
                                   class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ঠিকানা</label>
                            <input type="text" name="address" value="{{ old('address') }}"
                                   class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><strong>পাসওয়ার্ড পরিবর্তন (ঐচ্ছিক)</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">বর্তমান পাসওয়ার্ড</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">নতুন পাসওয়ার্ড</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">নিশ্চিত করুন</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> আপডেট করুন
            </button>
        </div>
    </div>
</form>
@endsection