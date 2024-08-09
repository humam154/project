<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeOfTheMonthAddRequest;
use App\Http\Responses\Response;
use App\services\EmployeeOfTheMonthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class EmployeeOfTheMonthController extends Controller
{
    protected EmployeeOfTheMonthService $employeeOfTheMonthService;

    public function __construct(EmployeeOfTheMonthService $employeeOfTheMonthService)
    {
        $this->employeeOfTheMonthService = $employeeOfTheMonthService;
    }

    public function add(EmployeeOfTheMonthAddRequest $request): JsonResponse
    {

        $data = [];

        try{
            $data = $this->employeeOfTheMonthService->add($request);

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

    public function get(): JsonResponse
    {
        $data = [];

        try{
            $data = $this->employeeOfTheMonthService->get();

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

    public function getTop($number) : JsonResponse
    {
        $data = [];

        try{
            $data = $this->employeeOfTheMonthService->getTop($number);

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
