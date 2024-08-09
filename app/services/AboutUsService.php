<?php

namespace App\services;

use App\Models\AboutUs;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class AboutUsService
{
    public function edit($request): array
    {
        $user = Auth::user();

        if(!is_null($user)) {

            $about_us = AboutUs::query()->find(1);

            $about_us->update([
                'text' => $request['text'] ?? $about_us['text'],
                'employee_id' => $this->getEmployeeId($user) ?? $about_us['employee_id'],
            ]);

            $about_us = AboutUs::query()->find(1);

            $message = 'updated successfully';

            $code = 200;
        } else{
            $about_us = [];
            $message = 'invalid token';
            $code = 401;
        }

        return ['about_us' => $about_us, 'message' => $message, 'code' => $code];
    }

    public function view(): array
    {
        $about_us = AboutUs::query()->where('id', 1)->get();
        $message = 'success';
        $code = 200;
        return ['about_us' => $about_us, 'message' => $message, 'code' => $code];
    }

    private function getEmployeeId($user) : int
    {
        return Employee::query()->where('user_id', $user->id)->first()->id;
    }
}
