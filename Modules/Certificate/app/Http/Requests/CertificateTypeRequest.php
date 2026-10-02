<?php

namespace Modules\Certificate\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificateTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('type')?->id ?? null;

        return [
            'union_id' => 'required|exists:unions,id',
            'name_bn' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description_bn' => 'nullable|string',
            'description_en' => 'nullable|string',
            'serial_prefix' => 'nullable|string|max:50',
            'serial_padding' => 'nullable|integer|min:1|max:10',
            'fee' => 'required|numeric|min:0',
            'renewal_fee' => 'nullable|numeric|min:0',
            'duplicate_fee' => 'nullable|numeric|min:0',
            'validity_days' => 'required|integer|min:1',
            'print_after_days' => 'required|integer|min:0',
            'is_warish' => 'boolean',
            'requires_heirs' => 'boolean',
            'requires_property' => 'boolean',
            'needs_ward_verification' => 'boolean',
            'needs_chairman_approval' => 'boolean',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name_bn.required' => 'নাম (বাংলা) আবশ্যক।',
            'name_en.required' => 'নাম (ইংরেজি) আবশ্যক।',
            'fee.required' => 'ফি আবশ্যক।',
            'validity_days.required' => 'বৈধতার সময় আবশ্যক।',
            'print_after_days.required' => 'প্রিন্ট সময় আবশ্যক।',
        ];
    }
}