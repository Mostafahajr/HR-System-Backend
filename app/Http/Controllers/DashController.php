<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\OffDay;
use App\Models\OffDayType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\SalaryController;
use App\Http\Requests\SalaryRequest;
use App\Models\GroupType;
use App\Models\Department;
class DashController extends Controller
{
    protected $salaryController;

    public function __construct(SalaryController $salaryController)
    {
        $this->salaryController = $salaryController;
    }

    public function getEmployeeAndAttendanceRate()
{
    $employees = Employee::all();
    $currentDate = Carbon::now()->setTimezone('GMT+3')->format('Y-m-d');

    $attendances = Attendance::all();

    $filteredAttendances = $attendances->filter(function ($attendance) use ($currentDate) {
        // Clean the date string by removing any " UTC" suffix
        $cleanedDateString = strpos($attendance->date, ' UTC') !== false
            ? substr($attendance->date, 0, strpos($attendance->date, ' UTC'))
            : $attendance->date;

        // Parse the date and format it to 'Y-m-d'
        $parsedDate = Carbon::parse($cleanedDateString)->format('Y-m-d');

        // Check if the date matches the current date
        return $parsedDate === $currentDate &&
               !is_null($attendance->arrival_time) && 
               !is_null($attendance->leave_time); // Ensure arrival and leave times are not null
    });

    // Calculate the attendance rate based on filtered attendances
    $attendanceRate = count($employees) > 0
        ? (count($filteredAttendances) / count($employees)) * 100 . "%"
        : "0%";

    $data = [
        "employeeCount" => count($employees),
        "attendanceRate" => $attendanceRate,
    ];

    return response()->json($data);
}


    public function getSalaries(SalaryRequest $request)
    {
        $sumSalaries = 0;
        $employees = Employee::all();
        $Salarys = $this->salaryController->calculate($request);
        $netSalary = $Salarys->getData(true);

        $topSalariesSorted = Employee::orderBy('salary', 'desc')->take(5)->get();
        $topSalariesEmployees = [];

        foreach ($employees as $employee) {
            $sumSalaries += $netSalary[$employee['id']]['salary'];
        }

        foreach ($topSalariesSorted as $topSalaryEmployee) {
            $topSalariesEmployees[] = [
                "name" => $topSalaryEmployee->name,
                "department" => $topSalaryEmployee->department->department_name,
                "salary" => $topSalaryEmployee->salary,
            ];
        }

        $data = [
            "sumOfSalaries" => $sumSalaries,
            "topSalaries" => $topSalariesEmployees,
        ];

        return response()->json($data);
    }

    public function getHolidays()
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $offDaysType = OffDayType::find(1);
        $holidaysDates = $offDaysType->offDays->pluck('date')->toArray();
        $holidays = $offDaysType->offDays->pluck('description')->toArray();
        $upcomingHolidaysDate = [];
        $upcomingHolidays = [];

        for ($i = 0; $i < count($holidaysDates); $i++) {
            if ($holidaysDates[$i] >= $currentDate) {
                $upcomingHolidaysDate[] =  $holidaysDates[$i];
                $upcomingHolidays[] = $holidays[$i];
            }
        }

        $data = [
            "numberOfHolidays" => count($holidaysDates),
            "upcomingHoliday" => [
                "date" => $upcomingHolidaysDate[0] ?? null,
                "description" => $upcomingHolidays[0] ?? null,
            ]
        ];

        return response()->json($data);
    }

    public function getDepartmentInfo()
    {
        $departments = Department::withCount('employees')->get();
        
        $departmentData = $departments->map(function ($department) {
            return [
                'name' => $department->department_name,
                'employeeCount' => $department->employees_count
            ];
        });

        $data = [
            'totalDepartments' => $departments->count(),
            'departments' => $departmentData
        ];

        return response()->json($data);
    }
}