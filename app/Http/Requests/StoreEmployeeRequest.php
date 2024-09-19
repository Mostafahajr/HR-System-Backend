<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreEmployeeRequest extends FormRequest
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
        return [
            'name' => 'required|string|min:3|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'gender' => 'required|in:male,female',
            'DOB' => 'required|date|before_or_equal:' . Carbon::now()->subYears(20)->format('Y-m-d'),
            'nationality' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'date_of_contract' => 'required|date|after_or_equal:2008-01-01',
            'department_id' => 'nullable|exists:departments,id',
            'national_id' => 'required|string|max:14|unique:employees,national_id',
            'arrival_time' => 'sometimes|required|date_format:H:i:s',
            'leave_time' => 'sometimes|required|date_format:H:i:s|after:arrival_time',
        ];
    }
}
