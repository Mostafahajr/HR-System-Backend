<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupPrivilege extends Model
{
    use HasFactory;

    // Specify table name if it's different from the model name
    protected $table = 'group_privilege';

    // Define the fields that can be mass-assigned
    protected $fillable = ['group_type_id', 'privileges_id'];

    // You can also define relationships if necessary
    public function groupType()
    {
        return $this->belongsTo(GroupType::class);
    }

    public function privilege()
    {
        return $this->belongsTo(Privilege::class);
    }
}
