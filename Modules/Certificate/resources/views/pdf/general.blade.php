
<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <title>{{ $type->name_bn }}</title>

    <style>
        /* =====================================================
           mPDF Bengali Font
           Font name must match mPDF font configuration
        ===================================================== */

        @page {
            size: A4 portrait;
            margin: 8mm 10mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            font-family: 'solaimanlipi', sans-serif;
            font-size: 12px;
            line-height: 1.8;
            color: #000;
            background: #fff;
        }

        /* =====================================================
           MAIN CONTAINER
        ===================================================== */

        .container {
            width: 100%;
            border: 4px double #0a4d8c;
            padding: 6mm 8mm;
            position: relative;
        }

        /* =====================================================
           WATERMARK
        ===================================================== */

        .watermark {
            position: absolute;
            top: 40%;
            left: 15%;
            font-family: 'solaimanlipi', sans-serif;
            font-size: 60px;
            font-weight: bold;
            color: #e8eef7;
            z-index: -1;
        }

        /* =====================================================
           HEADER
        ===================================================== */

        .header {
            text-align: center;
            padding-bottom: 8px;
            border-bottom: 2px solid #0a4d8c;
            margin-bottom: 12px;
        }

        .logo {
            width: 65px;
            height: 65px;
            margin-bottom: 3px;
        }

        .union-name {
            font-family: 'solaimanlipi', sans-serif;
            font-size: 22px;
            font-weight: bold;
            color: #0a4d8c;
            margin: 4px 0;
        }

        .union-address {
            font-family: 'solaimanlipi', sans-serif;
            font-size: 11px;
            color: #555;
            line-height: 1.5;
        }

        /* =====================================================
           CERTIFICATE TITLE
        ===================================================== */

        .cert-title {
            font-family: 'solaimanlipi', sans-serif;
            font-size: 19px;
            font-weight: bold;
            text-align: center;
            color: #0a4d8c;
            margin: 14px 0 12px 0;
            text-decoration: underline;
        }

        /* =====================================================
           CERTIFICATE NUMBER
        ===================================================== */

        .cert-no {
            font-family: 'solaimanlipi', sans-serif;
            background: #fff3cd;
            padding: 7px 12px;
            border: 1px solid #ffc107;
            margin: 12px 0;
            font-weight: bold;
            font-size: 11.5px;
            text-align: center;
        }

        /* =====================================================
           BODY TEXT
        ===================================================== */

        .body-text {
            font-family: 'solaimanlipi', sans-serif;
            font-size: 12.5px;
            text-align: justify;
            line-height: 2;
            margin: 10px 0;
        }

        /* =====================================================
           INFORMATION TABLE
        ===================================================== */

        .info-table {
            width: 100%;
            margin: 10px 0;
            border-collapse: collapse;
            font-family: 'solaimanlipi', sans-serif;
        }

        .info-table td {
            padding: 5px 8px;
            vertical-align: top;
            font-family: 'solaimanlipi', sans-serif;
            font-size: 12.5px;
        }

        .info-table td:first-child {
            width: 32%;
            font-weight: bold;
            color: #333;
        }

        /* =====================================================
           QR SECTION
        ===================================================== */

        .qr-section {
            margin-top: 12px;
            text-align: center;
            padding-top: 8px;
            border-top: 1px dashed #999;
            font-family: 'solaimanlipi', sans-serif;
        }

        .qr-box {
            width: 95px;
            height: 95px;
            display: inline-block;
            padding: 3px;
            background: #fff;
            border: 1px solid #ddd;
        }

        .qr-box img {
            width: 100%;
            height: 100%;
        }

        .qr-section p {
            font-family: 'solaimanlipi', sans-serif;
            font-size: 10.5px;
            color: #666;
            margin: 3px 0 0 0;
        }

        .verification-code {
            font-family: 'solaimanlipi', sans-serif;
            font-size: 11px;
            color: #0a4d8c;
            font-weight: bold;
        }

        /* =====================================================
           SIGNATURE
        ===================================================== */

        .footer-sign {
            width: 100%;
            margin-top: 25px;
            font-family: 'solaimanlipi', sans-serif;
        }

        .footer-sign td {
            width: 50%;
            padding: 0 15px;
            text-align: center;
            vertical-align: bottom;
            font-family: 'solaimanlipi', sans-serif;
        }

        .sign-line {
            border-top: 1.5px solid #000;
            padding-top: 4px;
            margin-top: 40px;
            font-family: 'solaimanlipi', sans-serif;
            font-size: 12px;
            line-height: 1.6;
        }

        .sign-line strong {
            color: #0a4d8c;
        }

        /* =====================================================
           FOOTER
        ===================================================== */

        .cert-footer {
            text-align: center;
            font-family: 'solaimanlipi', sans-serif;
            font-size: 10px;
            color: #888;
            margin-top: 15px;
            padding-top: 6px;
            border-top: 1px dashed #ddd;
        }
    </style>
</head>

<body>

    <div class="container">

        {{-- =================================================
             WATERMARK
        ================================================== --}}

        <div class="watermark">
            {{ $union->name_bn ?? 'ইউনিয়ন পরিষদ' }}
        </div>


        {{-- =================================================
             HEADER
        ================================================== --}}

        <div class="header">

            @if ($union?->logo && file_exists(storage_path('app/public/' . $union->logo)))
                <img
                    src="{{ storage_path('app/public/' . $union->logo) }}"
                    class="logo"
                    alt="Logo"
                >
            @endif

            <div class="union-name">
                {{ $union->name_bn ?? 'ইউনিয়ন পরিষদ' }}
            </div>

            <div class="union-address">

                {{ $union->upazila_bn ?? '' }}

                @if ($union?->district_bn)
                    , {{ $union->district_bn }}
                @endif

                @if ($union?->post_code)
                    - {{ $union->post_code }}
                @endif

                @if ($union?->phone)
                    <br>
                    ফোন: {{ $union->phone }}
                @endif

            </div>

        </div>


        {{-- =================================================
             CERTIFICATE TITLE
        ================================================== --}}

        <div class="cert-title">
            {{ $type->name_bn ?? 'সার্টিফিকেট' }}
        </div>


        {{-- =================================================
             CERTIFICATE NUMBER
        ================================================== --}}

        <div class="cert-no">

            সার্টিফিকেট নম্বর:
            {{ $certificate->certificate_no ?? '-' }}

            &nbsp; | &nbsp;

            ইস্যু তারিখ:
            {{ bangla_date($certificate->issue_date ?? now()) }}

            @if ($certificate?->expiry_date)

                &nbsp; | &nbsp;

                মেয়াদ শেষ:
                {{ bangla_date($certificate->expiry_date) }}

            @endif

        </div>


        {{-- =================================================
             INTRODUCTION
        ================================================== --}}

        <div class="body-text">

            এই মর্মে প্রত্যয়ন করা যাইতেছে যে,

        </div>


        {{-- =================================================
             APPLICANT INFORMATION
        ================================================== --}}

        <table class="info-table">

            <tr>
                <td>নাম:</td>

                <td>
                    <strong>
                        {{ $application->applicant_name_bn }}
                    </strong>
                </td>
            </tr>


            @if ($application->applicant_father_name)

                <tr>
                    <td>পিতার নাম:</td>

                    <td>
                        {{ $application->applicant_father_name }}
                    </td>
                </tr>

            @endif


            @if ($application->applicant_mother_name)

                <tr>
                    <td>মাতার নাম:</td>

                    <td>
                        {{ $application->applicant_mother_name }}
                    </td>
                </tr>

            @endif


            @if ($application->applicant_nid)

                <tr>
                    <td>জাতীয় পরিচয়পত্র নম্বর:</td>

                    <td>
                        {{ $application->applicant_nid }}
                    </td>
                </tr>

            @endif


            @if ($application->village)

                <tr>
                    <td>গ্রাম:</td>

                    <td>
                        {{ $application->village->name_bn }}
                    </td>
                </tr>

            @endif


            @if ($application->ward)

                <tr>
                    <td>ওয়ার্ড:</td>

                    <td>
                        {{ $application->ward->name_bn }}
                    </td>
                </tr>

            @endif


            @if ($application->applicant_address)

                <tr>
                    <td>ঠিকানা:</td>

                    <td>
                        {{ $application->applicant_address }}
                    </td>
                </tr>

            @endif

        </table>


        {{-- =================================================
             CERTIFICATE DESCRIPTION
        ================================================== --}}

        <div class="body-text">

            উপরিউক্ত ব্যক্তি
            {{ $union->name_bn ?? 'এই ইউনিয়ন পরিষদ' }}
            -এর একজন স্থায়ী বাসিন্দা এবং আমার জানামতে তাহার চরিত্র সন্তোষজনক।

            তিনি

            <strong>
                {{ $application->form_data['purpose'] ?? 'প্রয়োজনীয়' }}
            </strong>

            উদ্দেশ্যে এই সার্টিফিকেটের জন্য আবেদন করিয়াছেন।

            <br>
            <br>

            এই সার্টিফিকেট

            @if ($type->validity_days)

                <strong>
                    {{ bangla_number($type->validity_days) }} দিন
                </strong>

            @else

                <strong>
                    ৯০ দিন
                </strong>

            @endif

            পর্যন্ত বৈধ থাকবে।

        </div>


        {{-- =================================================
             QR CODE
        ================================================== --}}

        @if (isset($qrCode) && $qrCode)

            <div class="qr-section">

                <div class="qr-box">

                    <img
                        src="{{ $qrCode }}"
                        alt="QR Code"
                    >

                </div>

                <p>
                    QR কোড স্ক্যান করে সনদটি অনলাইনে যাচাই করুন
                </p>

                <p class="verification-code">

                    {{ $certificate->verification_code ?? '' }}

                </p>

            </div>

        @endif


        {{-- =================================================
             SIGNATURE
        ================================================== --}}

        <table class="footer-sign">

            <tr>

                {{-- Ward Member --}}

                <td>

                    <div class="sign-line">

                        {{ $application->ward->member_name_bn ?? 'ওয়ার্ড সদস্য' }}

                        <br>

                        <small>
                            ওয়ার্ড সদস্য
                        </small>

                        <br>

                        <small>
                            {{ $application->ward->name_bn ?? '' }}
                        </small>

                    </div>

                </td>


                {{-- Chairman --}}

                <td>

                    <div class="sign-line">

                        <strong>
                            {{ $union->chairman_name_bn ?? 'চেয়ারম্যান' }}
                        </strong>

                        <br>

                        <small>
                            চেয়ারম্যান
                        </small>

                        <br>

                        <small>
                            {{ $union->name_bn ?? '' }}
                        </small>

                    </div>

                </td>

            </tr>

        </table>


        {{-- =================================================
             FOOTER
        ================================================== --}}

        <div class="cert-footer">

            ডিজিটালি তৈরি:
            {{ bangla_date($generatedAt) }}

            |

            ট্র্যাকিং:
            {{ $application->tracking_no }}

        </div>

    </div>

</body>

</html>

