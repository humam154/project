<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryGradeCreateRequest;
use App\Http\Requests\SalaryGradeUpdateRequest;
use App\Http\Responses\Response;
use App\services\SalaryGradeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class SalaryGradesController extends Controller
{
    private SalaryGradeService $salaryGradeService;

    public function __construct(SalaryGradeService $salaryGradeService){
        $this->salaryGradeService = $salaryGradeService;
    }

    public function create(SalaryGradeCreateRequest $request): JsonResponse
    {

        $data = [];

        try{
            $data = $this->salaryGradeService->create($request);
            return Response::Success($data['salary_grade'], $data['message']);
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
            $data = $this->salaryGradeService->get();

            if($data['code'] !=200){
                return Response::Error($data['salary_grade'], $data['message'], $data['code']);
            }

            return Response::Success($data['salary_grade'], $data['message']);
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
            $data = $this->salaryGradeService->delete($id);

            if($data['code'] !=200){
                return Response::Error($data['salary_grade'], $data['message'], $data['code']);
            }

            return Response::Success($data['salary_grade'], $data['message']);
        }
        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function update(SalaryGradeUpdateRequest $request, $id): JsonResponse
    {

        $data = [];

        try{
           $data = $this->salaryGradeService->update($request, $id);

            if($data['code'] !=200){
                return Response::Error($data['salary_grade'], $data['message'], $data['code']);
            }

           return Response::Success($data['salary_grade'], $data['message']);
        }
        catch(Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }
}
