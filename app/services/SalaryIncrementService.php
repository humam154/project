<?php

namespace App\services;

use App\Models\IncrementOnEmployee;
use App\Models\Salary;
use App\Models\SalaryIncrement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalaryIncrementService
{

    public function create($request): array
    {

        $user = Auth::user();

        $increments = $request->input('increments');

        $count = count($increments);

        $salary_increment = SalaryIncrement::query()->create([
            'date' => Carbon::now()->format('Y-m-d'),
            'percentage' => $request['percentage'],
            'employee_id' => $user['id']
        ]);

        for($i = 0; $i < $count; $i++){
            $increment_on_employees = IncrementOnEmployee::query()->create([
                'salary_increment_id' => $salary_increment['id'],
                'employee_id' => $increments[$i]['employee_id'],
                'percentage' => $salary_increment['percentage'],
            ]);
            $salary_id = DB::select('
            SELECT salary_id FROM salaries s JOIN employees e ON e.salary_id = s.id WHERE e.id = ?
            ', [$increment_on_employees['employee_id']]);
            $salary_id = $salary_id[0]->salary_id;

            $old_salary = DB::select('
            SELECT salary FROM salaries s JOIN employees e ON e.salary_id = s.id WHERE e.id = ?
            ', [$increment_on_employees['employee_id']]);
            $old_salary = (float) $old_salary[0]->salary;

            $new_salary = ($salary_increment['percentage'] / 100) * $old_salary + $old_salary;

            DB::update('
            UPDATE salaries SET salary = ? WHERE id = ?
            ', [$new_salary, $salary_id]);

            $employees = $increment_on_employees[$i];
        }

        return ['increment' => $salary_increment, 'message' => 'added successfully', 'code' => 200];
    }
}
