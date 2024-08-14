<?php

namespace App\services;

use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Support\Facades\Auth;

class SalariesService
{
    public function create($request): array
    {
        $salary = Salary::query()->create([
            'salary' => $request['salary'],
            'grade_id' => $request['grade_id']
        ]);


        return ['salary' => $salary, 'message' => 'created successfully', 'code' => 200];
    }

    public function get(): array
    {
        $salary = Salary::query()->get();

        if(is_null($salary)){
            $message = 'no salaries found';
            $code = 404;
        }
        else {
            $message = 'success';
            $code = 200;
        }

        return ['salary' => $salary, 'message' => $message, 'code' => $code];
    }

    public function delete($id): array
    {

        $salary = Salary::query()->find($id);

        if(is_null($salary)){
            $message = 'no salary found';
            $code = 404;
        }
        else{
            $salary = $salary->delete();
            $message = 'deleted successfully';
            $code = 200;
        }

        return ['salary' => $salary, 'message' => $message, 'code' => $code];
    }

    public function update($request, $id): array
    {

        $salary = Salary::query()->find($id);

        if(!is_null($salary)){
            Salary::query()->find($id)->update([
                'salary' => $request['salary'] ?? $salary['salary'],
                'grade_id' => $request['grade_id'] ?? $salary['grade_id'],
            ]);

            $salary = Salary::query()->find($id);
            $message = 'updated successfully';
            $code = 200;
        }
        else{
            $message = 'no salary found';
            $code = 404;
        }

        return ['salary' => $salary, 'message' => $message, 'code' => $code];
    }

    public function getById() : array
    {
        $user = Auth::user();

        if(!is_null($user)){
            $employee = Employee::query()->where('user_id', $user['id'])->first();

            if(!is_null($employee)) {

                $salary = DB::select('
                    SELECT s.salary
                    FROM employees e
                    JOIN salaries s ON e.salary_id = s.id
                    WHERE e.id = ?
                    ', $employee['id']);
                $salary = $salary[0];
                $message = 'success';
                $code = 200;
            } else{
                $salary = [];
                $message = 'no employee found';
                $code = 404;
                }
        } else {
            $salary = [];
            $message = 'unauthenticated';
            $code = 401;
        }

        return ['salary' => $salary, 'message' => $message, 'code' => $code];
    }

    public function expectSalary(): array
    {
        $user = Auth::user();

        if(!is_null($user)){
            $employee = Employee::query()->where('user_id', $user['id'])->first();

            $salary = Salary::query()->where('id', $employee['salary_id'])->first();
            if(!is_null($employee)){
                $expected_salary = [];

                for ($i = 0 ; $i < 12 ; $i++){
                    $expected_salary[$i] = ($salary * rand(0.05, 0.20)) + $salary;
                }

                $message = 'success';
                $code = 200;
            } else {
                $expected_salary = [];
                $message = 'no employee found';
                $code = 404;
            }
        } else{
            $expected_salary = [];
            $message = 'unauthenticated';
            $code = 401;
        }

        return ['salary' => $expected_salary, 'message' => $message, 'code' => $code];
    }
}
