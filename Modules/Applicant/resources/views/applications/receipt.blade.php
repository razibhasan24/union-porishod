<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>রিসিট - {{ $application->tracking_no }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: white; padding: 20px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center mb-4">
            <h3>{{ $application->union->name_bn ?? 'ইউনিয়ন পরিষদ' }}</h3>
            <p>{{ $application->union->upazila_bn ?? '' }}, {{ $application->union->district_bn ?? '' }}</p>
            <hr>
            <h4>পেমেন্ট রিসিট</h4>
        </div>

        <table class="table table-bordered">
            <tr><th width="40%">ট্র্যাকিং নম্বর:</th><td><code>{{ $application->tracking_no }}</code></td></tr>
            <tr><th>আবেদনকারী:</th><td>{{ $application->applicant_name_bn }}</td></tr>
            <tr><th>মোবাইল:</th><td>{{ $application->applicant_phone }}</td></tr>
            <tr><th>সার্টিফিকেটের ধরন:</th><td>{{ $application->certificateType->name_bn ?? '-' }}</td></tr>
            <tr><th>ফি:</th><td><strong>৳ {{ number_format($application->amount, 0) }}</strong></td></tr>
            <tr><th>পরিশোধিত:</th><td>৳ {{ number_format($application->paid_amount, 0) }}</td></tr>
            <tr><th>পেমেন্ট পদ্ধতি:</th><td>{{ $application->payment_method === 'online' ? 'অনলাইন' : 'নগদ' }}</td></tr>
            <tr><th>তারিখ:</th><td>{{ bangla_date($application->paid_at) }}</td></tr>
            <tr><th>রেফারেন্স:</th><td>{{ $application->payment_ref ?? '-' }}</td></tr>
        </table>

        <div class="text-end mt-5">
            <p>______________________</p>
            <p>অনুমোদিত স্বাক্ষর</p>
        </div>

        <div class="text-center mt-4 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer"></i> প্রিন্ট করুন
            </button>
            <button onclick="window.close()" class="btn btn-secondary">বন্ধ করুন</button>
        </div>
    </div>
</body>
</html>