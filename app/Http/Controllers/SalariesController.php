<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryCreateRequest;
use App\Http\Requests\SalaryUpdateRequest;
use App\Http\Responses\Response;
use App\services\SalariesService;
use Illuminate\Http\JsonResponse;
use Throwable;

class SalariesController extends Controller
{
    private SalariesService $salariesService;

    public function __construct(SalariesService $salariesService){
        $this->salariesService = $salariesService;
    }

    public function create(SalaryCreateRequest $request): JsonResponse
    {

        $data = [];
        try{
            $data = $this->salariesService->create($request);
            return Response::Success($data['salary'], $data['message']);
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
            $data = $this->salariesService->get();

            if($data['code'] != 200){
                return Response::Error($data['salary'], $data['message'], $data['code']);
            }

            return Response::Success($data['salary'], $data['message']);
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
            $data = $this->salariesService->delete($id);

            if($data['code'] != 200){
                return Response::Error($data['salary'], $data['message'], $data['code']);
            }

            return Response::Success($data['salary'], $data['message']);
        }

        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function update(SalaryUpdateRequest $request, $id): JsonResponse
    {

        $data = [];

        try{
            $data = $this->salariesService->update($request, $id);

            if($data['code'] != 200){
                return Response::Error($data['salary'], $data['message'], $data['code']);
            }

            return Response::Success($data['salary'], $data['message']);
        }

        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }
}
