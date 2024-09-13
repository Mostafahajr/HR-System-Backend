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
    //The date field is cast to a date type, which will automatically convert it to a Carbon instance when accessed.
    protected $casts = [
        'date' => 'date',
    ];
    public function offDayTypes()
    {
        return $this->belongsToMany(OffDayType::class, 'off_day_off_day_type');
    }
}
