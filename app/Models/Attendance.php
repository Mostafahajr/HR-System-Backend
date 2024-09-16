<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'arrival_time',
        'leave_time',
        'date',
        'employee_id',
    ];
    protected $casts = [
        'arrival_time' => 'datetime',
        'leave_time' => 'datetime',
        'date' => 'date',
    ];
    
    // Relationship to employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
