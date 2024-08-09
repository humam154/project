<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComplainCreateRequest;
use App\Http\Responses\Response;
use App\services\ComplainsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ComplainController extends Controller
{
    private ComplainsService $complainsService;

    public function __construct(ComplainsService $complainsService)
    {
        $this->complainsService = $complainsService;
    }

    public function create(ComplainCreateRequest $request): JsonResponse
    {
        $data = [];

        try{
            $data = $this->complainsService->create($request);


            if($data['code'] != 200){
                return Response::Error($data['complain'], $data['message'], $data['code']);
            }

            return Response::Success($data['complain'], $data['message']);
        }

        catch(Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function get(): JsonResponse
    {
        $data = [];

        try{
            $data = $this->complainsService->get();

            if($data['code'] != 200){
                return Response::Error($data['complain'], $data['message'], $data['code']);
            }

            return Response::Success($data['complain'], $data['message']);
        }

        catch(Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }
}
