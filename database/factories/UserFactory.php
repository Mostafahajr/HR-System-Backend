<?php

namespace Database\Factories;

use App\Models\GroupType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'username' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Default password for all users
            'remember_token' => Str::random(10),
            'group_type_id' => GroupType::inRandomOrder()->first()->id, // Assign an existing GroupType
        ];
    }
}
