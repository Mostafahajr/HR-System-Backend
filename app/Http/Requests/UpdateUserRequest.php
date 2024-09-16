<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('id');
        return [
            "name"=>['required','regex:/^[A-Za-z]{3,}(?:[ -][A-Za-z]{3,})*$/'],
            "username"=>['required','regex:/^[A-Za-z0-9]{3,}(?:[ -][A-Za-z0-9]{3,})*$/'],
            "email"=>['required','regex:/^\w+([\.-]?\w)+@\w+([\.]?\w)+(\.[a-zA-Z]{2,3})+$/'],
            "password"=>['required','regex:/^(?=.[A-Z])(?=.[a-z])(?=.\d)(?=.[@$!%?&])[A-Za-z\d@$!%?&]{8,}$/'],
            "group_type_id"=>['required']
        ];

    }
}
