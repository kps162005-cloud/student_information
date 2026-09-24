<?php

use App\Http\Controllers\Api\EmployeeController;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/students', function () {
    return response()->json([
        ['id' => 1, 'name' => 'Solomon King Patrick G', 'course' => 'BSIT 3B'],
        ['id' => 2, 'name' => 'King S', 'course' => 'BSIT 3B'],
    ]);
});

Route::post('/students', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'course' => 'required|string|max:255',
    ]);

    $student = Students::create([
        'name' => $request->name,
        'course' => $request->course,
    ]);

    return response()->json($student, 201);
});

Route::get('/employees', [EmployeeController::class, 'index']);
Route::post('/employees', [EmployeeController::class, 'store']);
Route::get('/employees/{id}', [EmployeeController::class, 'show']);
Route::put('/employees/{id}', [EmployeeController::class, 'update']);
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);