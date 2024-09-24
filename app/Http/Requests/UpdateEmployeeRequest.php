<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; 

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Retrieve the employee ID from the route
        $employeeId = $this->route('id');
        return [
            'name' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|required|string|max:15',
            'gender' => 'sometimes|required|in:male,female,other',
            'DOB' => 'sometimes|required|date|before:today',
            'nationality' => 'sometimes|required|string|max:255',
            'salary' => 'sometimes|required|numeric|min:0',
            'date_of_contract' => 'sometimes|required|date|after_or_equal:DOB',
            'department_id' => 'nullable|exists:departments,id',
            'national_id' => [
                'sometimes',
                'required',
                'string',
                'size:14', // Adjust size if necessary
                Rule::unique('employees', 'national_id')->ignore($employeeId),
            ],
            'arrival_time' => 'sometimes|required|date_format:H:i:s',
            'leave_time' => 'sometimes|required|date_format:H:i:s|after:arrival_time',
        ];
    }
}