<?php

namespace App\services;

use App\Models\SalaryGrade;
use Illuminate\Support\Facades\Auth;

class SalaryGradeService
{

    public function create($request): array
    {
            $salary_grade = SalaryGrade::create([
                'letter' => $request['letter'],
                'description' => $request['description'],
                'basic_salary' => $request['basic_salary']
            ]);

        return ['salary_grade' => $salary_grade, 'message' => 'create successfully', 'code' => 200];

    }

    public function get(): array
    {
        $salary_grade = SalaryGrade::get();

        if(is_null($salary_grade)){
            $message = 'no grades found';
            $code = 404;
        }
        else {
            $message = 'success';
            $code = 200;
        }
        return ['salary_grade' => $salary_grade, 'message' => $message, 'code' => $code];
    }

    public function delete($id): array
    {
        $salary_grade = SalaryGrade::query()->find($id);

        if(is_null($salary_grade)){
            $message = 'no grade found';
            $code = 404;
        }
        else{
            $salary_grade = $salary_grade->delete();
            $message = 'deleted successfully';
            $code = 200;
        }
        return ['salary_grade' => $salary_grade, 'message' => $message, 'code' => $code];
    }

    public function update($request, $id): array
    {

        $salary_grade = SalaryGrade::query()->find($id);

        if(!is_null($salary_grade)){
            SalaryGrade::query()->find($id)->update([
                'letter' => $request['letter'] ?? $salary_grade['letter'],
                'description' => $request['description'] ?? $salary_grade['description'],
                'basic_salary' => $request['basic_salary'] ?? $salary_grade['basic_salary'],
            ]);

            $salary_grade = SalaryGrade::query()->find($id);
            $message = 'updated successfully';
            $code = 200;
        }
        else{
            $message = 'no grade found';
            $code = 404;
        }

        return ['salary_grade' => $salary_grade, 'message' => $message, 'code' => $code];
    }
}
