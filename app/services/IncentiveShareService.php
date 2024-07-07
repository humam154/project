<?php

namespace App\services;

use App\Models\IncentiveShare;

class IncentiveShareService
{

    public function create($request): array
    {

        $incentive_share = IncentiveShare::query()->create([
            'name' => $request['name'],
            'amount_of_share' => $request['amount_of_share']
        ]);

        return ['incentive_share' => $incentive_share, 'message' => 'created successfully', 'code' => 200];
    }

    public function get(): array
    {

        $incentive_share = IncentiveShare::query()->get();

        if(is_null($incentive_share)){
            $message = 'no shares found';
            $code = 404;
        }
        else{
            $message = 'success';
            $code = 200;
        }

        return ['incentive_share' => $incentive_share, 'message' => $message, 'code' => $code];
    }

    public function delete($id): array
    {
        $incentive_share = IncentiveShare::query()->find($id);

        if(is_null($incentive_share)){
            $message = 'no share found';
            $code = 404;
        }
        else{
            $incentive_share = $incentive_share->delete();
            $message = 'deleted successfully';
            $code = 200;
        }
        return ['incentive_share' => $incentive_share, 'message' => $message, 'code' => $code];
    }

    public function update($request, $id): array
    {

        $incentive_share = IncentiveShare::query()->find($id);

        if(!is_null($incentive_share)){
            IncentiveShare::query()->find($id)->update([
                'name' => $request['name'] ?? $incentive_share['name'],
                'amount_of_share' => $request['amount_of_share'] ?? $incentive_share['amount_of_share']
            ]);

            $incentive_share = IncentiveShare::query()->find($id);
            $message = 'updated successfully';
            $code = 200;
        }
        else{
            $message = 'no share found';
            $code = 404;
        }

        return ['incentive_share' => $incentive_share, 'message' => $message, 'code' => $code];
    }
}
