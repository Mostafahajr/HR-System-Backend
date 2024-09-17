<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\OffDay;
use App\Models\HourRule;
use Carbon\Carbon;
use App\Http\Requests\SalaryRequest;

class SalaryController extends Controller
{
    public function calculate(SalaryRequest $request)
    {
        $year = $request->input('year', Carbon::now()->year);  // Default to current year if not provided
        $month = $request->input('month', Carbon::now()->format('m'));  // Default to current month if not provided

        // Check if an employee_id or department_name is provided
        $employeeId = $request->input('employee_id');
        $departmentName = $request->input('department_name');
        // Get employees based on employee_id or department_name
        $employees = Employee::query();
        if ($employeeId) {
            $employees->where('id', $employeeId);
        } elseif ($departmentName) {
            $employees->join('departments', 'employees.department_id', '=', 'departments.id')
                ->where('departments.department_name', $departmentName)
                ->select('employees.*');
        }
        $employees = $employees->get();

        // Fetch the attendance records for the given month and year using 'like' query
        $attendances = Attendance::where('date', 'like', "{$year}-{$month}%")
            ->get()
            ->groupBy('employee_id');

        // Fetch off days (holidays, weekends)
        $offDays = OffDay::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->pluck('date')
            ->map(fn ($date) => $date->format('Y-m-d'))
            ->toArray();

        // Get today's date
        $today = Carbon::today();

        // Variable to store the working days in case you are computing the current month
        $currentMonth = null;

        // If the given month is the current month, find how many working days so far
        if ($year == $today->year && $month == $today->month) {
            $currentMonth = $today->day;
        }

        // Get the total number of days in the given month
        $totalDaysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

        // Calculate the total number of working days
        $workingDays = $this->calculateWorkingDays($totalDaysInMonth, $offDays, $today, $currentMonth);

        // Array to store the final result
        $result = [];

        // Loop through each employee
        foreach ($employees as $employee) {
            // Calculate salary per hour
            $salaryPerHour = $this->calculateSalaryPerHour($employee, $workingDays);

            // Initialize employee data in the result array
            $result[$employee->id] = [
                'name' => $employee->name,
                'salary' => $employee->salary,
                'department' => $employee->department,
                'attended_days' => 0,
                'absent_days' => 0,
                'total_bonus_minutes' => 0,
                'total_penalty_minutes' => 0,
                'total_bonus_egp' => 0,
                'total_penalty_egp' => 0,
                'net_salary' => 0,

                'daily_records' => []  // Array to store daily records
            ];

            // Track attendance dates
            $attendanceDates = isset($attendances[$employee->id])
                ? $attendances[$employee->id]->filter(function ($attendance) {
                    // Filter out the attendances where both arrival_time and leave_time are not null
                    return $attendance->arrival_time !== null && $attendance->leave_time !== null;
                })->pluck('date')->map(fn ($date) => $date->format('Y-m-d'))->toArray()
                : [];

            // Loop through attendance records of the employee
            if (isset($attendances[$employee->id])) {
                foreach ($attendances[$employee->id] as $attendance) {
                    // Check if the attendance date is not an off day or has null arrival times
                    if (!in_array($attendance->date->format('Y-m-d'), $offDays) && $attendance->arrival_time != null && $attendance->leave_time != null) {
                        $this->processAttendance($attendance, $employee, $salaryPerHour, $result[$employee->id]);
                    }
                }
            }

            // Calculate absent days and add penalty for each absent day
            $allMonthDays = collect(range(1, $totalDaysInMonth))->map(fn ($day) => Carbon::createFromDate($year, $month, $day)->format('Y-m-d'));

            // If processing for the current month, exclude days from today onwards
            if ($year == $today->year && $month == $today->month) {
                $absentDays = $allMonthDays->diff($attendanceDates)->diff($offDays)->filter(fn ($day) => Carbon::parse($day)->lt($today));
            } else {
                $absentDays = $allMonthDays->diff($attendanceDates)->diff($offDays);
            }

            // Add absent days to the daily records with penalty
            foreach ($absentDays as $absentDay) {
                $result[$employee->id]['absent_days']++;

                // Add an entry for each absent day with an 8-hour penalty
                $result[$employee->id]['total_penalty_minutes'] += 8 * 60;

                $result[$employee->id]['daily_records'][] = [
                    'date' => $absentDay,
                    'penalty_minutes' => 8 * 60,  // 8 hours * 60 minutes
                    'bonus_minutes' => 0
                ];
            }

            // Apply the hour rules and calculate total bonuses and penalties in EGP
            $this->applyHourRules($result[$employee->id], $salaryPerHour);

            // Calculate net salary
            $result[$employee->id]['net_salary'] = $this->calculateNetSalary(
                $employee->salary,
                $result[$employee->id]['total_bonus_egp'],
                $result[$employee->id]['total_penalty_egp']
            );
        }

        return response()->json($result, 200);
    }




    // Helper function to calculate working days
    private function calculateWorkingDays($totalDaysInMonth, $offDays, $today, &$currentMonth)
    {
        // Count the number of off days up to today
        $lastDayOfMonth = Carbon::createFromDate($today->year, $today->month, 1)->endOfMonth();
        $offDaysCount = count(array_filter($offDays, fn ($date) => Carbon::parse($date)->lte($lastDayOfMonth)));
        // if its current month filter off days
        if (isset($currentMonth)) {
            $currentMonth -= count(array_filter($offDays, fn ($date) => Carbon::parse($date)->lte($today)));
        }
        // Subtract off days from the total days of the month
        return $totalDaysInMonth - $offDaysCount;
    }

    // Helper function to calculate salary per hour (tmam)
    private function calculateSalaryPerHour($employee, $workingDays)
    {
        // Calculate total working hours in a day (contracted hours)
        $contractedHours = $employee->arrival_time->diffInHours($employee->leave_time);
        return $employee->salary / ($workingDays * $contractedHours);
    }

    // Process attendance and calculate bonuses/penalties
    private function processAttendance($attendance, $employee, $salaryPerHour, &$employeeResult)
    {
        // Assuming $employee->arrival_time and $employee->leave_time are already Carbon instances
        $contractArrival = $this->setToTodayDate($employee->arrival_time);
        $contractLeave = $this->setToTodayDate($employee->leave_time);
        // Assuming $attendance->arrival_time and $attendance->leave_time are Carbon instances
        $arrivalTime = $this->setToTodayDate($attendance->arrival_time);
        $leaveTime = $this->setToTodayDate($attendance->leave_time);

        // Initialize penalty and bonus for this date
        $penaltyMinutes = 0;
        $bonusMinutes = 0;

        // Update attended days
        $employeeResult['attended_days']++;
        // Calculate penalty minutes if arrival is later than the contract time
        if ($arrivalTime->greaterThan($contractArrival)) {
            $penaltyMinutes = $contractArrival->diffInMinutes($arrivalTime);
            $employeeResult['total_penalty_minutes'] += $penaltyMinutes;
        }

        // Calculate bonus minutes if leave is later than the contract time
        if ($leaveTime->greaterThan($contractLeave)) {
            $bonusMinutes = $contractLeave->diffInMinutes($leaveTime);
            $employeeResult['total_bonus_minutes'] += $bonusMinutes;
        }
        // Add details for the specific date
        $employeeResult['daily_records'][] = [
            'date' => $attendance->date->format('Y-m-d'),
            'penalty_minutes' => $penaltyMinutes,
            'bonus_minutes' => $bonusMinutes,
        ];
    }





    // Apply hour rules for bonus and penalty
    private function applyHourRules(&$employeeResult, $salaryPerHour)
    {
        $bonusRule = HourRule::where('type', 'increase')->first();
        $penaltyRule = HourRule::where('type', 'deduction')->first();

        $employeeResult['total_bonus_egp'] = ($employeeResult['total_bonus_minutes'] * $bonusRule->hour_amount / 60) * $salaryPerHour;
        $employeeResult['total_penalty_egp'] = ($employeeResult['total_penalty_minutes'] * $penaltyRule->hour_amount / 60) * $salaryPerHour;
    }

    // Calculate net salary
    private function calculateNetSalary($baseSalary, $totalBonus, $totalPenalty)
    {
        return $baseSalary + $totalBonus - $totalPenalty;
    }
    //function to set time to today's date
    private function setToTodayDate($dateTime)
    {
        // Ensure $dateTime is a Carbon instance
        $dateTime = Carbon::instance($dateTime);
        // Set the date to today while keeping the time
        return Carbon::today()->setTime($dateTime->hour, $dateTime->minute, $dateTime->second);
    }
}
