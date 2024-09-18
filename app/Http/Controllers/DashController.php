<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\OffDay;
use App\Models\OffDayType;
use Carbon\Carbon;
use DeepCopy\Filter\Filter;
use Illuminate\Http\Request;
use App\Http\Controllers\SalaryController;
use App\Http\Requests\SalaryRequest;
use App\Models\GroupType;

class DashController extends Controller
{
    //

    protected $salaryController;
    protected $request;
    public function __construct(SalaryController $salaryController)
    {
        $this->salaryController = $salaryController;



    }

    public function getStatic(SalaryRequest $request){

        $sumSalaries=0;
        $employees = Employee::all();
        $groupCount = GroupType::count();
        $offDaysType = OffDayType::find(1);
        $Salarys = $this->salaryController->calculate($request);

        $netSalary = $Salarys->getData(true);

        $currentDate = Carbon::now()->format('Y-m-d');
        $holidaysDates =$offDaysType->offDays->pluck('date')->toArray();
        $holidays =$offDaysType->offDays->pluck('description')->toArray();
        // for ($i=0; $i <count($holidaysDates) ; $i++) {
        //     # code...
        //     if ($holidaysDates[$i] >= $currentDate) {
        //         # code...
        //         $upcomingHolidaysDate []=  $holidaysDates[$i];
        //         $upcomingHolidays []=$holidays[$i];
        //     }


        // }
        $i = 0;
        $topSalariesSorted = Employee::orderBy('salary', 'desc')->take(5)->get();


        foreach ($employees as $employee ) {
            # code...

            $sumSalaries +=$netSalary[$employee['id']]['salary'];


            if ($i <count($holidaysDates)) {
                # code...
                if ($i < count($topSalariesSorted)) {
                    # code...
                    $topSalariesObj = [
                        "name"=>$topSalariesSorted[$i]->name,
                        "department"=>$topSalariesSorted[$i]->department->department_name,
                        "salary"=>$topSalariesSorted[$i]->salary,
                    ];
                    $topSalariesEmployees []=$topSalariesObj;
                }
                if ($holidaysDates[$i] >= $currentDate) {
                            # code...
                            $upcomingHolidaysDate []=  $holidaysDates[$i];
                            $upcomingHolidays []=$holidays[$i];
                }
                $i++;
            }
        }



         // Get the current date in 'Y-m-d' format


        // Get all attendance records
        $attendances = Attendance::all();  // Fetch all attendances from the database

        // Optionally, you can filter attendance records for the current date
        $filteredAttendances = $attendances->filter(function ($attendance) use ($currentDate) {
            // Check if the 'UTC' string exists in the date
            if (strpos($attendance->date, ' UTC') !== false) {
                $cleanedDateString = substr($attendance->date, 0, strpos($attendance->date, ' UTC'));
            } else {
                $cleanedDateString = $attendance->date;
            }

            // Parse the cleaned date string and format it to 'Y-m-d'
            $parsedDate = Carbon::parse($cleanedDateString)->format('Y-m-d');

            // Return true if the parsed date matches the current date
            return $parsedDate === $currentDate;
        });

        $attendance_Rate = ((count($filteredAttendances)/count($employees))*100)."%";
        // $offDays->offDayTypes()->attach($offDaysTypes->name);




        $dashRecords = [
            "employeeCount"=>count($employees),
            "attendanceRate"=>$attendance_Rate,
            "holidays"=>$upcomingHolidays[0],
            "upcomingHoliday"=>$upcomingHolidaysDate[0],
            "numberOfHoliday"=>count($holidaysDates),
            "sumOfSalaries"=>$sumSalaries,
            "topSalaries"=>$topSalariesEmployees,
            "groupCount"=>$groupCount,
        ];



        // Return the filtered attendance records as a JSON response
        return response()->json($dashRecords);
        }
}
