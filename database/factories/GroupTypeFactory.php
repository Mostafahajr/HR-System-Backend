<?php

namespace Database\Factories;

use App\Models\GroupType;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupTypeFactory extends Factory
{
    protected $model = GroupType::class;

    public function definition()
    {
        return [
            'group_name' => $this->faker->word,
        ];
    }
}
