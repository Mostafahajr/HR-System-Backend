<?php
// App\Http\Requests\StoreHourRuleRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHourRuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => 'required|in:increase,deduction',
            'hour_amount' => 'required|integer|min:1',
        ];
    }
}

