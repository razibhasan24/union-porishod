<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('user')?->id ?? null;

        $rules = [
            'name' => 'required|string|max:255',
            'name_bn' => 'nullable|string|max:255',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($id)],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($id)],
            'nid' => 'nullable|string|max:30',
            'photo' => 'nullable|image|max:2048',
            'union_id' => 'nullable|exists:unions,id',
            'ward_id' => 'nullable|exists:wards,id',
            'village_id' => 'nullable|exists:villages,id',
            'user_type' => 'required|string',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
            'is_active' => 'boolean',
            'locale' => 'nullable|string|in:bn,en',
        ];

        if ($id) {
            $rules['password'] = 'nullable|string|min:6|confirmed';
        } else {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'নাম আবশ্যক।',
            'phone.unique' => 'এই মোবাইল নম্বর আগেই ব্যবহৃত।',
            'email.unique' => 'এই ইমেইল আগেই ব্যবহৃত।',
            'password.required' => 'পাসওয়ার্ড আবশ্যক।',
            'password.confirmed' => 'পাসওয়ার্ড মিলছে না।',
            'password.min' => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষর হতে হবে।',
        ];
    }
}