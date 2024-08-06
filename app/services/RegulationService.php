<?php

namespace App\services;

use App\Models\Regulation;

class RegulationService
{

    public function create($request): array
    {

        if(Regulation::query()->count() != 0) {

            $all_regulation = Regulation::query()->update([
                'points' => 0
            ]);
        }
        $regulation  = Regulation::query()->create([
            'name' => $request['name'],
            'points' => 0
        ]);

        $all_regulation = Regulation::query()->update([
            'points' => 100 / Regulation::count()
        ]);

        $regulation = Regulation::query()->find($regulation['id']);
        return ['regulation' => $regulation, 'message' => 'created successfully', 'code' => 200];
    }

    public function get(): array
    {
        $regulation = Regulation::query()->get();

        if(is_null($regulation)){
            $message = 'no regulations found';
            $code = 404;
        }
        else {
            $message = 'success';
            $code = 200;
        }

        return ['regulation' => $regulation, 'message' => $message, 'code' => $code];
    }

    public function delete($id): array
    {

        $regulation = Regulation::query()->find($id);

        if(is_null($regulation)){
            $message = 'no regulation found';
            $code = 404;
        }
        else{
            $regulation = $regulation->delete();
            $message = 'deleted successfully';
            $code = 200;

            $all_points = Regulation::query()->update([
                'points' => 100 / Regulation::count()
            ]);
        }

        return ['regulation' => $regulation, 'message' => $message, 'code' => $code];
    }

    public function update($request, $id): array
    {

        $regulation = Regulation::query()->find($id);
        $full = ((Regulation::query()->sum('points')) - $regulation['points']) + ($request['points']);
        if($full > 100){
            $message = 'points bigger than 100';
            $code = 422;
            return ['regulation' => [], 'message' => $message, 'code' => $code];
        }



        if(!is_null($regulation)){
            Regulation::query()->find($id)->update([
                'name' => $request['name'] ?? $regulation['name'],
                'points' => $request['points'] ?? $regulation['points']
            ]);

            $regulation = Regulation::query()->find($id);
            $message = 'updated successfully';
            $code = 200;
        }
        else{
            $message = 'no regulation found';
            $code = 404;
        }

        return ['regulation' => $regulation, 'message' => $message, 'code' => $code];
    }
}
