<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'gender' => $this->gender,
            'DOB' => $this->DOB,
            'nationality' => $this->nationality,
            'salary' => $this->salary,
            'date_of_contract' => $this->date_of_contract,
            'department' => $this->department ? [
                'id' => $this->department->id,
                'name' => $this->department->department_name,
            ] : null,
            'national_id' => $this->national_id,
            'arrival_time' => $this->arrival_time,
            'leave_time' => $this->leave_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
