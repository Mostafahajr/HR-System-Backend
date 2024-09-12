<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition()
    {
        // this is a default, use the seeder instead
        return [
            'arrival_time' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'leave_time' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'date' => $this->faker->date,
            'employee_id' => Employee::factory(),
        ];
    }
}
