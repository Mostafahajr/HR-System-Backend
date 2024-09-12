<?php

namespace App\Models;

use App\Models\Privilege;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class GroupType extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function privileges()
    {
        return $this->belongsToMany(Privilege::class, 'group_privilege')->withTimestamps();
    }
}