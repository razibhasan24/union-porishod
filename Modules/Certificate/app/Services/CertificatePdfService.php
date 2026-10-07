<?php

namespace Modules\Certificate\Services;

namespace Modules\Certificate\Services;

use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
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

    $filename = 'certificate-' .
        ($application->issuedCertificate->certificate_no ?? $application->tracking_no) .
        '.pdf';

    $filename = str_replace(['/', '\\'], '-', $filename);

    return response(
        $pdf->Output($filename, 'S')
    )
    ->header('Content-Type', 'application/pdf')
    ->header(
        'Content-Disposition',
        'attachment; filename="' . $filename . '"'
    );
}

    /**
     * Stream PDF in browser (for print preview)
     */
   public function stream(CertificateApplication $application)
{
    $pdf = $this->build($application);

    return response(
        $pdf->Output('certificate.pdf', 'S')
    )
    ->header('Content-Type', 'application/pdf')
    ->header('Content-Disposition', 'inline; filename="certificate.pdf"');
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
        'union',
        'ward',
        'village',
        'applicant',
        'certificateType',
        'issuedCertificate',
    ]);

    $certificate = $application->issuedCertificate;

    // QR আপাতত বন্ধ রাখা হয়েছে
    $qrCode = null;

    $data = [
        'application' => $application,
        'certificate' => $certificate,
        'union' => $application->union,
        'ward' => $application->ward,
        'type' => $application->certificateType,
        'qrCode' => $qrCode,
        'generatedAt' => now(),
    ];

    /*
    |--------------------------------------------------------------------------
    | Certificate Template
    |--------------------------------------------------------------------------
    */

    $template = $this->getTemplate($application);

    $html = view($template, $data)->render();

    /*
    |--------------------------------------------------------------------------
    | mPDF Font Configuration
    |--------------------------------------------------------------------------
    */

    $defaultConfig = (new ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $fontData['solaimanlipi'] = [
        'R' => 'solaimanlipi_normal_094ca0febebd4422f31d39b58cbc6746.ttf',
        'B' => 'solaimanlipi_bold_094ca0febebd4422f31d39b58cbc6746.ttf',
    ];

    /*
    |--------------------------------------------------------------------------
    | mPDF
    |--------------------------------------------------------------------------
    */

    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'orientation' => 'P',

        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 8,
        'margin_bottom' => 8,

        'margin_header' => 0,
        'margin_footer' => 0,

        'default_font' => 'solaimanlipi',
        'default_font_size' => 11,

        'fontDir' => array_merge(
            $fontDirs,
            [
                storage_path('fonts'),
            ]
        ),

        'fontdata' => $fontData,

        'tempDir' => storage_path('app/mpdf'),
    ]);

    $mpdf->autoScriptToLang = true;
    $mpdf->autoLangToFont = false;

    $mpdf->SetDisplayMode('fullpage');

    /*
    |--------------------------------------------------------------------------
    | Write HTML
    |--------------------------------------------------------------------------
    */

    $html = '
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: solaimanlipi;">
    <h2>বাংলা পরীক্ষা</h2>
    <p>ইউনিয়ন পরিষদ</p>
    <p>সনদপত্র</p>
    <p>আবেদনকারীর নাম: মোঃ আব্দুর রহমান</p>
    <p>চেয়ারম্যান</p>
</body>
</html>
';

$mpdf->WriteHTML($html);

return $mpdf;


}

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