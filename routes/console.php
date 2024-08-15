<?php

use App\Models\Employee;
use App\Models\Log;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use Maatwebsite\Excel\Excel;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::call(function (){
    $employees = Employee::query()->get();

    for ($i = 1; $i < count($employees); $i++) {
        $employee_id = $i;

        $full_name = DB::select('
        SELECT CONCAT(first_name, " ", last_name) AS "full_name" FROM employees WHERE id = ?
        ', [$employee_id]);
        $full_name = $full_name[0];

        $email = DB::select('
        SELECT email FROM employees WHERE id = ?
        ', [$employee_id]);
        $email = $email[0];

        $phone = DB::select('
        SELECT phone FROM employees WHERE id = ?
        ', [$employee_id]);
        $phone = $phone[0];

        $salary = DB::select('
        SELECT salary
        FROM salaries s
        JOIN employees e ON e.salary_id = s.id
        WHERE e.id = ?
        ', [$employee_id]);
        $salary = $salary[0];

        $grade = DB::select('
        SELECT letter
        FROM salary_grades g
        JOIN salaries s ON s.grade_id = g.id
        JOIN employees e ON e.salary_id = s.id
        WHERE e.id = ?
        ', [$employee_id]);
        $grade = $grade[0];

        $number_of_complains = DB::select('
        SELECT COUNT(id) AS "number_of_complains"
        FROM complains
        WHERE employee_id = ? AND YEAR(date) = YEAR(NOW())
        ', [$employee_id]);
        $number_of_complains = $number_of_complains[0];

        $incentives = DB::select('
        SELECT amount
        FROM distributed_incentives
        WHERE employee_id = ? AND YEAR(date) = YEAR(NOW())
        ', [$employee_id]);
        $incentives = $incentives[0];

        $log = Log::query()->create([
            'employee_id' => $employee_id,
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone,
            'salary' => $salary,
            'grade' => $grade,
            'number_of_complains' => $number_of_complains,
            'incentives' => $incentives,
        ]);
    }


    //Excel::store(new );
});
