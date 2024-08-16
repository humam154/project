<?php

namespace App\services;

use App\Models\DistributedIncentive;
use App\Models\Employee;
use App\Models\NoteOnEmployee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncentiveService
{

    public function create($request): array
    {
        $incentives = $request->input('incentives', []);

        if(!is_null($incentives)) {

            if (count($incentives) != 0) {

                if ($this->sumOfPoints($incentives) == 0) {
                    $distributedIncentive = [];
                    $message = 'the sum of points is zero';
                    $code = 422;
                } else {
                    $distribute_unit = $request['incentive_block'] / $this->sumOfPoints($incentives);

                    for ($i = 0; $i < count($incentives); $i++) {
                        $distributedIncentive = DistributedIncentive::query()->create([
                            'employee_id' => $incentives[$i]['employee_id'],
                            'amount' => $incentives[$i]['points'] * $distribute_unit,
                            'points_amount' => $incentives[$i]['points'],
                            'share_id' => $incentives[$i]['share_id'],
                            'date' => Carbon::now()->format('Y-m-d'),
                        ]);

                        if (count($incentives[$i]['regulations']) == 0)
                            continue;

                        for ($j = 0; $j < count($incentives[$i]['regulations']); $j++) {
                            $notes_on_employees = NoteOnEmployee::query()->create([
                                'note' => $incentives[$i]['note'],
                                'incentive_id' => $distributedIncentive['id'],
                                'regulation_id' => $incentives[$i]['regulations'][$j],
                            ]);
                        }
                    }
                    $distributedIncentive = DistributedIncentive::query()->get();
                    $message = 'distributed successfully';
                    $code = 200;
                }
            } else {
                $distributedIncentive = [];
                $message = 'there are no employees to distribute incentives';
                $code = 422;
            }
        } else{
            $distributedIncentive = [];
            $message = 'incentives list is null';
            $code = 422;
        }
        return ['incentives' => $distributedIncentive, 'message' => $message, 'code' => $code];
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

    public function getIncentivesForCurrentYear() : array
    {
        $user = Auth::user();

        if(!is_null($user)){

            $employee = Employee::query()->where('user_id', $user['id'])->first();

            if(!is_null($employee)) {

                $incentives = DB::select('
                SELECT e.id, CONCAT(e.first_name, " ", e.last_name) AS "employee_name", di.amount, di.points_amount, di.date
                FROM distributed_incentives di
                JOIN employees e ON e.id = di.employee_id
                WHERE YEAR(date) = YEAR(NOW()) AND di.employee_id = ?
                ', [$employee['id']]);

                $message = 'success';
                $code = 200;
            } else {
                $incentives = [];
                $message = 'employee not found';
                $code = 404;
            }
        } else{
            $incentives = [];
            $message = 'unauthorized';
            $code = 401;
        }

        return ['incentives' => $incentives, 'message' => $message, 'code' => $code];
    }

    public function get(): array
    {
        $incentives = DB::select('
        SELECT *
        FROM distributed_incentives di
        JOIN employees e ON e.id = di.employee_id
        ');
        $message = 'success';
        $code = 200;

        return ['incentives' => $incentives, 'message' => $message, 'code' => $code];
    }
}
