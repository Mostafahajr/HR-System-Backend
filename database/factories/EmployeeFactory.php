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
        $minDOB = (new \DateTime())->modify('-20 years');
        $dob = $this->faker->dateTimeBetween('-100 years', $minDOB->format('Y-m-d'));

        $minDate = \DateTime::createFromFormat('m/d/Y', '09/01/2024');
        $dateOfContract = $this->faker->dateTimeBetween($minDate);

        $departmentId = Department::inRandomOrder()->first()->id;

        $currentDate = $this->faker->date;
        $arrivalTime = $currentDate . ' 09:00:00';
        $leaveTime = $currentDate . ' 17:00:00';

        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'DOB' => $dob->format('Y-m-d'),
            'nationality' => $this->faker->country,
            'national_id' => $this->faker->numberBetween(100000000, 999999999),
            'arrival_time' => $arrivalTime,
            'leave_time' => $leaveTime,
            'salary' => $this->faker->randomFloat(2, 10000, 25000),
            'date_of_contract' => $dateOfContract->format('Y-m-d'),
            'department_id' => $departmentId,
        ];
    }
}
