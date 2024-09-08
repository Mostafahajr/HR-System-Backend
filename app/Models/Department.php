<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['department_name'];

    // Relationship to employees
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
