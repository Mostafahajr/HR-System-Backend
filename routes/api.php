<?php

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
use App\Http\Controllers\GroupsAndPermissionsController;
use App\Http\Controllers\PermissionsController;


Route::apiResource('users',UserController::class);
Route::apiResource('departments', DepartmentController::class);
Route::apiResource('hour-rules', HourRulesController::class);
Route::apiResource('vacation-days', VacationDayController::class);
Route::apiResource('off-day-types', OffDayTypeController::class);
Route::apiResource('off-days', OffDayController::class);


Route::apiResource('attendances',AttendanceController::class);
Route::apiResource('home',DashController::class);


Route::apiResource('employees', EmployeeController::class);
Route::get('groups', [GroupController::class,'getStatic']);

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::get('privileges',[PermissionsController::class, 'index']);
Route::post('privileges',[PermissionsController::class, 'store']);
Route::get('privileges/{id}',[PermissionsController::class, 'show']);
Route::put('privileges/{id}',[PermissionsController::class, 'update']);
Route::middleware('auth:api')->group(function () {

    Route::get('me', [AuthController::class, 'me']);

    Route::middleware('check.privilege:Groups_and_Permissions,read')->group(function () {
    });


// Protected routes using middleware to check privileges
Route::middleware(['auth:api', 'privilege:Admins,read'])->group(function () {
    Route::get('admins', [AuthController::class, 'index']);
});
Route::post('login', [AuthController::class, 'login']);


//return calculated salary for all employees API
Route::get('/salaries/calculate', [SalaryController::class, 'calculate']);
///api/salaries/calculate?month=9&year=2024

    // Add other routes that need authentication and privilege checks here
});


