<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $departmentId = $this->route('department'); // get department_id from route
        return [
            'department_name' => 'sometimes|string|unique:departments,department_name,' . $departmentId,
        ];
    }
}
