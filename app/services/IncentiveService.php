<?php

namespace App\services;

use App\Models\DistributedIncentive;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IncentiveService
{

    public function create($request)
    {
        $employees = Employee::query()->get();

        $date = Carbon::now('Y-m-d');

        $incentives = $request->input('incentives', []);

        $count = count($incentives);

        $virtual = 0;

        $share = count($employees);

        for($i = 0; $i < $count ; $i++)
        {
            if($incentives[$i]['points'] > 100){
                $virtual = $virtual + ($incentives[$i]['points'] - 100);

                if($virtual >= 100){
                    $share++;
                    $virtual -= 100;
                }

                if($i == count($incentives)-1 && $virtual != 0){
                    $share++;
                }
            }
        }

        $share_per_employee = $request['incentive_block'] / $share;


    }
}
