<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function onUpdate(){
        return [
            "attendance_time"=>['required'],
            "arrival_time"=>['required'],
            "leave_time"=>['required'],
            "date"=>['required'],
            "employee_id"=>['required']
        ];
    }

    protected function onCreate(){
        return [
            "attendance_time"=>['required'],
            "arrival_time"=>['required'],
            "leave_time"=>['required'],
            "date"=>['required'],
            "employee_id"=>['required']
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (request()->isMethod('put')) {
            # code...
            return $this->onUpdate();
        }else{
            return $this->onCreate();

        }
    }
}
