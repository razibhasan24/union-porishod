<?php

return [
    'module' => 'certificate',
    'label' => 'Certificate Management',
    'icon' => 'file-text',

    'permissions' => [
        'certificate_type' => [
            'label' => 'সার্টিফিকেট ধরন',
            'actions' => [
                'certificate_type.view'   => ['bn' => 'দেখা', 'en' => 'View'],
                'certificate_type.create' => ['bn' => 'তৈরি', 'en' => 'Create'],
                'certificate_type.edit'   => ['bn' => 'সম্পাদনা', 'en' => 'Edit'],
                'certificate_type.delete' => ['bn' => 'ডিলিট', 'en' => 'Delete'],
            ],
        ],
        'certificate_application' => [
            'label' => 'সার্টিফিকেট আবেদন',
            'actions' => [
                'certificate_application.view'    => ['bn' => 'দেখা', 'en' => 'View'],
                'certificate_application.create'  => ['bn' => 'তৈরি', 'en' => 'Create'],
                'certificate_application.edit'    => ['bn' => 'সম্পাদনা', 'en' => 'Edit'],
                'certificate_application.approve' => ['bn' => 'অনুমোদন', 'en' => 'Approve'],
                'certificate_application.reject'  => ['bn' => 'বাতিল', 'en' => 'Reject'],
            ],
        ],
        'certificate' => [
            'label' => 'সার্টিফিকেট ইস্যু',
            'actions' => [
                'certificate.issue'   => ['bn' => 'ইস্যু', 'en' => 'Issue'],
                'certificate.reprint' => ['bn' => 'পুনঃপ্রিন্ট', 'en' => 'Reprint'],
                'certificate.cancel'  => ['bn' => 'বাতিল', 'en' => 'Cancel'],
                'certificate.print'   => ['bn' => 'প্রিন্ট', 'en' => 'Print'],
            ],
        ],
    ],
];