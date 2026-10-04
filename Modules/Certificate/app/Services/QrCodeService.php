<?php

namespace Modules\Certificate\Services;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QrCodeService
{
    /**
     * Generate QR code as base64 SVG (Imagick ছাড়াই কাজ করে)
     */
    public function generateBase64(string $content, int $size = 200): string
    {
        try {
            $svg = $this->generateSvg($content, $size);

            if (empty($svg)) {
                return '';
            }

            return 'data:image/svg+xml;base64,' . base64_encode($svg);
        } catch (\Throwable $e) {
            \Log::error('QR Code generateBase64 failed: ' . $e->getMessage());
            return '';
        }
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
     * Generate raw SVG string (for inline PDF rendering)
     */
    public function generateSvg(string $content, int $size = 200): string
    {
        try {
            $renderer = new ImageRenderer(
                new RendererStyle($size, 1),
                new SvgImageBackEnd()
            );

            $writer = new Writer($renderer);

            return $writer->writeString($content);
        } catch (\Throwable $e) {
            \Log::error('QR Code generateSvg failed: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Save QR code to storage as SVG
     */
    public function saveToStorage(string $content, string $path, int $size = 200): string
    {
        try {
            $svg = $this->generateSvg($content, $size);

            if (empty($svg)) {
                return '';
            }

            \Storage::disk('public')->put($path, $svg);

            return $path;
        } catch (\Throwable $e) {
            \Log::error('QR Code saveToStorage failed: ' . $e->getMessage());
            return '';
        }
    }
}
