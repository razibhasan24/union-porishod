<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>{{ $type->name_bn }}</title>
    <style>
        @page {
            margin: 15mm 15mm 15mm 15mm;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            line-height: 1.8;
            color: #000;
        }
        .container {
            border: 6px double #0a4d8c;
            padding: 30px;
            min-height: 250mm;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #0a4d8c;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 5px;
        }
        .union-name {
            font-size: 26px;
            font-weight: bold;
            color: #0a4d8c;
            margin: 5px 0;
        }
        .union-address {
            font-size: 12px;
            color: #555;
        }
        .cert-title {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            color: #0a4d8c;
            margin: 25px 0;
            text-decoration: underline;
        }
        .body-text {
            font-size: 14px;
            text-align: justify;
            line-height: 2.2;
            margin: 20px 0;
        }
        .info-table {
            width: 100%;
            margin: 15px 0;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 6px 10px;
            vertical-align: top;
        }
        .info-table td:first-child {
            width: 35%;
            font-weight: bold;
        }
        .cert-no {
            background: #fff3cd;
            padding: 10px 15px;
            border: 1px solid #ffc107;
            margin: 15px 0;
            font-weight: bold;
            font-size: 14px;
        }
        .footer-sign {
            width: 100%;
            margin-top: 60px;
        }
        .footer-sign td {
            text-align: center;
            width: 50%;
            padding: 0 20px;
        }
        .sign-line {
            border-top: 2px solid #000;
            padding-top: 5px;
            margin-top: 50px;
            font-size: 12px;
        }
        .qr-section {
            margin-top: 30px;
            text-align: center;
            padding-top: 15px;
            border-top: 1px dashed #999;
        }
        .qr-section img {
            width: 90px;
            height: 90px;
        }
        .qr-section p {
            font-size: 10px;
            color: #666;
            margin: 3px 0;
        }
        .verification-code {
            font-family: monospace;
            font-size: 11px;
            color: #0a4d8c;
            font-weight: bold;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(10, 77, 140, 0.06);
            font-weight: bold;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="watermark">{{ $union->name_bn ?? 'ইউনিয়ন পরিষদ' }}</div>

    <div class="container">
        {{-- Header --}}
        <div class="header">
            @if($union?->logo && file_exists(storage_path('app/public/' . $union->logo)))
                <img src="{{ storage_path('app/public/' . $union->logo) }}" class="logo" alt="Logo">
            @endif
            <div class="union-name">{{ $union->name_bn ?? 'ইউনিয়ন পরিষদ' }}</div>
            <div class="union-address">
                {{ $union->upazila_bn ?? '' }}
                @if($union?->district_bn), {{ $union->district_bn }}@endif
                @if($union?->post_code) - {{ $union->post_code }}@endif
                <br>
                @if($union?->phone) ফোন: {{ $union->phone }} @endif
                @if($union?->email) | ইমেইল: {{ $union->email }} @endif
            </div>
        </div>

        {{-- Title --}}
        <div class="cert-title">{{ $type->name_bn ?? 'সার্টিফিকেট' }}</div>

        {{-- Certificate Number --}}
        <div class="cert-no">
            সার্টিফিকেট নম্বর: {{ $certificate->certificate_no ?? '-' }}
            <br>
            ইস্যু তারিখ: {{ bangla_date($certificate->issue_date ?? now()) }}
            @if($certificate?->expiry_date)
                | মেয়াদ শেষ: {{ bangla_date($certificate->expiry_date) }}
            @endif
        </div>

        {{-- Body --}}
        <div class="body-text">
            এই মর্মে প্রত্যয়ন করা যাইতেছে যে,
        </div>

        <table class="info-table">
            <tr>
                <td>নাম:</td>
                <td><strong>{{ $application->applicant_name_bn }}</strong></td>
            </tr>
            @if($application->applicant_father_name)
            <tr>
                <td>পিতার নাম:</td>
                <td>{{ $application->applicant_father_name }}</td>
            </tr>
            @endif
            @if($application->applicant_mother_name)
            <tr>
                <td>মাতার নাম:</td>
                <td>{{ $application->applicant_mother_name }}</td>
            </tr>
            @endif
            @if($application->applicant_nid)
            <tr>
                <td>জাতীয় পরিচয়পত্র নম্বর:</td>
                <td>{{ $application->applicant_nid }}</td>
            </tr>
            @endif
            @if($application->village)
            <tr>
                <td>গ্রাম:</td>
                <td>{{ $application->village->name_bn }}</td>
            </tr>
            @endif
            @if($application->ward)
            <tr>
                <td>ওয়ার্ড:</td>
                <td>{{ $application->ward->name_bn }}</td>
            </tr>
            @endif
            @if($application->applicant_address)
            <tr>
                <td>ঠিকানা:</td>
                <td>{{ $application->applicant_address }}</td>
            </tr>
            @endif
        </table>

        <div class="body-text">
            উপরিউক্ত ব্যক্তি {{ $union->name_bn ?? 'এই ইউনিয়ন পরিষদ' }}-এর একজন স্থায়ী বাসিন্দা এবং
            আমার জানামতে তাহার চরিত্র সন্তোষজনক। তিনি
            {{ $application->form_data['purpose'] ?? 'প্রয়োজনীয়' }} উদ্দেশ্যে এই সার্টিফিকেটের জন্য আবেদন করিয়াছেন।

            <br><br>
            এই সার্টিফিকেট
            @if($type->validity_days)
                {{ bangla_number($type->validity_days) }} দিন
            @else
                ৯০ দিন
            @endif
            পর্যন্ত বৈধ থাকবে।
        </div>

        {{-- QR Section --}}
        @if($qrCode)
        <div class="qr-section">
            <img src="{{ $qrCode }}" alt="QR Code">
            <p>এই QR কোড স্ক্যান করে সার্টিফিকেটটি অনলাইনে যাচাই করা যাবে।</p>
            <p class="verification-code">Verification Code: {{ $certificate->verification_code ?? '-' }}</p>
        </div>
        @endif

        {{-- Signature --}}
        <table class="footer-sign">
            <tr>
                <td>
                    <div class="sign-line">
                        ওয়ার্ড সদস্য<br>
                        {{ $application->ward->member_name_bn ?? 'ওয়ার্ড সদস্য' }}<br>
                        {{ $application->ward->name_bn ?? '' }}
                    </div>
                </td>
                <td>
                    <div class="sign-line">
                        চেয়ারম্যান<br>
                        <strong>{{ $union->chairman_name_bn ?? 'চেয়ারম্যান' }}</strong><br>
                        {{ $union->name_bn ?? '' }}
                    </div>
                </td>
            </tr>
        </table>

        <div style="text-align: center; margin-top: 30px; font-size: 10px; color: #666;">
            ডিজিটালি তৈরি: {{ bangla_date($generatedAt) }} |
            ট্র্যাকিং: {{ $application->tracking_no }}
        </div>
    </div>
</body>
</html>