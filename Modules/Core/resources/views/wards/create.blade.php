@extends('core::layouts.app')
@section('title', 'নতুন ওয়ার্ড')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>নতুন ওয়ার্ড</h4>
    <a href="{{ route('core.wards.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> ফিরে যান</a>
</div>

<form action="{{ route('core.wards.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">ইউনিয়ন <span class="text-danger">*</span></label>
                    <select name="union_id" class="form-select" required>
                        <option value="">-- নির্বাচন --</option>
                        @foreach($unions as $u)
                            <option value="{{ $u->id }}" {{ old('union_id', request('union_id')) == $u->id ? 'selected' : '' }}>{{ $u->name_bn }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ওয়ার্ড নম্বর <span class="text-danger">*</span></label>
                    <input type="number" name="ward_no" value="{{ old('ward_no') }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">নাম (বাংলা)</label>
                    <input type="text" name="name_bn" value="{{ old('name_bn') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">নাম (ইংরেজি)</label>
                    <input type="text" name="name_en" value="{{ old('name_en') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">সদস্যের নাম (বাংলা)</label>
                    <input type="text" name="member_name_bn" value="{{ old('member_name_bn') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">সদস্যের মোবাইল</label>
                    <input type="text" name="member_phone" value="{{ old('member_phone') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">সদস্যের ছবি</label>
                    <input type="file" name="member_photo" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6">
                    <label class="form-label">সদস্যের স্বাক্ষর</label>
                    <input type="file" name="member_signature" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6">
                    <label class="form-label">সংরক্ষিত মহিলা সদস্য</label>
                    <input type="text" name="female_member_name_bn" value="{{ old('female_member_name_bn') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">মহিলা সদস্যের মোবাইল</label>
                    <input type="text" name="female_member_phone" value="{{ old('female_member_phone') }}" class="form-control">
                </div>
                <div class="col-md-12">
                    <div class="form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" checked>
                        <label class="form-check-label">সক্রিয়</label>
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