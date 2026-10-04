<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <title>সার্টিফিকেট - {{ $application->issuedCertificate->certificate_no ?? '' }}</title>
    <style>
        /* ==================== A4 SINGLE PAGE SETUP ==================== */
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 210mm;
            height: 297mm;
            font-family: 'SolaimanLipi', 'DejaVu Sans', 'Segoe UI', Tahoma, sans-serif;
            background: white;
            color: #000;
            font-size: 13px;
            line-height: 1.6;
        }

        /* Certificate container — fit exactly on one A4 page */
        .certificate {
            width: 190mm;
            height: 277mm;
            padding: 10mm 12mm;
            border: 6px double #0a4d8c;
            margin: 0 auto;
            background: #fefefe;
            position: relative;
            display: flex;
            flex-direction: column;
            page-break-after: avoid;
            page-break-inside: avoid;
            overflow: hidden;
        }

        /* ==================== HEADER ==================== */
        .cert-header {
            text-align: center;
            padding-bottom: 8mm;
            border-bottom: 2px solid #0a4d8c;
            margin-bottom: 6mm;
            flex-shrink: 0;
        }

        .cert-logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
            margin-bottom: 4px;
        }

        .union-name {
            font-size: 24px;
            font-weight: bold;
            color: #0a4d8c;
            margin: 3px 0;
            letter-spacing: 0.5px;
        }

        .union-address {
            font-size: 11px;
            color: #444;
            margin-top: 2px;
        }

        .cert-title {
            font-size: 19px;
            font-weight: bold;
            color: #0a4d8c;
            margin: 6mm 0 4mm 0;
            text-align: center;
            text-decoration: underline;
            text-underline-offset: 4px;
            flex-shrink: 0;
        }

        /* ==================== CERT NUMBER BOX ==================== */
        .cert-no-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 6px 12px;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5mm;
            border-radius: 4px;
            flex-shrink: 0;
        }

        .cert-no-box span {
            margin: 0 12px;
        }

        /* ==================== BODY TEXT ==================== */
        .cert-body {
            font-size: 13.5px;
            line-height: 2;
            text-align: justify;
            flex-grow: 1;
            padding: 0 3mm;
        }

        .cert-body p {
            margin-bottom: 3mm;
        }

        .cert-body strong {
            color: #0a4d8c;
        }

        /* ==================== INFO TABLE ==================== */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 4mm 0;
        }

        .info-table td {
            padding: 4px 8px;
            vertical-align: top;
            font-size: 13px;
        }

        .info-table td:first-child {
            width: 32%;
            font-weight: bold;
            color: #333;
        }

        /* ==================== QR CODE ==================== */
        .qr-section {
            margin-top: 5mm;
            text-align: center;
            padding-top: 3mm;
            border-top: 1px dashed #999;
            flex-shrink: 0;
        }

        .qr-box {
            width: 110px;
            height: 110px;
            display: inline-block;
            padding: 4px;
            border: 1px solid #ddd;
            background: white;
        }

        .qr-box svg {
            width: 100%;
            height: 100%;
        }

        .qr-box img {
            width: 100%;
            height: 100%;
        }

        .qr-section p {
            font-size: 10px;
            color: #666;
            margin: 3px 0 0 0;
        }

        .verification-code {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            color: #0a4d8c;
            font-weight: bold;
            letter-spacing: 1px;
        }

        /* ==================== SIGNATURE ==================== */
        .signature-section {
            display: table;
            width: 100%;
            margin-top: 12mm;
            flex-shrink: 0;
        }

        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 0 5mm;
            vertical-align: bottom;
        }

        .sign-line {
            border-top: 1.5px solid #000;
            padding-top: 4px;
            margin-top: 35px;
            font-size: 12px;
            font-weight: 600;
        }

        .sign-designation {
            font-size: 11px;
            color: #444;
        }

        /* ==================== FOOTER ==================== */
        .cert-footer {
            text-align: center;
            font-size: 9px;
            color: #888;
            margin-top: 4mm;
            padding-top: 3mm;
            border-top: 1px dashed #ddd;
            flex-shrink: 0;
        }

        /* ==================== WATERMARK ==================== */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 90px;
            color: rgba(10, 77, 140, 0.04);
            font-weight: bold;
            z-index: 0;
            pointer-events: none;
            white-space: nowrap;
        }

        .cert-inner {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* ==================== PRINT BUTTON ==================== */
        .print-toolbar {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 9999;
            display: flex;
            gap: 8px;
        }

        .print-btn {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .print-btn:hover {
            background: #0b5ed7;
        }

        .print-btn.close-btn {
            background: #6c757d;
        }

        /* ==================== PRINT MEDIA ==================== */
        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
            }

            .print-toolbar {
                display: none !important;
            }

            .certificate {
                border: 6px double #0a4d8c !important;
                page-break-after: avoid;
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    {{-- Print Toolbar --}}
    <div class="print-toolbar">
        <button onclick="window.print()" class="print-btn">
            🖨️ প্রিন্ট করুন
        </button>
        <button onclick="window.close()" class="print-btn close-btn">
            ✕ বন্ধ করুন
        </button>
    </div>

    {{-- Certificate --}}
    <div class="certificate">
        <div class="watermark">{{ $application->union->name_bn ?? 'ইউনিয়ন পরিষদ' }}</div>

        <div class="cert-inner">

            {{-- ============ HEADER ============ --}}
            <div class="cert-header">
                @if ($application->union?->logo && file_exists(storage_path('app/public/' . $application->union->logo)))
                    <img src="{{ asset('storage/' . $application->union->logo) }}" class="cert-logo" alt="Logo">
                @endif
                <div class="union-name">
                    {{ $application->union->name_bn ?? 'ইউনিয়ন পরিষদ' }}
                </div>
                <div class="union-address">
                    {{ $application->union->upazila_bn ?? '' }}
                    @if ($application->union?->district_bn)
                        , {{ $application->union->district_bn }}
                    @endif
                    @if ($application->union?->post_code)
                        - {{ $application->union->post_code }}
                    @endif
                </div>
            </div>

            {{-- ============ TITLE ============ --}}
            <div class="cert-title">
                {{ $application->certificateType->name_bn ?? 'সার্টিফিকেট' }}
            </div>

            {{-- ============ CERTIFICATE NUMBER ============ --}}
            <div class="cert-no-box">
                <span>সনদ নম্বর: <strong>{{ $application->issuedCertificate->certificate_no ?? '-' }}</strong></span>
                <span>|</span>
                <span>ইস্যু:
                    <strong>{{ bangla_date($application->issuedCertificate->issue_date ?? now()) }}</strong></span>
                @if ($application->issuedCertificate?->expiry_date)
                    <span>|</span>
                    <span>মেয়াদ:
                        <strong>{{ bangla_date($application->issuedCertificate->expiry_date) }}</strong></span>
                @endif
            </div>

            {{-- ============ BODY ============ --}}
            <div class="cert-body">
                <p>
                    এই মর্মে প্রত্যয়ন করা যাইতেছে যে, <strong>{{ $application->applicant_name_bn }}</strong>,
                </p>

                <table class="info-table">
                    @if ($application->applicant_father_name)
                        <tr>
                            <td>পিতার নাম:</td>
                            <td>{{ $application->applicant_father_name }}</td>
                        </tr>
                    @endif
                    @if ($application->applicant_mother_name)
                        <tr>
                            <td>মাতার নাম:</td>
                            <td>{{ $application->applicant_mother_name }}</td>
                        </tr>
                    @endif
                    @if ($application->applicant_nid)
                        <tr>
                            <td>জাতীয় পরিচয়পত্র নম্বর:</td>
                            <td>{{ $application->applicant_nid }}</td>
                        </tr>
                    @endif
                    @if ($application->village)
                        <tr>
                            <td>গ্রাম:</td>
                            <td>{{ $application->village->name_bn }}</td>
                        </tr>
                    @endif
                    @if ($application->ward)
                        <tr>
                            <td>ওয়ার্ড:</td>
                            <td>{{ $application->ward->name_bn }}</td>
                        </tr>
                    @endif
                    @if ($application->applicant_address)
                        <tr>
                            <td>ঠিকানা:</td>
                            <td>{{ $application->applicant_address }}</td>
                        </tr>
                    @endif
                </table>

                <p>
                    উপরিউক্ত ব্যক্তি {{ $application->union->name_bn ?? 'এই ইউনিয়ন পরিষদ' }}-এর একজন স্থায়ী বাসিন্দা।
                    আমার জানামতে তাহার বিরুদ্ধে কোন ফৌজদারি মামলা নেই এবং তিনি
                    <strong>{{ $application->form_data['purpose'] ?? 'প্রয়োজনীয়' }}</strong>
                    কাজে এই সার্টিফিকেটের জন্য আবেদন করিয়াছেন।
                </p>

                <p>
                    এই সার্টিফিকেট
                    @if ($application->certificateType?->validity_days)
                        <strong>{{ bangla_number($application->certificateType->validity_days) }} দিন</strong>
                    @else
                        <strong>৯০ দিন</strong>
                    @endif
                    পর্যন্ত বৈধ থাকবে।
                </p>
            </div>

            {{-- ============ QR CODE ============ --}}
            @if (isset($qrSvg) && $qrSvg)
                <div class="qr-section">
                    <div class="qr-box">
                        {!! $qrSvg !!}
                    </div>
                    <p>QR কোড স্ক্যান করে সনদটি অনলাইনে যাচাই করুন</p>
                    <p class="verification-code">{{ $application->issuedCertificate->verification_code ?? '' }}</p>
                </div>
            @elseif(isset($qrCode) && $qrCode)
                <div class="qr-section">
                    <div class="qr-box">
                        <img src="{{ $qrCode }}" alt="QR Code">
                    </div>
                    <p>QR কোড স্ক্যান করে সনদটি অনলাইনে যাচাই করুন</p>
                    <p class="verification-code">{{ $application->issuedCertificate->verification_code ?? '' }}</p>
                </div>
            @endif

            {{-- ============ SIGNATURE ============ --}}
            <div class="signature-section">
                <div class="signature-box">
                    <div class="sign-line">
                        {{ $application->ward->member_name_bn ?? 'ওয়ার্ড সদস্য' }}
                    </div>
                    <div class="sign-designation">
                        ওয়ার্ড সদস্য, {{ $application->ward->name_bn ?? '' }}
                    </div>
                </div>

                <div class="signature-box">
                    <div class="sign-line">
                        {{ $application->union->chairman_name_bn ?? 'চেয়ারম্যান' }}
                    </div>
                    <div class="sign-designation">
                        চেয়ারম্যান, {{ $application->union->name_bn ?? '' }}
                    </div>
                </div>
            </div>

            {{-- ============ FOOTER ============ --}}
            <div class="cert-footer">
                এই সনদটি ডিজিটালি তৈরি করা হয়েছে |
                ট্র্যাকিং নম্বর: {{ $application->tracking_no }} |
                তৈরি: {{ bangla_date(now()) }}
            </div>

        </div>
    </div>

</body>

</html>
