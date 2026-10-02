<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>রিসিট — {{ $payment->receipt_no }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: white; padding: 20px; font-family: 'SolaimanLipi', 'Segoe UI', sans-serif; }
        @media print { .no-print { display: none; } }
        .receipt-box { max-width: 700px; margin: 0 auto; border: 2px solid #333; padding: 30px; }
    </style>
</head>
<body>
    <div class="receipt-box">
        <div class="text-center mb-4">
            <h4>{{ $payment->application->union->name_bn ?? 'ইউনিয়ন পরিষদ' }}</h4>
            <p class="small">{{ $payment->application->union->upazila_bn ?? '' }}, {{ $payment->application->union->district_bn ?? '' }}</p>
            <hr>
            <h5>পেমেন্ট রিসিট</h5>
        </div>

        <table class="table table-bordered table-sm">
            <tr><th width="40%">রিসিট নম্বর:</th><td><strong>{{ $payment->receipt_no }}</strong></td></tr>
            <tr><th>ট্রানজেকশন আইডি:</th><td>{{ $payment->transaction_id }}</td></tr>
            <tr><th>ট্র্যাকিং নম্বর:</th><td>{{ $payment->application->tracking_no ?? '-' }}</td></tr>
            <tr><th>সার্টিফিকেট:</th><td>{{ $payment->application->certificateType->name_bn ?? '-' }}</td></tr>
            <tr><th>আবেদনকারী:</th><td>{{ $payment->application->applicant_name_bn ?? '-' }}</td></tr>
            <tr><th>মোবাইল:</th><td>{{ $payment->payer_mobile }}</td></tr>
            <tr><th>পরিমাণ:</th><td><strong>৳ {{ number_format($payment->amount, 0) }}</strong></td></tr>
            <tr><th>পদ্ধতি:</th><td>{{ $payment->method_label }} ({{ $payment->gateway_label }})</td></tr>
            <tr><th>তারিখ:</th><td>{{ $payment->paid_at ? bangla_date($payment->paid_at) : '-' }}</td></tr>
            @if($payment->collectedBy)
            <tr><th>গ্রহণকারী:</th><td>{{ $payment->collectedBy->name_bn ?? $payment->collectedBy->name }}</td></tr>
            @endif
        </table>

        <div class="row mt-5">
            <div class="col-6 text-center">
                <div style="border-top: 1px solid #000; padding-top: 5px; margin-top: 40px;">আবেদনকারীর স্বাক্ষর</div>
            </div>
            <div class="col-6 text-center">
                <div style="border-top: 1px solid #000; padding-top: 5px; margin-top: 40px;">গ্রহণকারীর স্বাক্ষর</div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i> প্রিন্ট করুন
        </button>
        <button onclick="window.close()" class="btn btn-secondary">বন্ধ</button>
    </div>
</body>
</html>