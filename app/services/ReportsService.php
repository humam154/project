<?php

namespace App\services;

use App\Models\Complain;
use App\Models\Employee;
use App\Models\IncrementOnEmployee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsService
{
    public function financial(): array
    {
        $average_salary = DB::select('
        SELECT AVG(salary) AS "average_salary"
        FROM employees e
        JOIN salaries s ON e.salary_id = s.id
        ');
        $average_salary = $average_salary[0];


        $average_incentives = DB::select('
        SELECT AVG(amount) AS "average_incentives"
        FROM distributed_incentives
        ');
        $average_incentives = $average_incentives[0];

        $last_three_increments = DB::select('
        SELECT si.id, si.date, si.percentage, CONCAT(e.first_name, " ", e.last_name) AS employee_name
        FROM salary_increments si
        JOIN increment_on_employees ioe ON si.id = ioe.salary_increment_id
        JOIN employees e ON e.id = ioe.employee_id
        JOIN (
            SELECT id
            FROM salary_increments
            WHERE date < NOW()
            ORDER BY date DESC
            LIMIT ?
        ) latest_increments ON si.id = latest_increments.id
        ORDER BY si.date DESC;
        ', [3]);

        $final =  [
            'average_salary' => $average_salary,
            'average_incentives' => $average_incentives,
            'last_three_increments' => $last_three_increments
        ];

        return ['financial' => $final, 'message' => 'success', 'code' => 200];
    }

    public function HR(): array
    {
        $top_three_employee_of_the_month = DB::select('
        SELECT CONCAT(first_name, " ", last_name) AS employee_name, employee_of_the_month
        FROM employees e
        ORDER BY e.employee_of_the_month DESC
        LIMIT ?
        ', [3]);

        $max_employee_salary = DB::select('
        SELECT MAX(s.salary) AS max_salary,
               CONCAT(e.first_name, " ", e.last_name) AS employee_name,
               e.phone, e.email, sg.letter AS salary_grade
        FROM employees e
        JOIN salaries s ON e.salary_id = s.id
        JOIN salary_grades sg ON s.grade_id = sg.id
        WHERE sg.id = ?
        GROUP BY e.first_name, e.last_name, e.phone, e.email, sg.letter
        ', [4]);

        $max_supervisor_salary = DB::select('
        SELECT MAX(s.salary) AS max_salary,
               CONCAT(e.first_name, " ", e.last_name) AS employee_name,
               e.phone, e.email, sg.letter AS salary_grade
        FROM employees e
        JOIN salaries s ON e.salary_id = s.id
        JOIN salary_grades sg ON s.grade_id = sg.id
        WHERE sg.id = ?
        GROUP BY e.first_name, e.last_name, e.phone, e.email, sg.letter
        ', [3]);


        $complains_count = Complain::query()->count();

        $employees_count = Employee::query()->count();

        if($employees_count > 0){
            $complains_ratio = $complains_count / $employees_count;
        } else {
            $complains_ratio = 0;
        }

        if($complains_ratio >= 1){
            $message = 'complains ratio is bad';
        } else if($complains_ratio > 0.5 AND $complains_ratio < 0.9){
            $message = 'complains ratio is medium';
        } else {
            $message = 'complains ratio is good';
        }

        $complains = ['complains_ratio' => $complains_ratio, 'message' => $message];

        $final =  [
            'top_three_employee_of_the_month' => $top_three_employee_of_the_month,
            'max_employee_salary' => $max_employee_salary,
            'max_supervisor_salary' => $max_supervisor_salary,
            'complains' => $complains
        ];

        return ['HR' => $final, 'message' => 'success', 'code' => 200];
    }
}
