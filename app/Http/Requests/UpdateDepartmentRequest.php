<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $departmentId = $this->route('id');
        return [
            'department_name' => [
                'sometimes',
                'string',
                Rule::unique('departments', 'department_name')->ignore($departmentId, 'id'),
            ],
        ];
    }
}
