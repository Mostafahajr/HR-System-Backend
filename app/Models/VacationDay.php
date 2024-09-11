<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationDay extends Model
{
    use HasFactory;

    // Fillable attributes
    protected $fillable = [
        'off_day_id',
        'vacation_date',
    ];

    // Relationship with OffDay
    public function offDay()
    {
        return $this->belongsTo(OffDay::class);
    }
}
