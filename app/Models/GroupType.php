<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupType extends Model
{
    use HasFactory;

    // Specify table name if it's different from the model name
    protected $table = 'group_types';

    // Define the fields that can be mass-assigned
    protected $fillable = ['group_name'];

    /**
     * Define the relationship with the `Privilege` model
     * Many-to-Many relationship (group_types - privileges through group_privilege)
     */
    public function privileges()
    {
        return $this->belongsToMany(Privilege::class, 'group_privilege', 'group_type_id', 'privileges_id');
    }
}
