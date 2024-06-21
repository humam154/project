<?php

namespace App\services;

use App\Models\Employee;
use App\Models\Salary;
use App\Models\SalaryGrade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Integer;

class EmployeeService
{

    protected SalariesService $salariesService;
    public function __construct(SalariesService $salariesService)
    {
        $this->salariesService = $salariesService;
    }

    public function create($request): array
    {

        $user = $this->createUser($request['first_name'], $request['last_name'], $request['email']);

        $salary = $this->createSalary($request['salary'], $request['grade_id']);


        $employee = Employee::query()->create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $user['email'],
            'phone' => $request['phone'],
            'salary_id' => $salary['id'],
            'user_id' => $user['id']
        ]);

        return ['employee' => $employee, 'message' => 'created successfully', 'code' => 200];
    }

    public function get(): array
    {

        $employee = Employee::query()->get();

        if(is_null($employee)) {
            $message = 'there is no employees';
            $code = 404;
        }
        else{
            $message = 'success';
            $code = 200;
        }

        return ['employee' => $employee, 'message' => $message, 'code' => $code];
    }

    public function delete($id): array
    {

        $employee = Employee::query()->find($id);

        if(!is_null($employee)) {

            $user = $this->getUser($id)->delete();
            $this->deleteSalary($employee);
            $employee = $employee->delete();

            $message = 'deleted successfully';
            $code = 200;
        }
        else{
            $message = 'no employee found';
            $code = 404;
        }

        return ['employee' => $employee, 'message' => $message, 'code' => $code];
    }

    public function update($request, $id): array
    {

        $employee = Employee::query()->find($id);

        if(!is_null($employee)){

            $user = $this->updateUser($employee, $request['first_name'], $request['last_name'], $request['email']);

            Employee::query()->find($id)->update([
                'first_name' => $request['first_name'] ?? $employee['first_name'],
                'last_name' => $request['last_name'] ?? $employee['last_name'],
                'email' => $request['email'] ?? $employee['email'],
                'phone' => $request['phone'] ?? $employee['phone'],
            ]);

            $employee = Employee::query()->find($id);
            $message = 'updated successfully';
            $code = 200;
        }
        else{
            $message = 'no employee found';
            $code = 404;
        }


        return ['employee' => $employee, 'message' => $message, 'code' => $code];
    }

    protected function getId($char): ?Integer
    {
        $salary_grade = SalaryGrade::query()->where('letter', $char)->first();
        if(!is_null($salary_grade)) {
            return $salary_grade['id'];
        }
        else{
            return null;
        }
    }

    protected function getUser($id): ?User
    {
        $employee = Employee::query()->find($id);

        if(!is_null($employee)) {
            return User::find($employee['user_id']);
        }
        else{
            return null;
        }
    }

    protected function createUser($first_name, $last_name, $email): User
    {
        return User::create([
            'name' => $first_name.' '.$last_name,
            'email' => $email,
            'password' => Hash::make('password')
        ]);
    }

    protected function createSalary($salary, $grade_id): Salary
    {
        $request = new Request([
            'salary' => $salary,
            'grade_id' => $grade_id
        ]);
        $new_salary = $this->salariesService->create($request);

        return $new_salary['salary'];
    }

    protected function deleteSalary($employee): void
    {
        $id = $employee['salary_id'];

        Salary::query()->where('id', $id)->delete();
    }

    protected function updateUser($employee, $first_name, $last_name, $email): ?User
    {
        $user = $this->getUser($employee['id']);
        $user->update([
                'name' => $first_name.' '.$last_name ?? $employee['first_name'].' '.$employee['last_name'],
                'email' => $email ?? $employee['email']
        ]);

        return $user;
    }
}
