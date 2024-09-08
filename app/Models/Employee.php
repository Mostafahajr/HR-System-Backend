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
    ];

    // Relationship to department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relationship to attendance
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Relationship to modify_salary
    public function modifySalaries()
    {
        return $this->hasMany(ModifySalary::class);
    }
}
