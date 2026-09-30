@extends('core::layouts.app')

@section('title', 'ইউনিয়ন সম্পাদনা')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>ইউনিয়ন সম্পাদনা — {{ $union->name_bn }}</h4>
    <a href="{{ route('core.unions.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>

<form action="{{ route('core.unions.update', $union) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><strong>মূল তথ্য</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">নাম (বাংলা) <span class="text-danger">*</span></label>
                            <input type="text" name="name_bn" value="{{ old('name_bn', $union->name_bn) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">নাম (ইংরেজি) <span class="text-danger">*</span></label>
                            <input type="text" name="name_en" value="{{ old('name_en', $union->name_en) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">কোড <span class="text-danger">*</span></label>
                            <input type="text" name="code" value="{{ old('code', $union->code) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">উপজেলা (বাংলা)</label>
                            <input type="text" name="upazila_bn" value="{{ old('upazila_bn', $union->upazila_bn) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">জেলা (বাংলা)</label>
                            <input type="text" name="district_bn" value="{{ old('district_bn', $union->district_bn) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">বিভাগ (বাংলা)</label>
                            <input type="text" name="division_bn" value="{{ old('division_bn', $union->division_bn) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ফোন</label>
                            <input type="text" name="phone" value="{{ old('phone', $union->phone) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ইমেইল</label>
                            <input type="email" name="email" value="{{ old('email', $union->email) }}" class="form-control">
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
                            <input type="text" name="chairman_name_bn" value="{{ old('chairman_name_bn', $union->chairman_name_bn) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">মোবাইল</label>
                            <input type="text" name="chairman_phone" value="{{ old('chairman_phone', $union->chairman_phone) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">স্বাক্ষর</label>
                            @if($union->chairman_signature)
                                <div class="mb-1">
                                    <img src="{{ asset('storage/' . $union->chairman_signature) }}" height="40">
                                </div>
                            @endif
                            <input type="file" name="chairman_signature" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><strong>লোগো</strong></div>
                <div class="card-body">
                    @if($union->logo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $union->logo) }}" class="img-fluid" style="max-height: 80px;">
                        </div>
                    @endif
                    <input type="file" name="logo" class="form-control" accept="image/*">
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-save"></i> আপডেট করুন
                </button>
            </div>
        </div>
    </div>
</form>
@endsection