@extends('core::layouts.app')

@section('title', 'নগদ পেমেন্ট এন্ট্রি')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-cash-coin"></i> নগদ পেমেন্ট এন্ট্রি</h4>
    <a href="{{ route('payment.admin.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>আবেদনকারীর কাছ থেকে নগদ পেমেন্ট গ্রহণ</strong></div>
            <div class="card-body">
                <form action="{{ route('payment.admin.cash-store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">ট্র্যাকিং নম্বর <span class="text-danger">*</span></label>
                        <input type="text" name="tracking_no" value="{{ old('tracking_no') }}"
                               class="form-control @error('tracking_no') is-invalid @enderror"
                               placeholder="CERT-20251002-ABC123" required>
                        @error('tracking_no') <small class="text-danger">{{ $message }}</small> @enderror
                        <small class="text-muted">আবেদনকারীর কাছ থেকে ট্র্যাকিং নম্বর নিন</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">পরিমাণ (৳) <span class="text-danger">*</span></label>
                        <input type="number" name="amount" value="{{ old('amount') }}"
                               class="form-control @error('amount') is-invalid @enderror"
                               step="0.01" required>
                        @error('amount') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">রিসিট নম্বর (ঐচ্ছিক)</label>
                        <input type="text" name="receipt_no" value="{{ old('receipt_no') }}"
                               class="form-control" placeholder="খালি রাখলে অটো তৈরি হবে">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">নোট</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> পেমেন্ট রেকর্ড করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection