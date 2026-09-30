<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VillageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'union_id' => 'required|exists:unions,id',
            'ward_id' => 'required|exists:wards,id',
            'name_bn' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:50',
            'post_office' => 'nullable|string|max:255',
            'post_code' => 'nullable|string|max:10',
            'population' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ];
    }
}