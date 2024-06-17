<?php

namespace App\services;

use App\Models\Employee;

class EmployeeService
{

    public function addEmployee($request){

        $employee = Employee::create([]);
    }
}
