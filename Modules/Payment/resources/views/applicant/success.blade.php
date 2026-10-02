@extends('applicant::layouts.app')

@section('title', 'পেমেন্ট সফল')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body py-5">
                <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                     style="width: 80px; height: 80px;">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 50px;"></i>
                </div>
                <h3 class="text-success">পেমেন্ট সফল হয়েছে!</h3>
                <p class="text-muted">আপনার আবেদন এখন ওয়ার্ড সদস্যের যাচাইয়ের জন্য পাঠানো হয়েছে।</p>

                <table class="table table-sm mt-4">
                    <tr><th class="text-start">রিসিট নম্বর:</th><td class="text-end"><code>{{ $payment->receipt_no }}</code></td></tr>
                    <tr><th class="text-start">ট্র্যাকিং:</th><td class="text-end"><code>{{ $application->tracking_no }}</code></td></tr>
                    <tr><th class="text-start">পরিমাণ:</th><td class="text-end"><strong>৳ {{ bangla_number(number_format($payment->amount, 0)) }}</strong></td></tr>
                    <tr><th class="text-start">পদ্ধতি:</th><td class="text-end">{{ $payment->gateway_label }}</td></tr>
                    <tr><th class="text-start">সময়:</th><td class="text-end">{{ bangla_date($payment->paid_at) }}</td></tr>
                </table>

                <div class="d-grid gap-2 mt-3">
                    <a href="{{ route('applicant.applications.show', $application) }}" class="btn btn-primary">
                        <i class="bi bi-eye"></i> আবেদন দেখুন
                    </a>
                    <a href="{{ route('applicant.applications.receipt', $application) }}"
                       class="btn btn-outline-primary" target="_blank">
                        <i class="bi bi-printer"></i> রিসিট প্রিন্ট
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection