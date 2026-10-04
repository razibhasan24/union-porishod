<?php

namespace Modules\Certificate\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Modules\Certificate\Models\CertificateApplication;

class CertificatePdfService
{
    public function __construct(
        protected QrCodeService $qrService
    ) {}

    /**
     * Generate PDF and return as download response
     */
    public function download(CertificateApplication $application)
    {
        $pdf = $this->build($application);

        $filename = 'certificate-' . ($application->issuedCertificate->certificate_no ?? $application->tracking_no) . '.pdf';
        $filename = str_replace(['/', '\\'], '-', $filename);

        return $pdf->download($filename);
    }

    /**
     * Stream PDF in browser (for print preview)
     */
    public function stream(CertificateApplication $application)
    {
        $pdf = $this->build($application);
        return $pdf->stream('certificate.pdf');
    }

    /**
     * Save PDF to storage and return path
     */
    public function save(CertificateApplication $application): string
    {
        $pdf = $this->build($application);

        $filename = 'certificates/' . $application->id . '-' . time() . '.pdf';

        \Storage::disk('public')->put($filename, $pdf->output());

        return $filename;
    }

    /**
     * Build the PDF instance
     */

    protected function build(CertificateApplication $application)
{
    $application->load([
        'union', 'ward', 'village', 'applicant',
        'certificateType', 'issuedCertificate',
    ]);

    $certificate = $application->issuedCertificate;

    // Generate QR code (SVG)
    $qrCode = null;
    $qrSvg = null;
    if ($certificate && $certificate->verification_code) {
        $qrCode = $this->qrService->generateForCertificate($certificate->verification_code);
        $qrSvg = $this->qrService->generateSvg(
            route('verify.certificate', ['code' => $certificate->verification_code]),
            120
        );
    }

    $data = [
        'application' => $application,
        'certificate' => $certificate,
        'union' => $application->union,
        'ward' => $application->ward,
        'type' => $application->certificateType,
        'qrCode' => $qrCode,
        'qrSvg' => $qrSvg,
        'generatedAt' => now(),
    ];

    $template = $this->getTemplate($application);

    $pdf = Pdf::loadView($template, $data);
    $pdf->setPaper('A4', 'portrait');

    // ============ CRITICAL: FONT CONFIGURATION ============
  $pdf->setOptions([
    'isRemoteEnabled' => true,
    'isHtml5ParserEnabled' => true,
    'isFontSubsettingEnabled' => true,
    'defaultFont' => 'SolaimanLipi',              // ← এই নাম
    'fontDir' => storage_path('fonts'),
    'fontCache' => storage_path('fonts'),
    'tempDir' => storage_path('app'),
    'chroot' => [
        base_path(),
        storage_path('app/public'),
        storage_path('fonts'),
    ],
    'dpi' => 96,
]);

    return $pdf;
}


    // protected function build(CertificateApplication $application)
    // {
    //     $application->load([
    //         'union', 'ward', 'village', 'applicant',
    //         'certificateType', 'issuedCertificate',
    //     ]);

    //     $certificate = $application->issuedCertificate;

    //     // Generate QR code
    //     $qrCode = null;
    //     if ($certificate && $certificate->verification_code) {
    //         $qrCode = $this->qrService->generateForCertificate($certificate->verification_code);
    //     }

    //     $data = [
    //         'application' => $application,
    //         'certificate' => $certificate,
    //         'union' => $application->union,
    //         'ward' => $application->ward,
    //         'type' => $application->certificateType,
    //         'qrCode' => $qrCode,
    //         'generatedAt' => now(),
    //     ];

    //     // Pick template based on certificate type
    //     $template = $this->getTemplate($application);

    //     $pdf = Pdf::loadView($template, $data);
    //     $pdf->setPaper('A4', 'portrait');
    //     $pdf->setOptions([
    //         'isRemoteEnabled' => true,
    //         'isHtml5ParserEnabled' => true,
    //         'defaultFont' => 'DejaVu Sans',
    //     ]);

    //     return $pdf;
    // }

    /**
     * Choose template file
     */
    protected function getTemplate(CertificateApplication $application): string
    {
        $type = $application->certificateType;

        // Warish certificate gets special template
        if ($type && $type->is_warish) {
            return 'certificate::pdf.warish';
        }

        return 'certificate::pdf.general';
    }
}
