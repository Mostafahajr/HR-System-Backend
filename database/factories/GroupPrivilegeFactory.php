<?php

use App\Models\Privilege;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrivilegeFactory extends Factory
{
    protected $model = Privilege::class;

    public function definition()
    {
        return [
            'page_name' => $this->faker->word,
            'operation' => $this->faker->randomElement(['create', 'read', 'update', 'delete']),
        ];
    }
}
