<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('ward')?->id ?? null;
        $unionId = $this->input('union_id');

        return [
            'union_id' => 'required|exists:unions,id',
            'ward_no' => [
                'required', 'integer', 'min:1', 'max:20',
                Rule::unique('wards')->where(function ($q) use ($unionId) {
                    return $q->where('union_id', $unionId);
                })->ignore($id),
            ],
            'name_bn' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'member_name_bn' => 'nullable|string|max:255',
            'member_name_en' => 'nullable|string|max:255',
            'member_phone' => 'nullable|string|max:20',
            'member_photo' => 'nullable|image|max:2048',
            'member_signature' => 'nullable|image|max:1024',
            'female_member_name_bn' => 'nullable|string|max:255',
            'female_member_phone' => 'nullable|string|max:20',
            'total_villages' => 'nullable|integer|min:0',
            'total_population' => 'nullable|integer|min:0',
            'total_voters' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'ward_no.required' => 'ওয়ার্ড নম্বর আবশ্যক।',
            'ward_no.unique' => 'এই ওয়ার্ড নম্বর এই ইউনিয়নে আগেই আছে।',
            'union_id.required' => 'ইউনিয়ন নির্বাচন করুন।',
        ];
    }
}