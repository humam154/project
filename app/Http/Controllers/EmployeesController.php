<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Http\Responses\Response;
use App\services\EmployeeService;
use Illuminate\Http\JsonResponse;
use Throwable;

class EmployeesController extends Controller
{
    protected EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function create(EmployeeCreateRequest $request): JsonResponse
    {

        $data = [];

        try{
            $data = $this->employeeService->create($request);
            return Response::Success($data['employee'], $data['message']);
        }
        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function get(): JsonResponse
    {
        $data = [];

        try{
            $data = $this->employeeService->get();

            if($data['code'] != 200){
                return Response::Error($data['employee'], $data['message'], $data['code']);
            }

            return Response::Success($data['employee'], $data['message']);
        }
        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function delete($id): JsonResponse
    {

        $data = [];

        try{
            $data = $this->employeeService->delete($id);

            if($data['code'] != 200){
                return Response::Error($data['employee'], $data['message'], $data['code']);
            }

            return Response::Success($data['employee'], $data['message']);
        }
        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function update(EmployeeUpdateRequest $request, $id): JsonResponse
    {

        $data = [];

        try{
            $data = $this->employeeService->update($request, $id);

            if($data['code'] != 200){
                return Response::Error($data['employee'], $data['message'], $data['code']);
            }

            return Response::Success($data['employee'], $data['message']);
        }
        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }
}
