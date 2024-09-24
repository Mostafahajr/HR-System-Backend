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
        // Define the start date and the end date for August 2024
        $startDate = Carbon::createFromDate(2024, 7, 1);
        $endDate = Carbon::createFromDate(2024, 9, 1); // End date is the last day of August

        // Get all employees
        $employees = Employee::all();

        // Fetch all off days within the month of August
        $offDays = OffDay::whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->pluck('date')
            ->toArray();

        // Loop through each day within August
        $currentDate = clone $startDate;
        while ($currentDate->lte($endDate)) {
            // Skip the date if it is in the off_days table
            if (in_array($currentDate->toDateString(), $offDays)) {
                $currentDate->addDay();
                continue;
            }

            // Create attendance records for all employees on workdays
            foreach ($employees as $employee) {
                // Generate randomized arrival time between 07:00 AM and 10:00 AM
                $arrivalTime = Carbon::create($currentDate->year, $currentDate->month, $currentDate->day, 7, 0)
                    ->addMinutes(rand(0, 180)); // 0 to 120 minutes added

                // Generate randomized leave time between 05:00 PM and 09:00 PM
                $leaveTime = Carbon::create($currentDate->year, $currentDate->month, $currentDate->day, 17, 0)
                    ->addMinutes(rand(0, 240)); // 0 to 180 minutes added

                // Ensure leave time is after arrival time
                if ($leaveTime->lt($arrivalTime)) {
                    $leaveTime = $arrivalTime->copy()->addHours(8); // Default to 8 hours if leave time is before arrival time
                }

                Attendance::create([
                    'arrival_time' => $arrivalTime,
                    'leave_time' => $leaveTime,
                    'date' => $currentDate->toDateString(),
                    'employee_id' => $employee->id,
                ]);
            }

            // Move to the next day
            $currentDate->addDay();
        }
    }
}
