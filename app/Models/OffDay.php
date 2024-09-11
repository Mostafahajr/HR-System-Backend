<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffDay extends Model
{
    use HasFactory;

    // Fillable attributes
    protected $fillable = [
        'date',
        'description',
    ];

    // Relationship with OffDayType
    public function types()
    {
        return $this->belongsToMany(OffDayType::class, 'off_day_off_day_type');
    }

    // Relationship with VacationDay
    public function vacationDays()
    {
        return $this->hasMany(VacationDay::class);
    }
}
