<?php

return [
    'default_gateway' => env('SMS_DRIVER', 'mock'),

    'gateways' => [
        'mock' => [
            'class' => \Modules\Setting\Services\Sms\MockGateway::class,
            'enabled' => true,
        ],
        'bulksmsbd' => [
            'class' => \Modules\Setting\Services\Sms\BulkSmsBdGateway::class,
            'enabled' => env('BULKSMSBD_ENABLED', false),
            'api_key' => env('BULKSMSBD_API_KEY'),
            'sender_id' => env('BULKSMSBD_SENDER_ID'),
            'base_url' => 'http://bulksmsbd.net/api/smsapi',
        ],
        'twilio' => [
            'class' => \Modules\Setting\Services\Sms\TwilioGateway::class,
            'enabled' => env('TWILIO_ENABLED', false),
            'sid' => env('TWILIO_SID'),
            'token' => env('TWILIO_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],
    ],
];