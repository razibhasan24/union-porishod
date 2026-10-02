<?php

namespace Modules\Certificate\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificateApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'certificate_type_id' => 'required|exists:certificate_types,id',
            'ward_id' => 'required|exists:wards,id',
            'village_id' => 'nullable|exists:villages,id',
            'purpose' => 'nullable|string|max:500',
            'payment_method' => 'required|in:online,cash',
            'documents.*' => 'nullable|file|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'certificate_type_id.required' => 'সার্টিফিকেটের ধরন নির্বাচন করুন।',
            'ward_id.required' => 'ওয়ার্ড নির্বাচন করুন।',
            'payment_method.required' => 'পেমেন্ট পদ্ধতি নির্বাচন করুন।',
        ];
    }
}