<?php

use App\Exports\LogsExport;
use App\Models\Employee;
use App\Models\Log;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use Maatwebsite\Excel\Excel;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::call(function () {
    try {

        $employees = DB::select('
            SELECT
                e.id AS employee_id,
                CONCAT(e.first_name, " ", e.last_name) AS full_name,
                e.email,
                e.phone,
                s.salary,
                g.letter AS grade,
                (SELECT COUNT(c.id)
                 FROM complains c
                 WHERE c.employee_id = e.id
                   AND YEAR(c.date) = YEAR(NOW())
                ) AS number_of_complains,
                (SELECT SUM(di.amount)
                 FROM distributed_incentives di
                 WHERE di.employee_id = e.id
                   AND YEAR(di.date) = YEAR(NOW())
                ) AS incentives
            FROM employees e
            JOIN salaries s ON e.salary_id = s.id
            JOIN salary_grades g ON s.grade_id = g.id
        ');

        foreach ($employees as $employee) {
            DB::table('logs')->insert([
                'employee_id' => $employee->employee_id,
                'full_name' => $employee->full_name,
                'email' => $employee->email,
                'phone' => $employee->phone,
                'salary' => $employee->salary,
                'grade' => $employee->grade,
                'number_of_complains' => $employee->number_of_complains ?? 0,
                'incentives' => $employee->incentives ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $year = Carbon::now()->year;
        $year = (string)$year;
        $file_name = $year . '.xlsx';

        Excel::store(new LogsExport(), $file_name, 'local', Excel::XLSX);
    } catch (\Exception $e) {
        LaravelLog::error('Schedule call failed: ' . $e->getMessage());
    }
})->yearlyOn(12, 31, '00:00');
