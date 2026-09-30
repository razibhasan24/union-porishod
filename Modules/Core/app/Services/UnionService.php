<?php

namespace Modules\Core\Services;

use Modules\Core\Models\Union;
use Illuminate\Support\Facades\DB;

class UnionService
{
    public function create(array $data): Union
    {
        return DB::transaction(function () use ($data) {
            $union = Union::create($data);

            // Create default wards based on total_wards
            for ($i = 1; $i <= ($data['total_wards'] ?? 9); $i++) {
                $union->wards()->create([
                    'ward_no' => $i,
                    'name_bn' => "ওয়ার্ড নং " . $this->toBanglaNumber($i),
                    'name_en' => "Ward No " . $i,
                ]);
            }

            return $union;
        });
    }

    public function update(Union $union, array $data): Union
    {
        return DB::transaction(function () use ($union, $data) {
            $union->update($data);
            return $union;
        });
    }

    protected function toBanglaNumber(int $n): string
    {
        $en = ['0','1','2','3','4','5','6','7','8','9'];
        $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        return str_replace($en, $bn, (string) $n);
    }
}