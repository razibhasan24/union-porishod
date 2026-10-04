<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>{{ $type->name_bn }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 8mm 10mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

html, body {
    width: 190mm;
    height: 281mm;
    font-family: 'SolaimanLipi', 'DejaVu Sans', sans-serif;
    font-size: 12px;
    line-height: 1.6;
    color: #000;
    background: white;
}

        .container {
            width: 100%;
            height: 100%;
            border: 5px double #8b5cf6;
            padding: 7mm 9mm;
            position: relative;
            page-break-inside: avoid;
            page-break-after: avoid;
            overflow: hidden;
        }

        .watermark {
            position: absolute;
            top: 45%;
            left: 50%;
            margin-left: -150px;
            margin-top: -60px;
            width: 300px;
            text-align: center;
            font-size: 70px;
            color: rgba(139, 92, 246, 0.05);
            font-weight: bold;
            z-index: 0;
            transform: rotate(-30deg);
            white-space: nowrap;
        }

        .header {
            text-align: center;
            padding-bottom: 7px;
            border-bottom: 2px solid #8b5cf6;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 3px;
        }

        .union-name {
            font-size: 21px;
            font-weight: bold;
            color: #8b5cf6;
            margin: 3px 0;
        }

        .union-address {
            font-size: 10px;
            color: #555;
            line-height: 1.4;
        }

        .cert-title {
            font-size: 17px;
            font-weight: bold;
            text-align: center;
            color: #8b5cf6;
            margin: 10px 0 8px 0;
            text-decoration: underline;
            text-underline-offset: 3px;
            position: relative;
            z-index: 1;
        }

        .cert-no {
            background: #f3e8ff;
            padding: 5px 10px;
            border: 1px solid #8b5cf6;
            margin: 8px 0;
            font-weight: bold;
            font-size: 10.5px;
            text-align: center;
            border-radius: 3px;
            position: relative;
            z-index: 1;
        }

        .section-title {
            background: #8b5cf6;
            color: white;
            padding: 4px 10px;
            font-weight: bold;
            margin: 10px 0 5px 0;
            font-size: 11.5px;
            border-radius: 3px;
            position: relative;
            z-index: 1;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
            position: relative;
            z-index: 1;
        }

        .info-table th,
        .info-table td {
            border: 1px solid #999;
            padding: 4px 7px;
            font-size: 10.5px;
        }

        .info-table th {
            background: #f0f0f0;
            font-weight: bold;
            text-align: left;
            width: 30%;
        }

        .info-table thead th {
            background: #8b5cf6;
            color: white;
            text-align: center;
            width: auto;
        }

        .body-text {
            font-size: 11.5px;
            text-align: justify;
            line-height: 1.7;
            margin: 8px 0;
            position: relative;
            z-index: 1;
        }

        .qr-section {
            margin-top: 10px;
            text-align: center;
            padding-top: 6px;
            border-top: 1px dashed #999;
            position: relative;
            z-index: 1;
        }

        .qr-box {
            width: 85px;
            height: 85px;
            display: inline-block;
            padding: 3px;
            background: white;
            border: 1px solid #ddd;
        }

        .qr-box svg,
        .qr-box img {
            width: 100%;
            height: 100%;
        }

        .qr-section p {
            font-size: 8.5px;
            color: #666;
            margin: 2px 0 0 0;
        }

        .verification-code {
            font-family: 'Courier New', monospace;
            font-size: 9.5px;
            color: #8b5cf6;
            font-weight: bold;
        }

        .footer-sign {
            width: 100%;
            margin-top: 20px;
            position: relative;
            z-index: 1;
        }

        .footer-sign td {
            text-align: center;
            width: 50%;
            padding: 0 12px;
            vertical-align: bottom;
        }

        .sign-line {
            border-top: 1.5px solid #000;
            padding-top: 4px;
            margin-top: 35px;
            font-size: 10.5px;
            line-height: 1.4;
        }

        .cert-footer {
            text-align: center;
            font-size: 8.5px;
            color: #888;
            margin-top: 10px;
            padding-top: 5px;
            border-top: 1px dashed #ddd;
            position: relative;
            z-index: 1;
        }

        @media print {
            .container {
                page-break-after: avoid;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="watermark">{{ $union->name_bn ?? 'ইউনিয়ন পরিষদ' }}</div>

        {{-- Header --}}
        <div class="header">
            @if($union?->logo && file_exists(storage_path('app/public/' . $union->logo)))
                <img src="{{ storage_path('app/public/' . $union->logo) }}" class="logo" alt="Logo">
            @endif
            <div class="union-name">{{ $union->name_bn ?? 'ইউনিয়ন পরিষদ' }}</div>
            <div class="union-address">
                {{ $union->upazila_bn ?? '' }}
                @if($union?->district_bn), {{ $union->district_bn }}@endif
                @if($union?->phone) | ফোন: {{ $union->phone }}@endif
            </div>
        </div>

        {{-- Title --}}
        <div class="cert-title">{{ $type->name_bn ?? 'ওয়ারিশ সনদ' }}</div>

        {{-- Cert Number --}}
        <div class="cert-no">
            নম্বর: {{ $certificate->certificate_no ?? '-' }}
            | ইস্যু: {{ bangla_date($certificate->issue_date ?? now()) }}
            @if($certificate?->expiry_date)
                | মেয়াদ: {{ bangla_date($certificate->expiry_date) }}
            @endif
        </div>

        {{-- মৃত ব্যক্তির তথ্য --}}
        @php $deceased = $application->deceased_info ?? []; @endphp
        @if(!empty($deceased) && !empty($deceased['name']))
        <div class="section-title">মৃত ব্যক্তির তথ্য</div>
        <table class="info-table">
            <tr>
                <th>নাম</th>
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

        {{-- উত্তরাধিকারী --}}
        @if(!empty($application->heirs) && is_array($application->heirs))
        @php
            $validHeirs = array_filter($application->heirs, fn($h) => !empty($h['name']));
        @endphp
        @if(count($validHeirs) > 0)
        <div class="section-title">উত্তরাধিকারীবৃন্দ</div>
        <table class="info-table">
            <thead>
                <tr>
                    <th style="width: 8%;">ক্রম</th>
                    <th style="width: 30%;">নাম</th>
                    <th style="width: 22%;">সম্পর্ক</th>
                    <th style="width: 12%;">বয়স</th>
                    <th style="width: 28%;">NID / জন্ম সনদ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($validHeirs as $i => $heir)
                <tr>
                    <td style="text-align: center;">{{ bangla_number($i + 1) }}</td>
                    <td>{{ $heir['name'] }}</td>
                    <td>{{ $heir['relation'] ?? '-' }}</td>
                    <td style="text-align: center;">{{ !empty($heir['age']) ? bangla_number($heir['age']) : '-' }}</td>
                    <td>{{ $heir['nid'] ?? $heir['certificate_no'] ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        @endif

        {{-- সম্পত্তি --}}
        @php $property = $application->property_info ?? []; @endphp
        @if(!empty($property) && !empty($property['description']))
        <div class="section-title">সম্পত্তির তথ্য</div>
        <table class="info-table">
            <tr>
                <th>বিবরণ</th>
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
            তাহাদের মধ্যে কোন পারিবারিক বিরোধ নেই এবং তাঁহারা এই সনদ প্রাপ্তির বৈধ দাবিদার।
            <br><br>
            এই সনদ
            @if($type->validity_days)
                <strong>{{ bangla_number($type->validity_days) }} দিন</strong>
            @else
                <strong>৯০ দিন</strong>
            @endif
            পর্যন্ত বৈধ থাকবে।
        </div>

        {{-- QR --}}
        @if(isset($qrSvg) && $qrSvg)
        <div class="qr-section">
            <div class="qr-box">{!! $qrSvg !!}</div>
            <p>QR কোড স্ক্যান করে সনদটি যাচাই করুন</p>
            <p class="verification-code">{{ $certificate->verification_code ?? '' }}</p>
        </div>
        @elseif(isset($qrCode) && $qrCode)
        <div class="qr-section">
            <div class="qr-box"><img src="{{ $qrCode }}" alt="QR"></div>
            <p>QR কোড স্ক্যান করে সনদটি যাচাই করুন</p>
            <p class="verification-code">{{ $certificate->verification_code ?? '' }}</p>
        </div>
        @endif

        {{-- Signature --}}
        <table class="footer-sign">
            <tr>
                <td>
                    <div class="sign-line">
                        {{ $application->ward->member_name_bn ?? 'ওয়ার্ড সদস্য' }}<br>
                        <small>ওয়ার্ড সদস্য, {{ $application->ward->name_bn ?? '' }}</small>
                    </div>
                </td>
                <td>
                    <div class="sign-line">
                        <strong>{{ $union->chairman_name_bn ?? 'চেয়ারম্যান' }}</strong><br>
                        <small>চেয়ারম্যান, {{ $union->name_bn ?? '' }}</small>
                    </div>
                </td>
            </tr>
        </table>

        <div class="cert-footer">
            ডিজিটালি তৈরি: {{ bangla_date($generatedAt) }} | ট্র্যাকিং: {{ $application->tracking_no }}
        </div>
    </div>
</body>
</html>
