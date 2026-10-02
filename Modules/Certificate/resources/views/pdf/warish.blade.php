<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>{{ $type->name_bn }}</title>
    <style>
        @page { margin: 15mm; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.7;
            color: #000;
        }
        .container {
            border: 6px double #8b5cf6;
            padding: 25px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #8b5cf6;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }
        .union-name {
            font-size: 24px;
            font-weight: bold;
            color: #8b5cf6;
            margin: 5px 0;
        }
        .cert-title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            color: #8b5cf6;
            margin: 20px 0;
            text-decoration: underline;
        }
        .cert-no {
            background: #f3e8ff;
            padding: 8px 12px;
            border: 1px solid #8b5cf6;
            margin: 12px 0;
            font-weight: bold;
            font-size: 13px;
        }
        .section-title {
            background: #8b5cf6;
            color: white;
            padding: 5px 10px;
            font-weight: bold;
            margin: 15px 0 8px 0;
            font-size: 13px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .info-table th,
        .info-table td {
            border: 1px solid #999;
            padding: 5px 8px;
            font-size: 11px;
        }
        .info-table th {
            background: #f0f0f0;
            font-weight: bold;
            text-align: left;
        }
        .body-text {
            font-size: 13px;
            text-align: justify;
            line-height: 2;
            margin: 12px 0;
        }
        .footer-sign {
            width: 100%;
            margin-top: 40px;
        }
        .footer-sign td {
            text-align: center;
            width: 50%;
            padding: 0 15px;
        }
        .sign-line {
            border-top: 2px solid #000;
            padding-top: 5px;
            margin-top: 45px;
            font-size: 11px;
        }
        .qr-section {
            margin-top: 20px;
            text-align: center;
            padding-top: 12px;
            border-top: 1px dashed #999;
        }
        .qr-section img {
            width: 80px;
            height: 80px;
        }
        .qr-section p {
            font-size: 9px;
            color: #666;
            margin: 2px 0;
        }
        .verification-code {
            font-family: monospace;
            font-size: 10px;
            color: #8b5cf6;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <div class="header">
            @if($union?->logo && file_exists(storage_path('app/public/' . $union->logo)))
                <img src="{{ storage_path('app/public/' . $union->logo) }}" width="70" height="70" alt="Logo">
            @endif
            <div class="union-name">{{ $union->name_bn ?? 'ইউনিয়ন পরিষদ' }}</div>
            <div style="font-size: 11px; color: #555;">
                {{ $union->upazila_bn ?? '' }}
                @if($union?->district_bn), {{ $union->district_bn }}@endif
                <br>
                @if($union?->phone) ফোন: {{ $union->phone }} @endif
            </div>
        </div>

        {{-- Title --}}
        <div class="cert-title">{{ $type->name_bn ?? 'ওয়ারিশ সনদ' }}</div>

        {{-- Certificate Number --}}
        <div class="cert-no">
            সার্টিফিকেট নম্বর: {{ $certificate->certificate_no ?? '-' }} |
            ইস্যু তারিখ: {{ bangla_date($certificate->issue_date ?? now()) }}
            @if($certificate?->expiry_date)
                | মেয়াদ শেষ: {{ bangla_date($certificate->expiry_date) }}
            @endif
        </div>

        {{-- মৃত ব্যক্তির তথ্য --}}
        @php $deceased = $application->deceased_info ?? []; @endphp
        @if(!empty($deceased))
        <div class="section-title">মৃত ব্যক্তির তথ্য</div>
        <table class="info-table">
            <tr>
                <th width="30%">নাম</th>
                <td>{{ $deceased['name'] ?? '-' }}</td>
            </tr>
            @if(!empty($deceased['father']))
            <tr>
                <th>পিতার নাম</th>
                <td>{{ $deceased['father'] }}</td>
            </tr>
            @endif
            @if(!empty($deceased['death_date']))
            <tr>
                <th>মৃত্যুর তারিখ</th>
                <td>{{ bangla_date($deceased['death_date']) }}</td>
            </tr>
            @endif
            @if(!empty($deceased['address']))
            <tr>
                <th>ঠিকানা</th>
                <td>{{ $deceased['address'] }}</td>
            </tr>
            @endif
            @if(!empty($deceased['nid']))
            <tr>
                <th>NID</th>
                <td>{{ $deceased['nid'] }}</td>
            </tr>
            @endif
            @if(!empty($deceased['certificate_no']))
            <tr>
                <th>মৃত্যু সনদ নম্বর</th>
                <td>{{ $deceased['certificate_no'] }}</td>
            </tr>
            @endif
        </table>
        @endif

        {{-- উত্তরাধিকারীদের তালিকা --}}
        @if(!empty($application->heirs) && is_array($application->heirs))
        <div class="section-title">উত্তরাধিকারীবৃন্দের তালিকা</div>
        <table class="info-table">
            <thead>
                <tr>
                    <th width="5%">ক্রম</th>
                    <th width="30%">নাম</th>
                    <th width="20%">সম্পর্ক</th>
                    <th width="10%">বয়স</th>
                    <th width="35%">NID / জন্ম সনদ নম্বর</th>
                </tr>
            </thead>
            <tbody>
                @foreach($application->heirs as $i => $heir)
                @if(!empty($heir['name']))
                <tr>
                    <td style="text-align: center;">{{ bangla_number($i + 1) }}</td>
                    <td>{{ $heir['name'] }}</td>
                    <td>{{ $heir['relation'] ?? '-' }}</td>
                    <td>{{ !empty($heir['age']) ? bangla_number($heir['age']) : '-' }}</td>
                    <td>{{ $heir['nid'] ?? $heir['certificate_no'] ?? '-' }}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        @endif

        {{-- সম্পত্তির তথ্য --}}
        @php $property = $application->property_info ?? []; @endphp
        @if(!empty($property) && !empty($property['description']))
        <div class="section-title">সম্পত্তির তথ্য</div>
        <table class="info-table">
            <tr>
                <th width="30%">বিবরণ</th>
                <td>{{ $property['description'] }}</td>
            </tr>
            @if(!empty($property['location']))
            <tr>
                <th>অবস্থান</th>
                <td>{{ $property['location'] }}</td>
            </tr>
            @endif
            @if(!empty($property['area']))
            <tr>
                <th>পরিমাণ</th>
                <td>{{ $property['area'] }}</td>
            </tr>
            @endif
        </table>
        @endif

        {{-- Body Text --}}
        <div class="body-text">
            উপরিউক্ত মৃত ব্যক্তির বৈধ উত্তরাধিকারীবৃন্দ উল্লেখিত তালিকা অনুযায়ী
            {{ $union->name_bn ?? 'এই ইউনিয়ন পরিষদ' }}-এর বাসিন্দা। আমার জানামতে
            তাহাদের মধ্যে কোন পারিবারিক বিরোধ নেই এবং তাঁহারা এই সনদ প্রাপ্তির জন্য বৈধ দাবিদার।
            <br><br>
            এই সনদ
            @if($type->validity_days)
                {{ bangla_number($type->validity_days) }} দিন
            @else
                ৯০ দিন
            @endif
            পর্যন্ত বৈধ থাকবে।
        </div>

        {{-- QR --}}
        @if($qrCode)
        <div class="qr-section">
            <img src="{{ $qrCode }}" alt="QR Code">
            <p>QR কোড স্ক্যান করে সনদটি যাচাই করুন</p>
            <p class="verification-code">{{ $certificate->verification_code ?? '-' }}</p>
        </div>
        @endif

        {{-- Signature --}}
        <table class="footer-sign">
            <tr>
                <td>
                    <div class="sign-line">
                        ওয়ার্ড সদস্য<br>
                        {{ $application->ward->member_name_bn ?? '' }}<br>
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

        <div style="text-align: center; margin-top: 20px; font-size: 9px; color: #666;">
            ডিজিটালি তৈরি: {{ bangla_date($generatedAt) }} | ট্র্যাকিং: {{ $application->tracking_no }}
        </div>
    </div>
</body>
</html>