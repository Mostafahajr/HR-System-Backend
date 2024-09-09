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
        return [
            'attendance_time' => $this->faker->dateTimeBetween('-1 month ', 'now'),
            'arrival_time' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'leave_time' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'date' => $this->faker->date,
            'employee_id' => Employee::factory(),
        ];
    }
}
