<?php

namespace Modules\Certificate\Services;

use Modules\Certificate\Models\CertificateType;

class CertificateNumberService
{
    public function generate(CertificateType $type): string
    {
        return $type->generateNextNumber();
    }

    public function generateTrackingNo(string $prefix = 'CERT'): string
    {
        $date = now()->format('Ymd');
        $random = strtoupper(substr(md5(uniqid('', true)), 0, 6));
        return "{$prefix}-{$date}-{$random}";
    }

    public function generateVerificationCode(): string
    {
        return strtoupper(bin2hex(random_bytes(8)));
    }
}