<?php

namespace Database\Factories;

use App\Models\HourRule;
use Illuminate\Database\Eloquent\Factories\Factory;

class HourRuleFactory extends Factory
{
    protected $model = HourRule::class;

    public function definition()
    {
        return [
            'amount' => $this->faker->randomFloat(2, 5, 50),
            'type' => $this->faker->randomElement(['Add', 'Decrease']),
        ];
    }
}
