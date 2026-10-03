<?php

namespace Modules\Setting\Services\Sms\Gateways;

use Modules\Setting\Services\Sms\Contracts\SmsGatewayInterface;

class MockGateway implements SmsGatewayInterface
{
    public function send(string $mobile, string $message): array
    {
        // Simulation - logs the message
        \Log::info('[MOCK SMS] to=' . $mobile . ' msg=' . $message);

        return [
            'success' => true,
            'reference_id' => 'MOCK-' . strtoupper(substr(md5(uniqid('', true)), 0, 8)),
            'response' => ['mock' => true, 'message' => 'Mock SMS sent successfully'],
            'error' => null,
        ];
    }

    public function getName(): string
    {
        return 'mock';
    }
}