<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "attendance_time"=>$this->attendance_time,
            "arrival_time"=>$this->arrival_time,
            "leave_time"=>$this->leave_time,
            "date"=>$this->date,
            "employee_name"=>$this->employee->name,
            "department"=>$this->employee->department->department_name
        ];
    }
}
