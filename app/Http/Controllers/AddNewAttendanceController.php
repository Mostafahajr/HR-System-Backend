<?php
namespace App\Http\Controllers; 
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AddNewAttendanceController extends Controller
{
    public function index(Request $request)
    {
        Log::info('Request parameters:', $request->all());

        $query = Attendance::query()
            ->join('employees', 'attendances.employee_id', '=', 'employees.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->select('attendances.*', 'employees.name as employee_name', 'departments.department_name');

        if ($request->has('department')) {
            $query->where('departments.department_name', $request->input('department'));
            Log::info('After department filter:', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);
        }

        if ($request->has('date')) {
            $date = Carbon::parse($request->input('date'))->format('Y-m-d');
            $query->whereDate('attendances.date', $date);
        }

        $attendances = $query->get();
        return response()->json($attendances);
    }
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->update($request->only(['arrival_time', 'leave_time']));

        return response()->json(['message' => 'Attendance updated successfully']);
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return response()->json(['message' => 'Attendance record deleted successfully']);
    }

    public function bulkCreate()
    {
        $employees = Employee::all();
        $date = "2024-9-6";

        $records = $employees->map(function ($employee) use ($date) {
            return [
                'employee_id' => $employee->id,
                'date' => $date,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        DB::table('attendances')->insert($records);

        return response()->json(['message' => 'Daily attendance records created successfully']);
    }
}