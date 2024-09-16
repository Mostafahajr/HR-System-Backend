<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'operation',
    ];

    /**
     * Define the many-to-many relationship between Privileges and GroupTypes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groupTypes()
    {
        return $this->belongsToMany(GroupType::class, 'group_privilege')->withTimestamps();
    }
}
