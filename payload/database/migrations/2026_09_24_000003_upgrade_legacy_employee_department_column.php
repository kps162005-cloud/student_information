<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Week 1-4 versions may have stored the department as plain text.
        // Convert those values to real department records before removing the old column.
        if (!Schema::hasColumn('employees', 'department')) {
            return;
        }

        $departmentNames = DB::table('employees')
            ->whereNotNull('department')
            ->where('department', '<>', '')
            ->distinct()
            ->pluck('department');

        foreach ($departmentNames as $departmentName) {
            DB::table('departments')->updateOrInsert(
                ['name' => $departmentName],
                ['updated_at' => now(), 'created_at' => now()]
            );

            $departmentId = DB::table('departments')
                ->where('name', $departmentName)
                ->value('id');

            DB::table('employees')
                ->where('department', $departmentName)
                ->update(['department_id' => $departmentId]);
        }

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('department');
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('employees', 'department')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->string('department')->nullable()->after('email');
            });
        }

        DB::table('employees')
            ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
            ->select('employees.id', 'departments.name')
            ->orderBy('employees.id')
            ->get()
            ->each(function ($employee) {
                DB::table('employees')
                    ->where('id', $employee->id)
                    ->update(['department' => $employee->name]);
            });
    }
};
