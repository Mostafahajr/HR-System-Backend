<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\OffDay;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        // Define the start date and the end date (35 days later)
        $startDate = Carbon::createFromDate(2024, 9, 1);
        $endDate = (clone $startDate)->addDays(34); // 35 days span

        // Get all employees
        $employees = Employee::all();

        // Fetch all off days within the 35-day range
        $offDays = OffDay::whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->pluck('date')
            ->toArray();

        // Loop through each day within the 35-day period
        $currentDate = clone $startDate;
        while ($currentDate->lte($endDate)) {
            // Skip the date if it is in the off_days table
            if (in_array($currentDate->toDateString(), $offDays)) {
                $currentDate->addDay();
                continue;
            }

            // Create attendance records for all employees on workdays
            foreach ($employees as $employee) {
                // Generate randomized arrival time between 08:00 AM and 10:00 AM
                $arrivalTime = Carbon::createFromTime(8, 0)->addMinutes(rand(0, 120)); // 0 to 120 minutes added

                // Generate randomized leave time between 05:00 PM and 08:00 PM
                $leaveTime = Carbon::createFromTime(17, 0)->addMinutes(rand(0, 180)); // 0 to 180 minutes added

                Attendance::create([
                    'arrival_time' => $arrivalTime, // Randomized arrival time
                    'leave_time' => $leaveTime, // Randomized leave time
                    'date' => $currentDate->toDateString(),
                    'employee_id' => $employee->id,
                ]);
            }

            // Move to the next day
            $currentDate->addDay();
        }
    }
}
