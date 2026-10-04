<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <title><?php echo e($type->name_bn); ?></title>
    <style>
        /* ==================== A4 PAGE SETUP ==================== */
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
            width: 190mm;
            height: 281mm;
            font-family: 'SolaimanLipi', 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #000;
            background: white;
        }

        /* Container — fit exactly on one A4 page */
        .container {
            width: 100%;
            height: 100%;
            border: 5px double #0a4d8c;
            padding: 8mm 10mm;
            position: relative;
            page-break-inside: avoid;
            page-break-after: avoid;
            overflow: hidden;
            display: table;
        }

        .content {
            display: table-cell;
            vertical-align: top;
            height: 100%;
        }

        /* ==================== WATERMARK ==================== */
        .watermark {
            position: absolute;
            top: 45%;
            left: 50%;
            margin-left: -150px;
            margin-top: -60px;
            width: 300px;
            text-align: center;
            font-size: 70px;
            color: rgba(10, 77, 140, 0.05);
            font-weight: bold;
            z-index: 0;
            transform: rotate(-30deg);
            white-space: nowrap;
        }

        /* ==================== HEADER ==================== */
        .header {
            text-align: center;
            padding-bottom: 8px;
            border-bottom: 2px solid #0a4d8c;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }

        .logo {
            width: 65px;
            height: 65px;
            object-fit: contain;
            margin-bottom: 3px;
        }

        .union-name {
            font-size: 22px;
            font-weight: bold;
            color: #0a4d8c;
            margin: 3px 0;
            letter-spacing: 0.5px;
        }

        .union-address {
            font-size: 10px;
            color: #555;
            line-height: 1.4;
        }

        /* ==================== TITLE ==================== */
        .cert-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            color: #0a4d8c;
            margin: 12px 0 10px 0;
            text-decoration: underline;
            text-underline-offset: 3px;
            position: relative;
            z-index: 1;
        }

        /* ==================== CERT NUMBER ==================== */
        .cert-no {
            background: #fff3cd;
            padding: 6px 12px;
            border: 1px solid #ffc107;
            margin: 10px 0;
            font-weight: bold;
            font-size: 11px;
            text-align: center;
            border-radius: 3px;
            position: relative;
            z-index: 1;
        }

        /* ==================== BODY TEXT ==================== */
        .body-text {
            font-size: 12.5px;
            text-align: justify;
            line-height: 1.9;
            margin: 10px 0;
            position: relative;
            z-index: 1;
        }

        /* ==================== INFO TABLE ==================== */
        .info-table {
            width: 100%;
            margin: 10px 0;
            border-collapse: collapse;
            position: relative;
            z-index: 1;
        }

        .info-table td {
            padding: 4px 8px;
            vertical-align: top;
            font-size: 12.5px;
        }

        .info-table td:first-child {
            width: 32%;
            font-weight: bold;
            color: #333;
        }

        /* ==================== QR SECTION ==================== */
        .qr-section {
            margin-top: 12px;
            text-align: center;
            padding-top: 8px;
            border-top: 1px dashed #999;
            position: relative;
            z-index: 1;
        }

        .qr-box {
            width: 95px;
            height: 95px;
            display: inline-block;
            padding: 3px;
            background: white;
            border: 1px solid #ddd;
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
            font-size: 9px;
            color: #666;
            margin: 3px 0 0 0;
        }

        .verification-code {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            color: #0a4d8c;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        /* ==================== SIGNATURE ==================== */
        .footer-sign {
            width: 100%;
            margin-top: 25px;
            position: relative;
            z-index: 1;
        }

        .footer-sign td {
            text-align: center;
            width: 50%;
            padding: 0 15px;
            vertical-align: bottom;
        }

        .sign-line {
            border-top: 1.5px solid #000;
            padding-top: 4px;
            margin-top: 40px;
            font-size: 11px;
            line-height: 1.5;
        }

        .sign-line strong {
            color: #0a4d8c;
        }

        /* ==================== FOOTER ==================== */
        .cert-footer {
            text-align: center;
            font-size: 9px;
            color: #888;
            margin-top: 15px;
            padding-top: 6px;
            border-top: 1px dashed #ddd;
            position: relative;
            z-index: 1;
        }

        /* ==================== PRINT MEDIA ==================== */
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
        <div class="watermark"><?php echo e($union->name_bn ?? 'ইউনিয়ন পরিষদ'); ?></div>

        <div class="content">

            
            <div class="header">
                <?php if($union?->logo && file_exists(storage_path('app/public/' . $union->logo))): ?>
                    <img src="<?php echo e(storage_path('app/public/' . $union->logo)); ?>" class="logo" alt="Logo">
                <?php endif; ?>
                <div class="union-name"><?php echo e($union->name_bn ?? 'ইউনিয়ন পরিষদ'); ?></div>
                <div class="union-address">
                    <?php echo e($union->upazila_bn ?? ''); ?>

                    <?php if($union?->district_bn): ?>
                        , <?php echo e($union->district_bn); ?>

                    <?php endif; ?>
                    <?php if($union?->post_code): ?>
                        - <?php echo e($union->post_code); ?>

                    <?php endif; ?>
                    <?php if($union?->phone): ?>
                        <br>ফোন: <?php echo e($union->phone); ?>

                    <?php endif; ?>
                </div>
            </div>

            
            <div class="cert-title"><?php echo e($type->name_bn ?? 'সার্টিফিকেট'); ?></div>

            
            <div class="cert-no">
                সার্টিফিকেট নম্বর: <?php echo e($certificate->certificate_no ?? '-'); ?>

                &nbsp;|&nbsp;
                ইস্যু তারিখ: <?php echo e(bangla_date($certificate->issue_date ?? now())); ?>

                <?php if($certificate?->expiry_date): ?>
                    &nbsp;|&nbsp;
                    মেয়াদ শেষ: <?php echo e(bangla_date($certificate->expiry_date)); ?>

                <?php endif; ?>
            </div>

            
            <div class="body-text">
                এই মর্মে প্রত্যয়ন করা যাইতেছে যে,
            </div>

            <table class="info-table">
                <tr>
                    <td>নাম:</td>
                    <td><strong><?php echo e($application->applicant_name_bn); ?></strong></td>
                </tr>
                <?php if($application->applicant_father_name): ?>
                    <tr>
                        <td>পিতার নাম:</td>
                        <td><?php echo e($application->applicant_father_name); ?></td>
                    </tr>
                <?php endif; ?>
                <?php if($application->applicant_mother_name): ?>
                    <tr>
                        <td>মাতার নাম:</td>
                        <td><?php echo e($application->applicant_mother_name); ?></td>
                    </tr>
                <?php endif; ?>
                <?php if($application->applicant_nid): ?>
                    <tr>
                        <td>জাতীয় পরিচয়পত্র নম্বর:</td>
                        <td><?php echo e($application->applicant_nid); ?></td>
                    </tr>
                <?php endif; ?>
                <?php if($application->village): ?>
                    <tr>
                        <td>গ্রাম:</td>
                        <td><?php echo e($application->village->name_bn); ?></td>
                    </tr>
                <?php endif; ?>
                <?php if($application->ward): ?>
                    <tr>
                        <td>ওয়ার্ড:</td>
                        <td><?php echo e($application->ward->name_bn); ?></td>
                    </tr>
                <?php endif; ?>
                <?php if($application->applicant_address): ?>
                    <tr>
                        <td>ঠিকানা:</td>
                        <td><?php echo e($application->applicant_address); ?></td>
                    </tr>
                <?php endif; ?>
            </table>

            <div class="body-text">
                উপরিউক্ত ব্যক্তি <?php echo e($union->name_bn ?? 'এই ইউনিয়ন পরিষদ'); ?>-এর একজন স্থায়ী বাসিন্দা এবং
                আমার জানামতে তাহার চরিত্র সন্তোষজনক। তিনি
                <strong><?php echo e($application->form_data['purpose'] ?? 'প্রয়োজনীয়'); ?></strong>
                উদ্দেশ্যে এই সার্টিফিকেটের জন্য আবেদন করিয়াছেন।
                <br><br>
                এই সার্টিফিকেট
                <?php if($type->validity_days): ?>
                    <strong><?php echo e(bangla_number($type->validity_days)); ?> দিন</strong>
                <?php else: ?>
                    <strong>৯০ দিন</strong>
                <?php endif; ?>
                পর্যন্ত বৈধ থাকবে।
            </div>

            
            <?php if(isset($qrSvg) && $qrSvg): ?>
                <div class="qr-section">
                    <div class="qr-box">
                        <?php echo $qrSvg; ?>

                    </div>
                    <p>QR কোড স্ক্যান করে সনদটি অনলাইনে যাচাই করুন</p>
                    <p class="verification-code"><?php echo e($certificate->verification_code ?? ''); ?></p>
                </div>
            <?php elseif(isset($qrCode) && $qrCode): ?>
                <div class="qr-section">
                    <div class="qr-box">
                        <img src="<?php echo e($qrCode); ?>" alt="QR Code">
                    </div>
                    <p>QR কোড স্ক্যান করে সনদটি অনলাইনে যাচাই করুন</p>
                    <p class="verification-code"><?php echo e($certificate->verification_code ?? ''); ?></p>
                </div>
            <?php endif; ?>

            
            <table class="footer-sign">
                <tr>
                    <td>
                        <div class="sign-line">
                            <?php echo e($application->ward->member_name_bn ?? 'ওয়ার্ড সদস্য'); ?><br>
                            <small>ওয়ার্ড সদস্য</small><br>
                            <small><?php echo e($application->ward->name_bn ?? ''); ?></small>
                        </div>
                    </td>
                    <td>
                        <div class="sign-line">
                            <strong><?php echo e($union->chairman_name_bn ?? 'চেয়ারম্যান'); ?></strong><br>
                            <small>চেয়ারম্যান</small><br>
                            <small><?php echo e($union->name_bn ?? ''); ?></small>
                        </div>
                    </td>
                </tr>
            </table>

            
            <div class="cert-footer">
                ডিজিটালি তৈরি: <?php echo e(bangla_date($generatedAt)); ?> |
                ট্র্যাকিং: <?php echo e($application->tracking_no); ?>

            </div>

        </div>
    </div>
</body>

</html>
<?php /**PATH R:\xampp\htdocs\union-porishod\Modules/Certificate\resources/views/pdf/general.blade.php ENDPATH**/ ?>