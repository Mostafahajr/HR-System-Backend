<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOffDayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $offDayId = $this->route('off_day'); // get off_day_id from route
        return [
            'date' => 'required|date|after:today|unique:off_days,date,' . $offDayId,
            'description' => 'nullable|string',
        ];
    }
}