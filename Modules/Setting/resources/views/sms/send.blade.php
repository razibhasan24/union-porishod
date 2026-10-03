@extends('core::layouts.app')

@section('title', 'SMS পাঠান')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-send"></i> SMS পাঠান</h4>
    <a href="{{ route('setting.sms-logs.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> লগ দেখুন
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('setting.sms-send.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">মোবাইল নম্বর <span class="text-danger">*</span></label>
                        <input type="text" name="mobile" value="{{ old('mobile') }}"
                               class="form-control @error('mobile') is-invalid @enderror"
                               placeholder="01XXXXXXXXX" required>
                        @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">মেসেজ <span class="text-danger">*</span></label>
                        <textarea name="message" rows="5"
                                  class="form-control @error('message') is-invalid @enderror"
                                  maxlength="500" required>{{ old('message') }}</textarea>
                        @error('message') <small class="text-danger">{{ $message }}</small> @enderror
                        <small class="text-muted">সর্বোচ্চ ৫০০ অক্ষর</small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> SMS পাঠান
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection