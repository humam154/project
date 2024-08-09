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
        $incentives = $request->input('incentives', []);
        $distribute_unit = $request['incentive_block'] / $this->sumOfPoints($incentives);

        for($i = 0 ; $i < count($incentives) ; $i++)
        {
            $distributedIncentive = DistributedIncentive::query()->create([
                'employee_id' => $incentives[$i]['employee_id'],
                'amount' => $incentives[$i]['points'] * $distribute_unit,
                'points_amount' => $incentives[$i]['points'],
                'share_id' => $incentives[$i]['share_id'],
                'date' => Carbon::now()->format('Y-m-d'),
            ]);
        }
    }

    private function sumOfPoints($incentives): int
    {
        $count = count($incentives);
        $sum = 0;
        for($i = 0; $i < $count ; $i++)
        {
            $sum += $incentives[$i]['points'];
        }

        return $sum;
    }
}
