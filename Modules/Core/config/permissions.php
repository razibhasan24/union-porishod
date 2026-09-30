<?php

return [
    'module' => 'core',
    'label' => 'Core Management',
    'icon' => 'settings',

    'permissions' => [

        'union' => [
            'label' => 'ইউনিয়ন ব্যবস্থাপনা',
            'actions' => [
                'union.view' => ['bn' => 'দেখা', 'en' => 'View'],
                'union.create' => ['bn' => 'তৈরি', 'en' => 'Create'],
                'union.edit' => ['bn' => 'সম্পাদনা', 'en' => 'Edit'],
                'union.delete' => ['bn' => 'ডিলিট', 'en' => 'Delete'],
            ],
        ],

        'ward' => [
            'label' => 'ওয়ার্ড ব্যবস্থাপনা',
            'actions' => [
                'ward.view' => ['bn' => 'দেখা', 'en' => 'View'],
                'ward.create' => ['bn' => 'তৈরি', 'en' => 'Create'],
                'ward.edit' => ['bn' => 'সম্পাদনা', 'en' => 'Edit'],
                'ward.delete' => ['bn' => 'ডিলিট', 'en' => 'Delete'],
            ],
        ],

        'village' => [
            'label' => 'গ্রাম ব্যবস্থাপনা',
            'actions' => [
                'village.view' => ['bn' => 'দেখা', 'en' => 'View'],
                'village.create' => ['bn' => 'তৈরি', 'en' => 'Create'],
                'village.edit' => ['bn' => 'সম্পাদনা', 'en' => 'Edit'],
                'village.delete' => ['bn' => 'ডিলিট', 'en' => 'Delete'],
            ],
        ],

        'user' => [
            'label' => 'ইউজার ব্যবস্থাপনা',
            'actions' => [
                'user.view' => ['bn' => 'দেখা', 'en' => 'View'],
                'user.create' => ['bn' => 'তৈরি', 'en' => 'Create'],
                'user.edit' => ['bn' => 'সম্পাদনা', 'en' => 'Edit'],
                'user.delete' => ['bn' => 'ডিলিট', 'en' => 'Delete'],
            ],
        ],

        'role' => [
            'label' => 'রোল ব্যবস্থাপনা',
            'actions' => [
                'role.view' => ['bn' => 'দেখা', 'en' => 'View'],
                'role.create' => ['bn' => 'তৈরি', 'en' => 'Create'],
                'role.edit' => ['bn' => 'সম্পাদনা', 'en' => 'Edit'],
                'role.delete' => ['bn' => 'ডিলিট', 'en' => 'Delete'],
            ],
        ],

        'permission' => [
            'label' => 'পারমিশন ব্যবস্থাপনা',
            'actions' => [
                'permission.view' => ['bn' => 'দেখা', 'en' => 'View'],
            ],
        ],

        'setting' => [
            'label' => 'সেটিংস',
            'actions' => [
                'setting.view' => ['bn' => 'দেখা', 'en' => 'View'],
                'setting.edit' => ['bn' => 'সম্পাদনা', 'en' => 'Edit'],
            ],
        ],

        'report' => [
            'label' => 'রিপোর্ট',
            'actions' => [
                'report.view' => ['bn' => 'দেখা', 'en' => 'View'],
                'report.export' => ['bn' => 'এক্সপোর্ট', 'en' => 'Export'],
            ],
        ],
    ],
];