<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffDayType extends Model
{
    use HasFactory;

    // Table name (if different from the default, optional)
    protected $table = 'off_day_types';

    // Fillable attributes
    protected $fillable = [
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    // Relationship with the OffDay model
    public function offDays()
    {
        return $this->belongsToMany(OffDay::class, 'off_day_off_day_type');
    }
}
