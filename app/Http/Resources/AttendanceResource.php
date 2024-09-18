<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'arrival_time' => $this->arrival_time,
            'leave_time' => $this->leave_time,
            'date' => $this->date,
            'employee_id' => $this->employee->id,
            'employee_name' => $this->employee->name,
            'department' => $this->employee->department->department_name,
        ];
    }
}