<?php

namespace App\services;

use App\Models\Employee;

class EmployeeOfTheMonthService
{

    public function add($request): array
    {
        $employee = Employee::query()->find($request['employee_id']);

        if(!is_null($employee)) {

            $employee['employee_of_the_month'] += 1;

            $employee->save();

            $employee = Employee::query()->find($request['employee_id']);

            $message = 'success';
            $code = 200;
        } else {
            $message = 'no employee found';
            $code = 404;
        }

        return ['employee' => $employee, 'message' => $message, 'code' => $code];
    }

    public function get(): array
    {
        $employee = Employee::query()
            ->where('employee_of_the_month', '>', 0)
            ->orderBy('employee_of_the_month', 'DESC')
            ->get();

        if(!is_null($employee) && count($employee) > 0) {
            $message = 'success';
            $code = 200;
        } else{
            $message = 'no employees of the month marked yet';
            $code = 404;
        }

        return ['employee' => $employee, 'message' => $message, 'code' => $code];
    }

    public function getTop($number): array
    {
        $employee = Employee::query()
            ->where('employee_of_the_month', '>', 0)
            ->orderBy('employee_of_the_month', 'DESC')
            ->take($number)
            ->get();

        if(!is_null($employee) && count($employee) > 0){
            $message = 'success';
            $code = 200;
        } else{
            $message = 'no employees of the month marked yet';
            $code = 404;
        }

        return ['employee' => $employee, 'message' => $message, 'code' => $code];
    }
}
