<?php

namespace App\Http\Controllers;

use App\Http\Requests\DistributeIncentiveRequest;
use App\Http\Responses\Response;
use App\services\IncentiveService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class DistributedIncentiveController extends Controller
{
    protected IncentiveService $incentiveService;
    public function __construct(IncentiveService $incentiveService)
    {
        $this->incentiveService = $incentiveService;
    }

    public function create(DistributeIncentiveRequest $request): JsonResponse
    {
        $data = [];

        try{
            $data = $this->incentiveService->create($request);

            return Response::Success($data['incentives'], $data['message'], $data['code']);
        }
        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }
}
