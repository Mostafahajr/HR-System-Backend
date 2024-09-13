<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'gender',
        'DOB',
        'nationality',
        'salary',
        'date_of_contract',
        'department_id',
        'national_id',
        'arrival_time',
        'leave_time',
        'department_id'
    ];

    protected $casts = [
        'DOB' => 'date',
        'arrival_time' => 'datetime',
        'leave_time' => 'datetime',
        'date_of_contract' => 'date',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function salaryModifications()
    {
        return $this->hasMany(ModifySalary::class);
    }
}
