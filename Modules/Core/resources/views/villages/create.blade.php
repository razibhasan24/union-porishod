@extends('core::layouts.app')
@section('title', 'নতুন গ্রাম')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>নতুন গ্রাম</h4>
    <a href="{{ route('core.villages.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> ফিরে যান</a>
</div>

<form action="{{ route('core.villages.store') }}" method="POST">
    @csrf
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">ইউনিয়ন <span class="text-danger">*</span></label>
                    <select name="union_id" class="form-select" required>
                        <option value="">-- নির্বাচন --</option>
                        @foreach($unions as $u)
                            <option value="{{ $u->id }}">{{ $u->name_bn }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ওয়ার্ড <span class="text-danger">*</span></label>
                    <select name="ward_id" class="form-select" required>
                        <option value="">-- নির্বাচন --</option>
                        @foreach($wards as $w)
                            <option value="{{ $w->id }}">{{ $w->name_bn }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">নাম (বাংলা) <span class="text-danger">*</span></label>
                    <input type="text" name="name_bn" value="{{ old('name_bn') }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">নাম (ইংরেজি)</label>
                    <input type="text" name="name_en" value="{{ old('name_en') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">পোস্ট অফিস</label>
                    <input type="text" name="post_office" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">পোস্ট কোড</label>
                    <input type="text" name="post_code" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">জনসংখ্যা</label>
                    <input type="number" name="population" value="0" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> সংরক্ষণ</button>
    </div>
</form>
@endsection