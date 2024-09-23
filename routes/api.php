<?php

use App\Http\Controllers\AddNewAttendanceController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HourRulesController;
use App\Http\Controllers\VacationDayController;
use App\Http\Controllers\OffDayTypeController;
use App\Http\Controllers\OffDayController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PermissionsController;

// Public routes
Route::post('login', [AuthController::class, 'login']);
Route::get('/salaries/calculate', [SalaryController::class, 'calculate']);

// Routes that require authentication
Route::middleware('auth:api')->group(function () {
    // Logout route
    Route::post('logout', [AuthController::class, 'logout']);
    // Get authenticated user info
    Route::get('me', [AuthController::class, 'me']);
    // home apis
    Route::get('home', [DashController::class, 'getStatic']);
    // Route for employee count and attendance rate
    Route::get('home/employee-attendance', [DashController::class, 'getEmployeeAndAttendanceRate']);
    // Route for salary information
    Route::get('home/salaries', [DashController::class, 'getSalaries']);
    // Route for holidays and upcoming holiday
    Route::get('home/holidays', [DashController::class, 'getHolidays']);
    // Route for departments info
    Route::get('/home/department-info', [DashController::class, 'getDepartmentInfo']);

    // User routes with specific privileges
    Route::prefix('users')->group(function () {
        Route::middleware('check.privilege:Users,read')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('/{id}', [UserController::class, 'show']);
        });

        Route::middleware('check.privilege:Users,create')->group(function () {
            Route::post('/', [UserController::class, 'store']);
        });

        Route::middleware('check.privilege:Users,update')->group(function () {
            Route::put('/{id}', [UserController::class, 'update']);
            Route::patch('/{id}', [UserController::class, 'update']);
        });

        Route::middleware('check.privilege:Users,delete')->group(function () {
            Route::delete('/{id}', [UserController::class, 'destroy']);
        });
    });

    Route::prefix('add-new-attendance')->group(function () {
        Route::middleware('check.privilege:Attendance_Reports,read')->group(function () {
            Route::get('/', [AddNewAttendanceController::class, 'index']);
        });
        Route::middleware('check.privilege:Attendance_Reports,update')->group(function () {
            Route::patch('/{id}', [AddNewAttendanceController::class, 'update']);
        });
        Route::middleware('check.privilege:Attendance_Reports,update')->group(function () {
            Route::delete('/{id}', [AddNewAttendanceController::class, 'destroy']);
        });
        Route::post('/bulk-create', [AddNewAttendanceController::class, 'bulkCreate']); //only system?
    });

    Route::prefix('privileges')->group(function () {
        Route::middleware('check.privilege:Groups_and_Permissions,read')->group(function () {
            Route::get('/', [PermissionsController::class, 'index']);
            Route::get('/{id}', [PermissionsController::class, 'show']);
        });
        Route::middleware('check.privilege:Groups_and_Permissions,create')->group(function () {
            Route::post('/', [PermissionsController::class, 'store']);
        });
        Route::middleware('check.privilege:Groups_and_Permissions,update')->group(function () {
            Route::put('/{id}', [PermissionsController::class, 'update']);
        });
    });
    Route::prefix('departments')->group(function () {
        Route::middleware('check.privilege:Departments,read')->group(function () {
            Route::get('/', [DepartmentController::class, 'index']);
            Route::get('/{id}', [DepartmentController::class, 'show']);
        });
        Route::middleware('check.privilege:Departments,create')->group(function () {
            Route::post('departments', [DepartmentController::class, 'store']);
        });
        Route::middleware('check.privilege:Departments,update')->group(function () {
            Route::put('departments', [DepartmentController::class, 'update']);
        });
        Route::middleware('check.privilege:Departments,delete')->group(function () {
            Route::delete('departments', [DepartmentController::class, 'destroy']);
        });
    });

    Route::prefix('groups')->group(function () {
        Route::middleware('check.privilege:Groups_and_Permissions,read')->group(function () {
            Route::get('/', [GroupController::class, 'index']);
            Route::get('/{id}', [GroupController::class, 'show']);
        });
        Route::middleware('check.privilege:Groups_and_Permissions,create')->group(function () {
            Route::post('/', [GroupController::class, 'store']);
        });
        Route::middleware('check.privilege:Groups_and_Permissions,update')->group(function () {
            Route::put('/{id}', [GroupController::class, 'update']);
        });
        Route::middleware('check.privilege:Groups_and_Permissions,delete')->group(function () {
            Route::delete('/{id}', [GroupController::class, 'destroy']);
        });
    });

    Route::prefix('hour-rules')->group(function () {
        Route::middleware('check.privilege:Salary_Related_Settings,read')->group(function () {
            Route::get('/', [HourRulesController::class, 'index']);
            Route::get('/{id}', [HourRulesController::class, 'show']);
        });
        Route::middleware('check.privilege:Salary_Related_Settings,create')->group(function () {
            Route::post('/', [HourRulesController::class, 'store']);
        });
        Route::middleware('check.privilege:Salary_Related_Settings,update')->group(function () {
            Route::put('/{id}', [HourRulesController::class, 'update']);
        });
        Route::middleware('check.privilege:Salary_Related_Settings,delete')->group(function () {
            Route::delete('/{id}', [HourRulesController::class, 'destroy']);
        });
    });

    Route::prefix('vacation-days')->group(function () {
        Route::middleware('check.privilege:Weekend_Settings,read')->group(function () {
            Route::get('/', [VacationDayController::class, 'index']);
            Route::get('/{id}', [VacationDayController::class, 'show']);
        });
        Route::middleware('check.privilege:Weekend_Settings,create')->group(function () {
            Route::post('/', [VacationDayController::class, 'store']);
        });
        Route::middleware('check.privilege:Weekend_Settings,update')->group(function () {
            Route::put('/{id}', [VacationDayController::class, 'update']);
        });
        Route::middleware('check.privilege:Weekend_Settings,delete')->group(function () {
            Route::delete('/{id}', [VacationDayController::class, 'destroy']);
        });
    });

    Route::prefix('employees')->group(function () {
        Route::middleware('check.privilege:Employees,read')->group(function () {
            Route::get('/', [EmployeeController::class, 'index']);
            Route::get('/{id}', [EmployeeController::class, 'show']);
        });
        Route::middleware('check.privilege:Employees,create')->group(function () {
            Route::post('/', [EmployeeController::class, 'store']);
        });
        Route::middleware('check.privilege:Employees,update')->group(function () {
            Route::put('/{id}', [EmployeeController::class, 'update']);
        });
        Route::middleware('check.privilege:Employees,delete')->group(function () {
            Route::delete('/{id}', [EmployeeController::class, 'destroy']);
        });
    });

    Route::prefix('attendance')->group(function () {
        Route::middleware('check.privilege:Attendance_Reports,read')->group(function () {
            Route::get('/', [AttendanceController::class, 'index']);
        });
        Route::middleware('check.privilege:Attendance_Reports,update')->group(function () {
            Route::put('/{id}', [AttendanceController::class, 'update']);
        });
        Route::middleware('check.privilege:Attendance_Reports,delete')->group(function () {
            Route::delete('/{id}', [AttendanceController::class, 'destroy']);
        });
    });

    Route::apiResource('off-day-types', OffDayTypeController::class);
    Route::apiResource('off-days', OffDayController::class);
});
