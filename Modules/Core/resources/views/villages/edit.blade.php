@extends('core::layouts.app')
@section('title', 'গ্রাম সম্পাদনা')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>গ্রাম সম্পাদনা</h4>
    <a href="{{ route('core.villages.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> ফিরে যান</a>
</div>

<form action="{{ route('core.villages.update', $village) }}" method="POST">
    @csrf @method('PUT')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">ইউনিয়ন</label>
                    <select name="union_id" class="form-select">
                        @foreach($unions as $u)
                            <option value="{{ $u->id }}" {{ $village->union_id == $u->id ? 'selected' : '' }}>{{ $u->name_bn }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ওয়ার্ড</label>
                    <select name="ward_id" class="form-select">
                        @foreach($wards as $w)
                            <option value="{{ $w->id }}" {{ $village->ward_id == $w->id ? 'selected' : '' }}>{{ $w->name_bn }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">নাম (বাংলা)</label>
                    <input type="text" name="name_bn" value="{{ old('name_bn', $village->name_bn) }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">জনসংখ্যা</label>
                    <input type="number" name="population" value="{{ old('population', $village->population) }}" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> আপডেট</button>
    </div>
</form>
@endsection