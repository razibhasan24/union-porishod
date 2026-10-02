<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>সার্টিফিকেট - {{ $application->issuedCertificate->certificate_no ?? '' }}</title>
    <style>
        body { font-family: 'SolaimanLipi', 'Segoe UI', serif; padding: 30px; background: white; }
        .certificate {
            border: 8px double #0d6efd;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
            background: #fefefe;
        }
        .certificate h1 {
            color: #0d6efd;
            font-size: 28px;
            margin-bottom: 5px;
        }
        .header-line { border-top: 3px solid #0d6efd; width: 100px; margin: 10px auto; }
        .body-text { font-size: 16px; line-height: 1.8; text-align: justify; }
        .footer-sign { display: flex; justify-content: space-between; margin-top: 60px; }
        .sign-box { text-align: center; }
        .sign-line { border-top: 1px solid black; width: 180px; padding-top: 5px; margin-top: 40px; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="text-center">
            @if($application->union?->logo)
                <img src="{{ asset('storage/' . $application->union->logo) }}" width="80" alt="Logo">
            @endif
            <h1>{{ $application->union->name_bn ?? 'ইউনিয়ন পরিষদ' }}</h1>
            <p>{{ $application->union->upazila_bn ?? '' }}, {{ $application->union->district_bn ?? '' }}</p>
            <div class="header-line"></div>
            <h3 style="margin-top: 20px;">{{ $application->certificateType->name_bn }}</h3>
        </div>

        <div class="mt-4 body-text">
            <p>
                এই মর্মে প্রত্যয়ন করা যাইতেছে যে, <strong>{{ $application->applicant_name_bn }}</strong>,
                পিতা: {{ $application->applicant_father_name ?? '-' }},
                মাতা: {{ $application->applicant_mother_name ?? '-' }},
                ঠিকানা: {{ $application->applicant_address ?? '-' }},
                এ {{ $application->union->name_bn ?? '' }} এর স্থায়ী বাসিন্দা।
            </p>

            <p>
                আমার জানামতে তাহার বিরুদ্ধে কোন Criminal Case নেই এবং তিনি {{ $application->form_data['purpose'] ?? 'প্রয়োজনীয়' }} কাজে এই সার্টিফিকেট প্রদান করা হইল।
            </p>

            <p class="mt-4">
                <strong>সার্টিফিকেট নম্বর:</strong> {{ $application->issuedCertificate->certificate_no ?? '-' }}<br>
                <strong>ইস্যু তারিখ:</strong> {{ bangla_date($application->issuedCertificate->issue_date ?? now()) }}<br>
                <strong>মেয়াদ শেষ:</strong> {{ bangla_date($application->issuedCertificate->expiry_date ?? now()->addDays(90)) }}
            </p>
        </div>

        <div class="footer-sign">
            <div class="sign-box">
                <div class="sign-line"></div>
                <div>ওয়ার্ড সদস্য</div>
                <div class="small">{{ $application->ward->name_bn ?? '' }}</div>
            </div>
            <div class="sign-box">
                <div class="sign-line"></div>
                <div>চেয়ারম্যান</div>
                <div class="small">{{ $application->union->name_bn ?? '' }}</div>
            </div>
        </div>

        <div class="text-center mt-4 small text-muted">
            Verification Code: <code>{{ $application->issuedCertificate->verification_code ?? '' }}</code>
        </div>
    </div>

    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-primary">প্রিন্ট করুন</button>
    </div>
</body>
</html>