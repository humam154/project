<?php

namespace App\services;

use App\Models\Complain;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ComplainsService
{

    public function create($request): array
    {

        $user = Auth::user();

        if(!is_null($user)) {

            $employee = Employee::query()->where('user_id', $user['id'])->first();

            $complain = Complain::query()->create([
                'complain' => $request['complain'],
                'date' => Carbon::now()->format('Y-m-d'),
                'employee_id' => $employee['id']
            ]);

            $message = 'added successfully';
            $code = 200;
        } else {
            $message = 'unauthorized';
            $code = 401;
        }

        return ['complain' => $complain, 'message' => $message, 'code' => $code];
    }

    public function get(): array
    {
        $complain = Complain::query()->get();

        if(count($complain) == 0) {
            $message = 'no complains yet';
            $code = 404;
        } else {
            $message = 'success';
            $code = 200;
        }


        return ['complain' => $complain, 'message' => $message, 'code' => $code];
    }
}
