<?php

use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::apiResource('departments', DepartmentController::class);
Route::apiResource('employees', EmployeeController::class);
