<?php

namespace App\services;

use App\Models\DistributedIncentive;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class IncentiveService
{

    public function create($request)
    {
        $employees = Employee::query()->get();

        $points = $request->input('points');

        $count = count($employees);

        for($i = 0; $i < $count; $i++)
        {
            $full_points = DB::select('
            SELECT amount_of_share FROM incentive_shares is
            JOIN distributed_incentives di ON is.id = di.share_id
            JOIN employees e ON di.employee_id = ?
            JOIN salaries s ON e.salary_id = s.id
            JOIN salary_grades sg ON sg.id = s.grade_id
            WHERE  is.name = sg.description
            ', [$employees[$i]['id']]);
            $incentive = DistributedIncentive::query()->create([
                'employee_id' => $employees[$i]['id'],
                'points_amount' => $points[$i]
            ]);
        }
    }
}
