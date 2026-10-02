<?php

return [
    'name' => 'Payment',

    'gateways' => [
        'bkash' => [
            'enabled' => env('BKASH_ENABLED', true),
            'sandbox' => env('BKASH_SANDBOX', true),
            'app_key' => env('BKASH_APP_KEY'),
            'app_secret' => env('BKASH_APP_SECRET'),
            'username' => env('BKASH_USERNAME'),
            'password' => env('BKASH_PASSWORD'),
        ],
        'nagad' => [
            'enabled' => env('NAGAD_ENABLED', true),
            'sandbox' => env('NAGAD_SANDBOX', true),
            'merchant_id' => env('NAGAD_MERCHANT_ID'),
            'merchant_number' => env('NAGAD_MERCHANT_NUMBER'),
        ],
        'rocket' => [
            'enabled' => env('ROCKET_ENABLED', false),
        ],
    ],

    'receipt' => [
        'prefix' => 'RCP',
        'padding' => 4,
    ],
];