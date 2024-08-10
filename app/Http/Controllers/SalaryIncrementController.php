<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncrementCreateRequest;
use App\Http\Responses\Response;
use App\Models\Complain;
use App\Models\Employee;
use App\Models\IncrementOnEmployee;
use App\Models\SalaryIncrement;
use App\services\EmployeeOfTheMonthService;
use App\services\SalaryIncrementService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SalaryIncrementController extends Controller
{
    protected SalaryIncrementService $salaryIncrementService;

    public function __construct(SalaryIncrementService $salaryIncrementService){
        $this->salaryIncrementService = $salaryIncrementService;
    }

    public function create(IncrementCreateRequest $request): JsonResponse
    {

        $data = [];

        try{
            $data = $this->salaryIncrementService->create($request);
            return Response::Success($data['increment'], $data['message']);
        }
        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

}
