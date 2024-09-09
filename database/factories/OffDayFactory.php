<?php

namespace Database\Factories;

use App\Models\OffDay;
use Illuminate\Database\Eloquent\Factories\Factory;

class OffDayFactory extends Factory
{
    protected $model = OffDay::class;

    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'type' => $this->faker->randomElement(['Public Holiday', 'Weekend']),
            'description' => $this->faker->optional()->sentence,
            'weekend' => $this->faker->boolean,
            'day' => $this->faker->optional()->dayOfWeek,
        ];
    }
}
