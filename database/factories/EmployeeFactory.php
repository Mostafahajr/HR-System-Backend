<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'DOB' => $this->faker->date,
            'nationality' => $this->faker->country,
            'salary' => $this->faker->numberBetween(30000, 100000),
            'date_of_contract' => $this->faker->date,
            'department_id' => Department::factory(), // Creates a new Department record
        ];
    }
}
