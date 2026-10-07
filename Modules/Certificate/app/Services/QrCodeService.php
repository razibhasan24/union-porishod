<?php

namespace Modules\Certificate\Services;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QrCodeService
{
    /**
     * Generate QR code as base64 PNG.
     */
    public function generateBase64(string $content, int $size = 200): string
    {
        try {
            $png = $this->generatePng($content, $size);

            if (empty($png)) {
                return '';
            }

            return 'data:image/png;base64,' . base64_encode($png);
        } catch (\Throwable $e) {
            \Log::error('QR Code generateBase64 failed: ' . $e->getMessage());

            return '';
        }
    }

    /**
     * Generate QR code for certificate verification.
     */
    public function generateForCertificate(string $verificationCode): string
    {
        $url = route('verify.certificate', [
            'code' => $verificationCode,
        ]);

        return $this->generateBase64($url);
    }

    /**
     * Generate raw PNG binary.
     */
    public function generatePng(string $content, int $size = 200): string
    {
        try {
            $renderer = new ImageRenderer(
                new RendererStyle($size, 1),
                new ImagickImageBackEnd()
            );

            $writer = new Writer($renderer);

            return $writer->writeString($content);
        } catch (\Throwable $e) {
            \Log::error('QR Code generatePng failed: ' . $e->getMessage());

            return '';
        }
    }

    /**
     * Save QR code to storage as PNG.
     */
    public function saveToStorage(
        string $content,
        string $path,
        int $size = 200
    ): string {
        try {
            $png = $this->generatePng($content, $size);

            if (empty($png)) {
                return '';
            }

            \Storage::disk('public')->put($path, $png);

            return $path;
        } catch (\Throwable $e) {
            \Log::error('QR Code saveToStorage failed: ' . $e->getMessage());

            return '';
        }
    }
}
