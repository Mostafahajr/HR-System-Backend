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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupsAndPermisionsController;

Route::apiResource('users',UserController::class);
Route::apiResource('departments', DepartmentController::class);
Route::apiResource('hour-rules', HourRulesController::class);
Route::apiResource('vacation-days', VacationDayController::class);
Route::apiResource('off-day-types', OffDayTypeController::class);
Route::apiResource('off-days', OffDayController::class);


Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    Route::middleware('check.privilege:Groups_and_Permissions,read')->group(function () {
        Route::get('privileges', [GroupsAndPermisionsController::class, 'index']);
    });

    // Add other routes that need authentication and privilege checks here
});