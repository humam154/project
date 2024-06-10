<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminSignInRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserSignInRequest;
use App\Http\Responses\Response;
use App\services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class AuthController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function userLogin(UserSignInRequest $request): RedirectResponse|JsonResponse
    {
        $data = [];

        try {
            $data = $this->userService->userLogin($request);
            if($data['code'] == 404){
                return Response::Error($data['user'], $data['message'], $data['code']);
            }
            if($data['code'] == 300){
                return redirect()->action([AuthController::class, 'changePassword']);
            }
            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function adminLogin(AdminSignInRequest $request): JsonResponse
    {
        $data = [];

        try {
            $data = $this->userService->adminLogin($request);
            if($data['code'] == 404){
                return Response::Error($data['user'], $data['message'], $data['code']);
            }
            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function logout(){
        $data = [];

        try{
            $data = $this->userService->logout();
            if($data['code'] == 404){
                return Response::Error($data['user'], $data['message'], $data['code']);
            }
            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function changePassword(ChangePasswordRequest $request){
        $data = [];

        try {
            $data = $this->userService->changePassword($request);
            if($data['code'] == 404){
                return Response::Error($data['user'], $data['message'], $data['code']);
            }
            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch (Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }
}
