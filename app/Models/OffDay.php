<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'description',
    ];

    protected $dates = [
        'date',
    ];

    public function offDayTypes()
    {
        return $this->belongsToMany(OffDayType::class, 'off_day_off_day_type');
    }
}
