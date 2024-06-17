<?php

namespace App\services;

use App\Models\Salary;

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
}
