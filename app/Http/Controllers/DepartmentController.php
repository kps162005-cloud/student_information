<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    public function index(): JsonResponse
    {
        $departments = Department::withCount('employees')
            ->orderBy('name')
            ->get();

        return response()->json($departments);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:departments,name'],
        ]);

        $department = Department::create($validated);

        return response()->json([
            'message' => 'Department created successfully.',
            'data' => $department,
        ], 201);
    }

    public function show(Department $department): JsonResponse
    {
        $department->load('employees');

        return response()->json([
            'data' => $department,
        ]);
    }

    public function update(Request $request, Department $department): JsonResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments', 'name')->ignore($department->id),
            ],
        ]);

        $department->update($validated);

        return response()->json([
            'message' => 'Department updated successfully.',
            'data' => $department,
        ]);
    }

    public function destroy(Department $department): JsonResponse
    {
        $department->delete();

        return response()->json([
            'message' => 'Department deleted successfully.',
        ]);
    }
}
