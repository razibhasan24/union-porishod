@extends('applicant::layouts.app')

@section('title', 'পেমেন্ট ব্যর্থ')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body py-5">
                <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                     style="width: 80px; height: 80px;">
                    <i class="bi bi-x-circle-fill text-danger" style="font-size: 50px;"></i>
                </div>
                <h3 class="text-danger">পেমেন্ট ব্যর্থ হয়েছে</h3>
                <p class="text-muted">দুঃখিত, আপনার পেমেন্ট সম্পন্ন হয়নি। আবার চেষ্টা করুন অথবা অফিসে গিয়ে নগদ পেমেন্ট করুন।</p>

                @if($payment->notes)
                <div class="alert alert-warning small">
                    {{ $payment->notes }}
                </div>
                @endif

                <div class="d-grid gap-2 mt-3">
                    <a href="{{ route('applicant.payment.show', $application) }}" class="btn btn-primary">
                        <i class="bi bi-arrow-clockwise"></i> আবার চেষ্টা করুন
                    </a>
                    <a href="{{ route('applicant.applications.show', $application) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> ফিরে যান
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection