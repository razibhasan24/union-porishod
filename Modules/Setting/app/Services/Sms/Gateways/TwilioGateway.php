<?php

namespace Modules\Setting\Services\Sms\Gateways;

use Modules\Setting\Services\Sms\Contracts\SmsGatewayInterface;

class TwilioGateway implements SmsGatewayInterface
{
    public function send(string $mobile, string $message): array
    {
        $config = config('sms.gateways.twilio');

        try {
            $sid = $config['sid'];
            $token = $config['token'];
            $from = $config['from'];

            $client = new \Twilio\Rest\Client($sid, $token);

            $mobile = $this->normalizeMobile($mobile);

            $msg = $client->messages->create($mobile, [
                'from' => $from,
                'body' => $message,
            ]);

            return [
                'success' => true,
                'reference_id' => $msg->sid ?? null,
                'response' => ['sid' => $msg->sid ?? null],
                'error' => null,
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
        return 'twilio';
    }

    protected function normalizeMobile(string $mobile): string
    {
        $mobile = preg_replace('/\D/', '', $mobile);

        if (str_starts_with($mobile, '01')) {
            return '+88' . $mobile;
        }

        if (str_starts_with($mobile, '880')) {
            return '+' . $mobile;
        }

        return '+' . $mobile;
    }
}