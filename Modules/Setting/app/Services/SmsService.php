<?php

namespace Modules\Setting\Services;

use Modules\Setting\Models\SmsLog;
use Modules\Setting\Models\SmsTemplate;
use Modules\Setting\Services\Sms\Contracts\SmsGatewayInterface;

class SmsService
{
    protected SmsGatewayInterface $gateway;

    public function __construct()
    {
        $this->gateway = $this->resolveGateway();
    }

    /**
     * Send raw SMS
     */
    public function send(
        string $mobile,
        string $message,
        ?string $templateKey = null,
        $related = null,
        ?int $userId = null
    ): SmsLog {
        $log = SmsLog::create([
            'mobile' => $mobile,
            'message' => $message,
            'template_key' => $templateKey,
            'gateway' => $this->gateway->getName(),
            'status' => 'pending',
            'user_id' => $userId,
            'related_type' => $related ? get_class($related) : null,
            'related_id' => $related?->id,
        ]);

        try {
            $result = $this->gateway->send($mobile, $message);

            $log->update([
                'status' => $result['success'] ? 'sent' : 'failed',
                'reference_id' => $result['reference_id'] ?? null,
                'response' => is_array($result['response'] ?? null)
                    ? json_encode($result['response'])
                    : ($result['response'] ?? null),
                'error_message' => $result['error'] ?? null,
                'sent_at' => $result['success'] ? now() : null,
            ]);
        } catch (\Throwable $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }

        return $log->fresh();
    }

    /**
     * Send SMS from template
     */
    public function sendFromTemplate(
        string $templateKey,
        string $mobile,
        array $data = [],
        $related = null,
        ?int $userId = null
    ): ?SmsLog {
        $template = SmsTemplate::findByKey($templateKey);

        if (!$template) {
            \Log::warning("SMS Template not found: {$templateKey}");
            return null;
        }

        $message = $template->render($data);

        return $this->send($mobile, $message, $templateKey, $related, $userId);
    }

    /**
     * Resolve gateway from config
     */
    protected function resolveGateway(): SmsGatewayInterface
    {
        $defaultName = config('sms.default_gateway', 'mock');
        $gateways = config('sms.gateways', []);

        $config = $gateways[$defaultName] ?? $gateways['mock'];

        if (!empty($config['enabled']) && isset($config['class'])) {
            $class = $config['class'];
            if (class_exists($class)) {
                return new $class();
            }
        }

        return new \Modules\Setting\Services\Sms\Gateways\MockGateway();
    }
}