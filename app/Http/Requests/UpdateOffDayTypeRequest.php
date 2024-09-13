<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOffDayTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $offDayTypeId = $this->route('off_day_type'); // get off_day_type_id from route
        return [
            'name' => 'required|string|unique:off_day_types,name,' . $offDayTypeId,
            'description' => 'nullable|string',
        ];
    }
}
