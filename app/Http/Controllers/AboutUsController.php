<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutUsEditRequest;
use App\Http\Responses\Response;
use App\services\AboutUsService;
use Illuminate\Http\JsonResponse;
use Throwable;

class AboutUsController extends Controller
{
    protected AboutUsService  $aboutUsService;

    public function __construct(AboutUsService $aboutUsService)
    {
        $this->aboutUsService = $aboutUsService;
    }

    public function update(AboutUsEditRequest $request): JsonResponse
    {
        $data = [];

        try {
            $data = $this->aboutUsService->edit($request);
            return Response::Success($data['about_us'], $data['message']);
        }
        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function get(): JsonResponse
    {
        $data = [];

        try {
            $data = $this->aboutUsService->view();
            return Response::Success($data['about_us'], $data['message']);
        }
        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

}
