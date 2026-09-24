<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = Employee::with('department');

        if (!empty($validated['search'])) {
            $search = $validated['search'];

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('department', function ($departmentQuery) use ($search) {
                        $departmentQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if (!empty($validated['department_id'])) {
            $query->where('department_id', $validated['department_id']);
        }

        $perPage = $validated['per_page'] ?? 10;

        $employees = $query
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate($perPage)
            ->withQueryString();

        return response()->json($employees);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:employees,email'],
            'position' => ['required', 'string', 'max:150'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
        ]);

        $employee = Employee::create($validated);
        $employee->load('department');

        return response()->json([
            'message' => 'Employee created successfully.',
            'data' => $employee,
        ], 201);
    }

    public function show(Employee $employee): JsonResponse
    {
        $employee->load('department');

        return response()->json([
            'data' => $employee,
        ]);
    }

    public function update(Request $request, Employee $employee): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => ['sometimes', 'required', 'string', 'max:100'],
            'last_name' => ['sometimes', 'required', 'string', 'max:100'],
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('employees', 'email')->ignore($employee->id),
            ],
            'position' => ['sometimes', 'required', 'string', 'max:150'],
            'department_id' => ['sometimes', 'required', 'integer', 'exists:departments,id'],
        ]);

        $employee->update($validated);
        $employee->load('department');

        return response()->json([
            'message' => 'Employee updated successfully.',
            'data' => $employee,
        ]);
    }

    public function destroy(Employee $employee): JsonResponse
    {
        $employee->delete();

        return response()->json([
            'message' => 'Employee deleted successfully.',
        ]);
    }
}
