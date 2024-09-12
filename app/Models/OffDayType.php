<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffDayType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function offDays()
    {
        return $this->belongsToMany(OffDay::class, 'off_day_off_day_type');
    }
}
