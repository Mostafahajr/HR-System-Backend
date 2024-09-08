<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupType extends Model
{
    use HasFactory;

    protected $fillable = ['group_name'];

    // Relationship to users
    public function admin()
    {
        return $this->hasMany(Admin::class);
    }

    // Relationship to privileges
    public function privileges()
    {
        return $this->hasMany(Privilege::class);
    }
}
