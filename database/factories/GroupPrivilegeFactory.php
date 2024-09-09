<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\GroupType;
use App\Models\Privilege;

class GroupPrivilegeFactory extends Factory
{
    protected $model = \App\Models\GroupPrivilege::class;

    public function definition()
    {
        return [
            'group_type_id' => GroupType::factory(),
            'privileges_id' => Privilege::factory(),
        ];
    }
}
