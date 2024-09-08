<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'type', // e.g., public holiday, weekend
        'description',
        'weekend',
        'day',
    ];
}
