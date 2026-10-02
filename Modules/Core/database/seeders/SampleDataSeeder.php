<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Union;
use Modules\Core\Models\Village;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $union = Union::first();
        if (!$union) return;

        $villages = [
            ['ward' => 1, 'name_bn' => 'উত্তর পাড়া', 'name_en' => 'Uttar Para'],
            ['ward' => 1, 'name_bn' => 'দক্ষিণ পাড়া', 'name_en' => 'Dakshin Para'],
            ['ward' => 2, 'name_bn' => 'মধ্য পাড়া', 'name_en' => 'Moddho Para'],
            ['ward' => 2, 'name_bn' => 'পূর্ব পাড়া', 'name_en' => 'Purbo Para'],
            ['ward' => 3, 'name_bn' => 'পশ্চিম পাড়া', 'name_en' => 'Poschim Para'],
        ];

        foreach ($villages as $v) {
            $ward = $union->wards()->where('ward_no', $v['ward'])->first();
            if (!$ward) continue;

            Village::firstOrCreate(
                [
                    'union_id' => $union->id,
                    'ward_id' => $ward->id,
                    'name_bn' => $v['name_bn'],
                ],
                [
                    'name_en' => $v['name_en'],
                    'post_office' => 'ডেমো পোস্ট অফিস',
                    'post_code' => '1234',
                ]
            );
        }

        $this->command->info('✅ Sample villages created');
    }
}