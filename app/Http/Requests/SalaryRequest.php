<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaryRequest extends FormRequest
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
        'employee_id' => 'nullable|exists:employees,id',
        'year' => 'required|integer|digits:4',
        'month' => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12'
    ];
}
}
