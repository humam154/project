<?php

namespace App\services;

use App\Models\Complain;
use App\Models\Employee;
use App\Models\IncrementOnEmployee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsService
{

    protected EmployeeOfTheMonthService $employeeOfTheMonthService;

    public function __construct(EmployeeOfTheMonthService $employeeOfTheMonthService)
    {
        $this->employeeOfTheMonthService = $employeeOfTheMonthService;
    }

    public function financial()
    {
        $averages = DB::select('
        SELECT AVG(amount) AS "average_distributed_incentives", AVG(salary) AS "average_salary"
        FROM distributed_incentives di
        JOIN employees e ON di.employee_id = e.id
        JOIN salaries s ON e.salary_id = s.id
        ');

        $last_three_dates = IncrementOnEmployee::query()
            ->where('date', '<', Carbon::now()->format('Y-m-d'))
            ->take(3)
            ->get();
        $last_three_dates = $last_three_dates[0]->last_three_dates;

        $last_three_increments = DB::select('
        SELECT si.id, si.date, si.percentage, CONCAT(e.first_name, " ", e.last_name) AS employee_name
        FROM salary_increments si
        JOIN increment_on_employees ioe ON si.id = ioe.salary_increment_id
        JOIN employees e ON e.id = ioe.employee_id
        WHERE si.date IN ?
        '[$last_three_dates]);
    }

    public function humanResource()
    {
        $top_three_employee_of_the_month = $this->employeeOfTheMonthService->getTop(3);

        $max_employee_salary = DB::select('
        SELECT MAX(salary) AS "max_salary", CONCAT(e.first_name, " ", e.last_name) AS employee_name,
               e.phone, e.email, sg.letter AS "salary_grade"
        FROM employees e
        JOIN salaries s ON e.salary_id = s.id
        JOIN salary_grades sg ON s.grade_id = sg.id
        WHERE sg.id = 4
        ');

        $max_supervisor_salary = DB::select('
        SELECT MAX(salary) AS "max_salary", CONCAT(e.first_name, " ", e.last_name) AS employee_name,
               e.phone, e.email, sg.letter AS "salary_grade"
        FROM employees e
        JOIN salaries s ON e.salary_id = s.id
        JOIN salary_grades sg ON s.grade_id = sg.id
        WHERE sg.id = 3
        ');


        $complains = Complain::query()->count();

        $employees = Employee::query()->count();

        if($complains > 0){
            $complains_ratio = $employees / $complains;
        } else {
            $complains_ratio = 0;
        }
    }
}
