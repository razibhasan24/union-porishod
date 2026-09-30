@extends('core::layouts.app')

@section('title', 'নতুন ইউনিয়ন')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>নতুন ইউনিয়ন তৈরি</h4>
    <a href="{{ route('core.unions.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>

<form action="{{ route('core.unions.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><strong>মূল তথ্য</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">নাম (বাংলা) <span class="text-danger">*</span></label>
                            <input type="text" name="name_bn" value="{{ old('name_bn') }}" class="form-control" required>
                            @error('name_bn') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">নাম (ইংরেজি) <span class="text-danger">*</span></label>
                            <input type="text" name="name_en" value="{{ old('name_en') }}" class="form-control" required>
                            @error('name_en') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">কোড <span class="text-danger">*</span></label>
                            <input type="text" name="code" value="{{ old('code') }}" class="form-control" required>
                            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">উপজেলা (বাংলা)</label>
                            <input type="text" name="upazila_bn" value="{{ old('upazila_bn') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">জেলা (বাংলা)</label>
                            <input type="text" name="district_bn" value="{{ old('district_bn') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">বিভাগ (বাংলা)</label>
                            <input type="text" name="division_bn" value="{{ old('division_bn') }}" class="form-control">
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
                            <label class="form-label">মোট ওয়ার্ড</label>
                            <input type="number" name="total_wards" value="{{ old('total_wards', 9) }}" class="form-control">
                            <small class="text-muted">ডিফল্ট ওয়ার্ড এই সংখ্যা অনুযায়ী তৈরি হবে</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">প্রতিষ্ঠার তারিখ</label>
                            <input type="date" name="established_date" value="{{ old('established_date') }}" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header bg-white"><strong>চেয়ারম্যান তথ্য</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">চেয়ারম্যানের নাম (বাংলা)</label>
                            <input type="text" name="chairman_name_bn" value="{{ old('chairman_name_bn') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">মোবাইল</label>
                            <input type="text" name="chairman_phone" value="{{ old('chairman_phone') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">স্বাক্ষর (Image)</label>
                            <input type="file" name="chairman_signature" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ছবি</label>
                            <input type="file" name="chairman_photo" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><strong>লোগো ও ব্র্যান্ডিং</strong></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">লোগো</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Favicon</label>
                        <input type="file" name="favicon" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ব্যানার</label>
                        <input type="file" name="banner" class="form-control" accept="image/*">
                    </div>
                    <div class="form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" checked>
                        <label class="form-check-label">সক্রিয়</label>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-save"></i> সংরক্ষণ করুন
                </button>
            </div>
        </div>
    </div>
</form>
@endsection