<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HourRulesController;
use App\Http\Controllers\VacationDayController;
use App\Http\Controllers\OffDayTypeController;
use App\Http\Controllers\OffDayController;
use App\Http\Controllers\SalaryController;

Route::apiResource('users',UserController::class);
Route::apiResource('departments', DepartmentController::class);
Route::apiResource('hour-rules', HourRulesController::class);
Route::apiResource('vacation-days', VacationDayController::class);
Route::apiResource('off-day-types', OffDayTypeController::class);
Route::apiResource('off-days', OffDayController::class);


Route::apiResource('employees', EmployeeController::class);


use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');

// Protected routes using middleware to check privileges
Route::middleware(['auth:api', 'privilege:Admins,read'])->group(function () {
    Route::get('admins', [AuthController::class, 'index']);
});
Route::post('login', [AuthController::class, 'login']);

//return calculated salary for all employees API
Route::get('/salaries/calculate', [SalaryController::class, 'calculate']);
///api/salaries/calculate?month=9&year=2024
