<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class Week5Seeder extends Seeder
{
    public function run(): void
    {
        $it = Department::firstOrCreate(['name' => 'Information Technology']);
        $hr = Department::firstOrCreate(['name' => 'Human Resources']);
        $accounting = Department::firstOrCreate(['name' => 'Accounting']);

        $employees = [
            ['Juan', 'Dela Cruz', 'juan@example.com', 'Programmer', $it->id],
            ['Maria', 'Santos', 'maria@example.com', 'System Analyst', $it->id],
            ['Carlo', 'Mendoza', 'carlo@example.com', 'IT Support Specialist', $it->id],
            ['Bea', 'Navarro', 'bea@example.com', 'Web Developer', $it->id],
            ['Pedro', 'Reyes', 'pedro@example.com', 'HR Officer', $hr->id],
            ['Liza', 'Ramos', 'liza@example.com', 'Recruitment Assistant', $hr->id],
            ['Noel', 'Castillo', 'noel@example.com', 'Training Coordinator', $hr->id],
            ['Ana', 'Garcia', 'ana@example.com', 'Accountant', $accounting->id],
            ['Mark', 'Flores', 'mark@example.com', 'Bookkeeper', $accounting->id],
            ['Joy', 'Torres', 'joy@example.com', 'Payroll Assistant', $accounting->id],
            ['Paolo', 'Rivera', 'paolo@example.com', 'Junior Programmer', $it->id],
            ['Grace', 'Aquino', 'grace@example.com', 'HR Assistant', $hr->id],
        ];

        foreach ($employees as [$firstName, $lastName, $email, $position, $departmentId]) {
            Employee::updateOrCreate(
                ['email' => $email],
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'position' => $position,
                    'department_id' => $departmentId,
                ]
            );
        }
    }
}
