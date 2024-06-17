<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncentiveShareCreateRequest;
use App\Http\Requests\IncentiveShareUpdateRequest;
use App\Http\Responses\Response;
use App\services\IncentiveShareService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class IncentiveSharesController extends Controller
{
    protected IncentiveShareService $incentiveShareService;

    public function __construct(IncentiveShareService $incentiveShareService){
        $this->incentiveShareService = $incentiveShareService;
    }

    public function create(IncentiveShareCreateRequest $request): JsonResponse
    {
        $data = [];

        try{
            $data = $this->incentiveShareService->create($request);
            return Response::Success($data['incentive_share'], $data['message']);
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
            $data = $this->incentiveShareService->get();
            if($data['code'] != 200){
                return Response::Error($data['incentive_share'], $data['message'], $data['code']);
            }
            return Response::Success($data['incentive_share'], $data['message']);
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
            $data = $this->incentiveShareService->delete($id);
            if($data['code'] != 200){
                return Response::Error($data['incentive_share'], $data['message'], $data['code']);
            }
            return Response::Success($data['incentive_share'], $data['message']);
        }
        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function update(IncentiveShareUpdateRequest $request, $id): JsonResponse
    {

        $data = [];

        try{
            $data = $this->incentiveShareService->update($request, $id);
            if($data['code'] != 200){
                return Response::Error($data['incentive_share'], $data['message'], $data['code']);
            }
            return Response::Success($data['incentive_share'], $data['message']);
        }
        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }
}
