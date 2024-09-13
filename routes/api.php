<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::apiResource('users', UserController::class);
Route::apiResource('employees', EmployeeController::class);

use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');

// Protected routes using middleware to check privileges
Route::middleware(['auth:api', 'privilege:admins,read'])->group(function () {
    Route::get('admins', [AuthController::class, 'index']);
});
