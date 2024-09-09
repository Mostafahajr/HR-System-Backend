<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\GroupType; // Ensure this model is imported
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'username' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // You can use Hash::make('password') if preferred
            'group_type_id' => GroupType::factory(), // Creates a new GroupType record
        ];
    }
}
