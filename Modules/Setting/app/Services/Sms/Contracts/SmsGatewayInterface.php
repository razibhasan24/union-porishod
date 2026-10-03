<?php

namespace Modules\Setting\Services\Sms\Contracts;

interface SmsGatewayInterface
{
    /**
     * Send SMS
     *
     * @return array ['success' => bool, 'reference_id' => string|null, 'response' => array|string, 'error' => string|null]
     */
    public function send(string $mobile, string $message): array;

    public function getName(): string;
}