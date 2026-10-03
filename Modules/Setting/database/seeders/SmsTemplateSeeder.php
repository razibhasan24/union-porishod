<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Setting\Models\SmsTemplate;

class SmsTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'key' => 'application_submitted',
                'name_bn' => 'আবেদন জমা',
                'body_bn' => 'প্রিয় {name}, আপনার {certificate_type} আবেদন জমা হয়েছে। Tracking: {tracking_no} — {union_name}',
                'variables' => ['name', 'certificate_type', 'tracking_no', 'union_name'],
            ],
            [
                'key' => 'application_paid',
                'name_bn' => 'পেমেন্ট সম্পন্ন',
                'body_bn' => 'প্রিয় {name}, আপনার আবেদন {tracking_no}-এর ৳{amount} পেমেন্ট সফল হয়েছে। {union_name}',
                'variables' => ['name', 'tracking_no', 'amount', 'union_name'],
            ],
            [
                'key' => 'application_sent_to_ward',
                'name_bn' => 'ওয়ার্ড সদস্যের কাছে পাঠানো',
                'body_bn' => 'প্রিয় {name}, আপনার আবেদন {tracking_no} যাচাইয়ের জন্য ওয়ার্ড সদস্যের কাছে পাঠানো হয়েছে। {union_name}',
                'variables' => ['name', 'tracking_no', 'union_name'],
            ],
            [
                'key' => 'application_ward_verified',
                'name_bn' => 'ওয়ার্ড সদস্য যাচাই করেছেন',
                'body_bn' => 'প্রিয় {name}, আপনার আবেদন {tracking_no} ওয়ার্ড সদস্য যাচাই করেছেন। এখন চেয়ারম্যানের অনুমোদনের অপেক্ষায়।',
                'variables' => ['name', 'tracking_no'],
            ],
            [
                'key' => 'application_ward_rejected',
                'name_bn' => 'ওয়ার্ড সদস্য বাতিল করেছেন',
                'body_bn' => 'প্রিয় {name}, আপনার আবেদন {tracking_no} বাতিল হয়েছে। কারণ: {remarks}',
                'variables' => ['name', 'tracking_no', 'remarks'],
            ],
            [
                'key' => 'application_sent_to_chairman',
                'name_bn' => 'চেয়ারম্যানের কাছে পাঠানো',
                'body_bn' => 'প্রিয় {name}, আপনার আবেদন {tracking_no} অনুমোদনের জন্য চেয়ারম্যানের কাছে পাঠানো হয়েছে।',
                'variables' => ['name', 'tracking_no'],
            ],
            [
                'key' => 'application_approved',
                'name_bn' => 'আবেদন অনুমোদিত',
                'body_bn' => 'প্রিয় {name}, অভিনন্দন! আপনার আবেদন {tracking_no} অনুমোদিত হয়েছে। সার্টিফিকেট শীঘ্রই প্রস্তুত হবে। {union_name}',
                'variables' => ['name', 'tracking_no', 'union_name'],
            ],
            [
                'key' => 'application_rejected',
                'name_bn' => 'আবেদন বাতিল',
                'body_bn' => 'প্রিয় {name}, আপনার আবেদন {tracking_no} বাতিল হয়েছে। কারণ: {remarks}',
                'variables' => ['name', 'tracking_no', 'remarks'],
            ],
            [
                'key' => 'application_hold',
                'name_bn' => 'আবেদন স্থগিত',
                'body_bn' => 'প্রিয় {name}, আপনার আবেদন {tracking_no} সাময়িকভাবে স্থগিত করা হয়েছে। কারণ: {remarks}',
                'variables' => ['name', 'tracking_no', 'remarks'],
            ],
            [
                'key' => 'application_print_ready',
                'name_bn' => 'প্রিন্টের জন্য প্রস্তুত',
                'body_bn' => 'প্রিয় {name}, আপনার সার্টিফিকেট {tracking_no} প্রিন্টের জন্য প্রস্তুত। এখন প্রিন্ট করতে পারবেন। {union_name}',
                'variables' => ['name', 'tracking_no', 'union_name'],
            ],
            [
                'key' => 'ward_member_new_application',
                'name_bn' => 'ওয়ার্ড সদস্যের কাছে নতুন আবেদন',
                'body_bn' => 'প্রিয় {name}, নতুন {certificate_type} আবেদন যাচাইয়ের জন্য এসেছে। Tracking: {tracking_no}, আবেদনকারী: {applicant_name}',
                'variables' => ['name', 'certificate_type', 'tracking_no', 'applicant_name'],
            ],
            [
                'key' => 'chairman_new_application',
                'name_bn' => 'চেয়ারম্যানের কাছে নতুন আবেদন',
                'body_bn' => 'প্রিয় {name}, নতুন {certificate_type} আবেদন অনুমোদনের জন্য এসেছে। Tracking: {tracking_no}, আবেদনকারী: {applicant_name}',
                'variables' => ['name', 'certificate_type', 'tracking_no', 'applicant_name'],
            ],
        ];

        foreach ($templates as $t) {
            SmsTemplate::updateOrCreate(['key' => $t['key']], $t);
        }

        $this->command->info('✅ ' . count($templates) . ' SMS templates created');
    }
}