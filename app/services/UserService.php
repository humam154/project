<?php

namespace App\services;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function userLogin($request): array|RedirectResponse
    {
        $user = User::query()->where('email', $request['email'])->first();

        if(!is_null($user)) {
            if ($request['password'] == 'password') {
                return redirect()->action([UserService::class, 'changePassword']);
            }
            if (!Auth::attempt($request->only(['email', 'password']))){
                $message = 'user email and password does not match our record';
                $code = 401;
            }
            else{
                $user['token'] = $user->createToken("token")->plainTextToken;
                $message = 'user logged in successfully';
                $code = 200;
            }
        }
        else{
            $message = 'user not found';
            $code = 404;
        }

        return ['user' => $user, 'message' => $message, 'code' => $code];
    }

    public function changePassword($request): array
    {
        $user = User::query()->where('email', $request['email'])->first();

       if(!is_null($user)) {

           if (!Hash::check($request->current_password, $user->password)) {
               $message = 'password is incorrect';
               $code = 400;
           } else {
               $user->password = Hash::make($request->new_password);
               $user->save();
               $message = 'password changed successfully';
               $code = 200;
           }
       }
       else{
           $message = 'user not found';
           $code = 404;
       }

        return ['user' => $user, 'message' => $message, 'code' => $code];
    }
}
