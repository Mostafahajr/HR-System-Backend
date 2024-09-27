<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            "name" => ['required', 'min:3', 'max:40', 'regex:/^[A-Za-z ]{3,}$/'],
            "username" => ['required', 'min:3', 'max:20', 'regex:/^[A-Za-z0-9 (.|*|&|^|%|@)]{3,}$/'],
            "email" => ['required', 'email'],
            'password' => ['regex:/^[A-Za-z0-9(@|#|$|%*)]{8,}$/'],
            "group_type_id" => ['required']
        ];
    }
}
