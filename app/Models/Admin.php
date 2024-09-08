<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'group_type_id',
    ];

    // Relationship to group type
    public function groupType()
    {
        return $this->belongsTo(GroupType::class);
    }
}
