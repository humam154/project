<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegulationCreateRequest;
use App\Http\Requests\RegulationUpdateRequest;
use App\Http\Responses\Response;
use App\services\RegulationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class RegulationsController extends Controller
{
    protected RegulationService $regulationService;

    public function __construct(RegulationService $regulationService){
        $this->regulationService = $regulationService;
    }

    public function create(RegulationCreateRequest $request): JsonResponse
    {
        $data = [];
        try{
            $data = $this->regulationService->create($request);
            return Response::Success($data['regulation'], $data['message']);
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
            $data = $this->regulationService->get();
            if($data['code'] != 200){
                return Response::Error($data['regulation'], $data['message'], $data['code']);
            }
            return Response::Success($data['regulation'], $data['message']);
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
            $data = $this->regulationService->delete($id);
            if($data['code'] != 200){
                return Response::Error($data['regulation'], $data['message'], $data['code']);
            }
            return Response::Success($data['regulation'], $data['message']);
        }

        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }
    public function update(RegulationUpdateRequest $request, $id): JsonResponse
    {
        $data = [];

        try{
            $data = $this->regulationService->update($request, $id);
            if($data['code'] != 200){
                return Response::Error($data['regulation'], $data['message'], $data['code']);
            }
            return Response::Success($data['regulation'], $data['message']);
        }

        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }
}
