<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_time',
        'arrival_time',
        'leave_time',
        'date',
        'employee_id',
    ];

    // Relationship to employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
