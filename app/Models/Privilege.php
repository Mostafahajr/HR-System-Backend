<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    // Specify table name if it's different from the model name
    protected $table = 'privileges';

    // Define the fields that can be mass-assigned
    protected $fillable = ['page_name', 'operator'];

    /**
     * Define the relationship with the `GroupType` model
     * Many-to-Many relationship (privileges - group_types through group_privilege)
     */
    public function groupTypes()
    {
        return $this->belongsToMany(GroupType::class, 'group_privilege', 'privileges_id', 'group_type_id');
    }
}
