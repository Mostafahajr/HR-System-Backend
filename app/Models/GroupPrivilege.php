<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupPrivilege extends Model
{
    use HasFactory;

    // Specify table name since it's not the plural of the model name
    protected $table = 'group_privilege';

    // Define mass-assignable fields
    protected $fillable = ['group_type_id', 'privilege_id'];

    // Define relationship to GroupType
    public function groupType()
    {
        return $this->belongsTo(GroupType::class);
    }

    // Define relationship to Privilege
    public function privilege()
    {
        return $this->belongsTo(Privilege::class);
    }
}
