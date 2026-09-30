@extends('core::layouts.app')
@section('title', 'ওয়ার্ড সম্পাদনা')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>ওয়ার্ড সম্পাদনা — {{ $ward->name_bn }}</h4>
    <a href="{{ route('core.wards.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> ফিরে যান</a>
</div>

<form action="{{ route('core.wards.update', $ward) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">ইউনিয়ন <span class="text-danger">*</span></label>
                    <select name="union_id" class="form-select" required>
                        @foreach($unions as $u)
                            <option value="{{ $u->id }}" {{ old('union_id', $ward->union_id) == $u->id ? 'selected' : '' }}>{{ $u->name_bn }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ওয়ার্ড নম্বর <span class="text-danger">*</span></label>
                    <input type="number" name="ward_no" value="{{ old('ward_no', $ward->ward_no) }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">নাম (বাংলা)</label>
                    <input type="text" name="name_bn" value="{{ old('name_bn', $ward->name_bn) }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">সদস্যের নাম</label>
                    <input type="text" name="member_name_bn" value="{{ old('member_name_bn', $ward->member_name_bn) }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">সদস্যের মোবাইল</label>
                    <input type="text" name="member_phone" value="{{ old('member_phone', $ward->member_phone) }}" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> আপডেট</button>
    </div>
</form>
@endsection