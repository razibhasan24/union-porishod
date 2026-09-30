<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('union')?->id ?? null;

        return [
            'name_bn' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:unions,code,' . $id,
            'upazila_bn' => 'nullable|string|max:255',
            'upazila_en' => 'nullable|string|max:255',
            'district_bn' => 'nullable|string|max:255',
            'district_en' => 'nullable|string|max:255',
            'division_bn' => 'nullable|string|max:255',
            'division_en' => 'nullable|string|max:255',
            'post_office' => 'nullable|string|max:255',
            'post_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:512',
            'banner' => 'nullable|image|max:4096',
            'letterhead' => 'nullable|image|max:4096',
            'chairman_name_bn' => 'nullable|string|max:255',
            'chairman_name_en' => 'nullable|string|max:255',
            'chairman_phone' => 'nullable|string|max:20',
            'chairman_email' => 'nullable|email|max:255',
            'chairman_photo' => 'nullable|image|max:2048',
            'chairman_signature' => 'nullable|image|max:1024',
            'chairman_from_date' => 'nullable|date',
            'chairman_to_date' => 'nullable|date|after_or_equal:chairman_from_date',
            'secretary_name_bn' => 'nullable|string|max:255',
            'secretary_name_en' => 'nullable|string|max:255',
            'secretary_phone' => 'nullable|string|max:20',
            'secretary_photo' => 'nullable|image|max:2048',
            'total_wards' => 'nullable|integer|min:1|max:20',
            'total_villages' => 'nullable|integer|min:0',
            'total_population' => 'nullable|integer|min:0',
            'total_voters' => 'nullable|integer|min:0',
            'total_area' => 'nullable|numeric|min:0',
            'established_date' => 'nullable|date',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name_bn.required' => 'ইউনিয়নের নাম (বাংলা) আবশ্যক।',
            'name_en.required' => 'ইউনিয়নের নাম (ইংরেজি) আবশ্যক।',
            'code.required' => 'ইউনিয়ন কোড আবশ্যক।',
            'code.unique' => 'এই কোড আগেই ব্যবহৃত হয়েছে।',
            'email.email' => 'সঠিক ইমেইল দিন।',
            'chairman_to_date.after_or_equal' => 'শেষ তারিখ শুরুর তারিখের পর হতে হবে।',
        ];
    }
}