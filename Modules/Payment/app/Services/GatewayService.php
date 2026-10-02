<?php

namespace Modules\Payment\Services;

/**
 * Mock Gateway Service
 * Later replace with actual bKash/Nagad API
 */
class GatewayService
{
    public function getAvailableGateways(): array
    {
        return [
            'bkash' => [
                'name' => 'বিকাশ',
                'icon' => 'phone',
                'color' => '#e2136e',
                'enabled' => config('payment.gateways.bkash.enabled', true),
            ],
            'nagad' => [
                'name' => 'নগদ',
                'icon' => 'phone',
                'color' => '#f6921e',
                'enabled' => config('payment.gateways.nagad.enabled', true),
            ],
            'rocket' => [
                'name' => 'রকেট',
                'icon' => 'phone',
                'color' => '#8c3494',
                'enabled' => config('payment.gateways.rocket.enabled', false),
            ],
        ];
    }

    /**
     * Mock payment processing
     * Replace with actual API call
     */
    public function processPayment(string $gateway, array $data): array
    {
        // MOCK: Always succeed for now
        return [
            'success' => true,
            'transaction_id' => strtoupper($gateway) . '-' . date('YmdHis') . rand(100, 999),
            'amount' => $data['amount'],
            'message' => 'Payment successful (mock)',
        ];
    }
}