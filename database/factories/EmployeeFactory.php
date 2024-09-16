<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        // Generate a random arrival time between 1:00 AM and 9:00 AM on the hour or half-hour
        $arrivalHour = $this->faker->numberBetween(1, 9);
        $arrivalMinute = $this->faker->randomElement([0, 30]);
        $arrivalTime = Carbon::create()->hour($arrivalHour)->minute($arrivalMinute)->second(0);

        // Ensure leave time is exactly 8 hours later
        $leaveTime = $arrivalTime->copy()->addHours(8);

        // Ensure leave time is within the allowed range
        if ($leaveTime->hour > 18 || ($leaveTime->hour == 18 && $leaveTime->minute > 0)) {
            $arrivalTime = Carbon::create()->hour(1)->minute(0)->second(0); // Reset arrival time if overflow
            $leaveTime = $arrivalTime->copy()->addHours(8);
        }

        // Generate other fields
        $minDOB = (new \DateTime())->modify('-20 years');
        $dob = $this->faker->dateTimeBetween('-100 years', $minDOB->format('Y-m-d'));

        $minDate = \DateTime::createFromFormat('m/d/Y', '09/01/2024');
        $dateOfContract = $this->faker->dateTimeBetween($minDate);

        $departmentId = Department::inRandomOrder()->first()->id;

        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'DOB' => $dob->format('Y-m-d'),
            'nationality' => $this->faker->country,
            'national_id' => $this->faker->numberBetween(100000000, 999999999),
            'arrival_time' => $arrivalTime->format('H:i:s'),
            'leave_time' => $leaveTime->format('H:i:s'),
            'salary' => $this->faker->randomFloat(2, 10000, 25000),
            'date_of_contract' => $dateOfContract->format('Y-m-d'),
            'department_id' => $departmentId,
        ];
    }
}
