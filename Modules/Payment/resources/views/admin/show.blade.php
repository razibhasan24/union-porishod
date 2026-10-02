@extends('core::layouts.app')

@section('title', 'পেমেন্ট বিস্তারিত')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-receipt"></i> পেমেন্ট বিস্তারিত</h4>
    <a href="{{ route('payment.admin.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <table class="table table-sm">
                    <tr><th width="30%">রিসিট নম্বর:</th><td><code>{{ $payment->receipt_no ?? '-' }}</code></td></tr>
                    <tr><th>ট্রানজেকশন আইডি:</th><td><code>{{ $payment->transaction_id }}</code></td></tr>
                    <tr><th>ট্র্যাকিং:</th><td><code>{{ $payment->application->tracking_no ?? '-' }}</code></td></tr>
                    <tr><th>সার্টিফিকেট:</th><td>{{ $payment->application->certificateType->name_bn ?? '-' }}</td></tr>
                    <tr><th>আবেদনকারী:</th><td>{{ $payment->application->applicant_name_bn ?? '-' }}</td></tr>
                    <tr><th>মোবাইল:</th><td>{{ $payment->payer_mobile }}</td></tr>
                    <tr><th>পরিমাণ:</th><td><strong>৳ {{ bangla_number(number_format($payment->amount, 0)) }}</strong></td></tr>
                    <tr><th>পদ্ধতি:</th><td>{{ $payment->method_label }} — {{ $payment->gateway_label }}</td></tr>
                    <tr><th>স্ট্যাটাস:</th>
                        <td><span class="badge bg-{{ $payment->status_color }}">{{ $payment->status_label }}</span></td>
                    </tr>
                    <tr><th>Initiated:</th><td>{{ bangla_date($payment->initiated_at) }}</td></tr>
                    <tr><th>Paid:</th><td>{{ $payment->paid_at ? bangla_date($payment->paid_at) : '-' }}</td></tr>
                    @if($payment->collectedBy)
                    <tr><th>গ্রহণকারী:</th><td>{{ $payment->collectedBy->name_bn ?? $payment->collectedBy->name }}</td></tr>
                    @endif
                    @if($payment->notes)
                    <tr><th>নোট:</th><td>{{ $payment->notes }}</td></tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if($payment->status === 'success')
                <a href="{{ route('payment.admin.receipt', $payment) }}"
                   class="btn btn-primary w-100 mb-2" target="_blank">
                    <i class="bi bi-printer"></i> রিসিট প্রিন্ট
                </a>
                @endif
                @if($payment->application)
                <a href="{{ route('certificate.applications.show', $payment->application) }}"
                   class="btn btn-info w-100">
                    <i class="bi bi-file-earmark-text"></i> আবেদন দেখুন
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection