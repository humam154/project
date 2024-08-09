<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncentiveShareCreateRequest;
use App\Http\Requests\IncentiveShareUpdateRequest;
use App\Http\Responses\Response;
use App\Models\DistributedIncentive;
use App\Models\Employee;
use App\services\IncentiveShareService;
use Carbon\Carbon;
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

    public function test(Request $request)
    {
        $incentives = $request->input('incentives', []);
        $count = count($incentives);
        $sum = 0;
        for($i = 0; $i < $count ; $i++)
        {
            $sum += $incentives[$i]['points'];
        }

        $distribute_unit = $request['incentive_block'] / $sum;

        for($i = 0 ; $i < $count ; $i++)
        {
            $distributedIncentive = DistributedIncentive::query()->create([
                'employee_id' => $incentives[$i]['employee_id'],
                'amount' => $incentives[$i]['points'] * $distribute_unit,
                'points_amount' => $incentives[$i]['points'],
                'share_id' => $incentives[$i]['share_id'],
                'date' => Carbon::now()->format('Y-m-d'),
            ]);
        }

    }
}
