<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModifySalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'type', // Add or Decrease
        'date',
        'employee_id',
    ];

    // Relationship to employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
