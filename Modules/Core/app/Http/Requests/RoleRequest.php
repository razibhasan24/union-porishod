<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('role')?->id ?? null;

        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('roles', 'name')->ignore($id)],
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
            'modules' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'রোলের নাম আবশ্যক।',
            'name.unique' => 'এই নামে রোল আগেই আছে।',
        ];
    }
}