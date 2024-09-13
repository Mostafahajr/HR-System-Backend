<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVacationDayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'weekend_day' => [
                'required',
                'in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
                Rule::unique('vacation_days', 'weekend_day'),
            ],
        ];
    }
}
