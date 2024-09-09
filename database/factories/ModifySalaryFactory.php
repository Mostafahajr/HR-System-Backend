<?php

namespace Database\Factories;

use App\Models\ModifySalary;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModifySalaryFactory extends Factory
{
    protected $model = ModifySalary::class;

    public function definition()
    {
        return [
            'amount' => $this->faker->randomFloat(2, 100, 2000),
            'type' => $this->faker->randomElement(['Add', 'Decrease']),
            'date' => $this->faker->date,
            'employee_id' => Employee::factory(),
        ];
    }
}
