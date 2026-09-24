@echo off
setlocal EnableExtensions

echo ==========================================================
echo  WEEK 5 INSTALLER - Solomon King Patrick G. / BSIT 3B
echo ==========================================================
echo.

set "TARGET=%~1"
if "%TARGET%"=="" (
    if exist "%CD%\artisan" (
        set "TARGET=%CD%"
    ) else (
        set /p "TARGET=Enter the full path of your Laravel project: "
    )
)

if not exist "%TARGET%\artisan" (
    echo.
    echo ERROR: artisan was not found in:
    echo %TARGET%
    echo.
    echo Run this file again and enter your Laravel project root.
    pause
    exit /b 1
)

set "SOURCE=%~dp0payload"
set "BACKUP=%TARGET%\week5_backup_%RANDOM%"
mkdir "%BACKUP%" >nul 2>&1

echo Creating backup at:
echo %BACKUP%

echo.
echo Backing up files that Week 5 will replace...
if exist "%TARGET%\app\Models\Employee.php" copy /Y "%TARGET%\app\Models\Employee.php" "%BACKUP%\Employee.php" >nul
if exist "%TARGET%\app\Http\Controllers\Api\EmployeeController.php" copy /Y "%TARGET%\app\Http\Controllers\Api\EmployeeController.php" "%BACKUP%\EmployeeController.php" >nul
if exist "%TARGET%\routes\api.php" copy /Y "%TARGET%\routes\api.php" "%BACKUP%\api.php" >nul

mkdir "%TARGET%\app\Models" >nul 2>&1
mkdir "%TARGET%\app\Http\Controllers\Api" >nul 2>&1
mkdir "%TARGET%\database\migrations" >nul 2>&1
mkdir "%TARGET%\database\seeders" >nul 2>&1
mkdir "%TARGET%\routes" >nul 2>&1

copy /Y "%SOURCE%\app\Models\Department.php" "%TARGET%\app\Models\Department.php" >nul
copy /Y "%SOURCE%\app\Models\Employee.php" "%TARGET%\app\Models\Employee.php" >nul
copy /Y "%SOURCE%\app\Http\Controllers\DepartmentController.php" "%TARGET%\app\Http\Controllers\DepartmentController.php" >nul
copy /Y "%SOURCE%\app\Http\Controllers\Api\EmployeeController.php" "%TARGET%\app\Http\Controllers\Api\EmployeeController.php" >nul
copy /Y "%SOURCE%\database\migrations\2026_09_24_000001_create_departments_table.php" "%TARGET%\database\migrations\2026_09_24_000001_create_departments_table.php" >nul
copy /Y "%SOURCE%\database\migrations\2026_09_24_000002_add_department_id_to_employees_table.php" "%TARGET%\database\migrations\2026_09_24_000002_add_department_id_to_employees_table.php" >nul
copy /Y "%SOURCE%\database\migrations\2026_09_24_000003_upgrade_legacy_employee_department_column.php" "%TARGET%\database\migrations\2026_09_24_000003_upgrade_legacy_employee_department_column.php" >nul
copy /Y "%SOURCE%\database\seeders\Week5Seeder.php" "%TARGET%\database\seeders\Week5Seeder.php" >nul
copy /Y "%SOURCE%\routes\api.php" "%TARGET%\routes\api.php" >nul

echo.
echo Week 5 files were copied successfully.
echo.
echo NEXT COMMANDS - run them inside the Laravel project terminal:
echo   php artisan optimize:clear
echo   php artisan migrate
echo   php artisan db:seed --class=Week5Seeder
echo   php artisan route:list
echo   php artisan serve
echo.
echo NOTE: If you do not want sample employees, skip the db:seed command.
echo Backup location: %BACKUP%
echo.
pause
