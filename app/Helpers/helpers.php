<?php

if (!function_exists('bangla_number')) {
    function bangla_number($number)
    {
        $en = ['0','1','2','3','4','5','6','7','8','9'];
        $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        return str_replace($en, $bn, $number);
    }
}

if (!function_exists('bangla_date')) {
    function bangla_date($date, $format = 'd/m/Y')
    {
        if (!$date) return '';
        $date = $date instanceof \Carbon\Carbon ? $date : \Carbon\Carbon::parse($date);
        
        $months = [
            1 => 'জানুয়ারি', 2 => 'ফেব্রুয়ারি', 3 => 'মার্চ',
            4 => 'এপ্রিল', 5 => 'মে', 6 => 'জুন',
            7 => 'জুলাই', 8 => 'আগস্ট', 9 => 'সেপ্টেম্বর',
            10 => 'অক্টোবর', 11 => 'নভেম্বর', 12 => 'ডিসেম্বর',
        ];
        
        $day = bangla_number($date->format('d'));
        $month = $months[(int)$date->format('m')];
        $year = bangla_number($date->format('Y'));
        
        return "{$day} {$month} {$year}";
    }
}

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return \Modules\Setting\Services\SettingService::get($key, $default);
    }
}

if (!function_exists('current_union')) {
    function current_union()
    {
        if (auth()->check() && auth()->user()->union_id) {
            return \Modules\Core\Models\Union::find(auth()->user()->union_id);
        }
        return \Modules\Core\Models\Union::first();
    }
}

if (!function_exists('generate_tracking_no')) {
    function generate_tracking_no($prefix = 'APP')
    {
        $date = now()->format('Ymd');
        $random = strtoupper(\Str::random(6));
        return "{$prefix}-{$date}-{$random}";
    }
}