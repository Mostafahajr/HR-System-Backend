<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVacationDayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'weekend_day' => 'required|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
        ];
    }
}
