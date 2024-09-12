<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'weekend_day',
    ];
}

