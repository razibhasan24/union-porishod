<?php

namespace Modules\Setting\Services\Sms\Gateways;

use Illuminate\Support\Facades\Http;
use Modules\Setting\Services\Sms\Contracts\SmsGatewayInterface;

class BulkSmsBdGateway implements SmsGatewayInterface
{
    public function send(string $mobile, string $message): array
    {
        $config = config('sms.gateways.bulksmsbd');

        $mobile = $this->normalizeMobile($mobile);

        try {
            $response = Http::timeout(15)->get($config['base_url'], [
                'api_key' => $config['api_key'],
                'type' => 'text',
                'number' => $mobile,
                'senderid' => $config['sender_id'],
                'message' => $message,
            ]);

            $body = $response->body();

            // BulkSMSBD returns "202" or similar on success
            $success = $response->successful() && !str_contains(strtolower($body), 'error');

            return [
                'success' => $success,
                'reference_id' => 'BULK-' . time() . '-' . rand(100, 999),
                'response' => $body,
                'error' => $success ? null : $body,
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'reference_id' => null,
                'response' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function getName(): string
    {
        return 'bulksmsbd';
    }

    protected function normalizeMobile(string $mobile): string
    {
        // 01XXXXXXXXX → 8801XXXXXXXXX
        $mobile = preg_replace('/\D/', '', $mobile);

        if (str_starts_with($mobile, '01')) {
            $mobile = '88' . $mobile;
        }

        if (str_starts_with($mobile, '1') && strlen($mobile) === 10) {
            $mobile = '880' . $mobile;
        }

        return $mobile;
    }
}