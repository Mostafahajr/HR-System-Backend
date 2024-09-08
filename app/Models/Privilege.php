<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'operation', // Create, Read, Update, Delete
        'group_type_id',
    ];

    // Relationship to group type
    public function groupType()
    {
        return $this->belongsTo(GroupType::class);
    }
}
