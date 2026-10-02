<?php

namespace Modules\Certificate\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    /**
     * Generate QR code as base64 PNG
     */
    public function generateBase64(string $content, int $size = 200): string
    {
        $png = QrCode::format('png')
            ->size($size)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($content);

        return 'data:image/png;base64,' . base64_encode($png);
    }

    /**
     * Generate QR code for certificate verification
     */
    public function generateForCertificate(string $verificationCode): string
    {
        $url = route('verify.certificate', ['code' => $verificationCode]);
        return $this->generateBase64($url);
    }

    /**
     * Save QR code to storage
     */
    public function saveToStorage(string $content, string $path, int $size = 200): string
    {
        $png = QrCode::format('png')
            ->size($size)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($content);

        \Storage::disk('public')->put($path, $png);

        return $path;
    }
}