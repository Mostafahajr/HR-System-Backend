<?php

namespace Database\Factories;

use App\Models\Privilege;
use App\Models\GroupType;
use App\Models\GroupPrivilege;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrivilegeFactory extends Factory
{
    protected $model = Privilege::class;

    public function definition()
    {
        return [
            'page_name' => $this->faker->word, // Random page name
            'operation' => $this->faker->randomElement(['Create', 'Read', 'Update', 'Delete']), // Random operation type
            'group_type_id' => GroupType::factory(), // Create a new group type
            'group_privilege_id' => GroupPrivilege::factory(), // Create a new group privilege
        ];
    }
}
