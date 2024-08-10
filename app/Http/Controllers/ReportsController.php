<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;
use App\services\ReportsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ReportsController extends Controller
{
    protected ReportsService $reportsService;

    public function __construct(ReportsService $reportsService)
    {
        $this->reportsService = $reportsService;
    }

    public function finance(): JsonResponse
    {
        $data = [];

        try {
            $data = $this->reportsService->financial();
            return Response::Success($data['financial'], $data['message']);
        }
        catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function HR()
    {
        $data = [];

        try {
            $data = $this->reportsService->HR();
            return Response::Success($data['HR'], $data['message']);
        }
        catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

}
