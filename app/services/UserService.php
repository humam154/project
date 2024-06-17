<?php

namespace App\services;

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
        $user = Auth::user();

        if(!is_null($user)) {

           if (!Hash::check($request->current_password, $user->password)){
               $message = 'password is incorrect';
               $code = 400;
           }
           else {
               $user->password = Hash::make($request->password);
               $user->save();
               $message = 'password changed successfully';
               $code = 200;
               $user['token'] = $user->createToken("token")->plainTextToken;
           }
       }
       else{
           $message = 'user not found';
           $code = 404;
       }

        return ['user' => $user, 'message' => $message, 'code' => $code];
    }

    public function logout(): array
    {
        $user = Auth::user();

        if(!is_null($user)){
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            $message = 'logged out successfully';
            $code = 200;
        }
        else{
            $message = 'invalid token';
            $code = 404;
        }

        return ['user' => $user, 'message' => $message, 'code' => $code];
    }

    public function adminLogin($request): array
    {
        $user = User::query()
            ->where('email', $request['email'])
            ->first();

        if(!is_null($user)){
            if(!Auth::attempt($request->only(['email', 'password']))){
                $message = 'user email and password does not match our record';
                $code = 401;
            }
            else{
                $user = $this->appendRolesAndPermissions($user);
                $user['token'] = $user->createToken("token")->plainTextToken;
                $message = 'user logged in successfully';
                $code = 200;
            }
        }
        else {
            $message = 'user not found';
            $code = 404;
        }

        return ['user' => $user, 'message' => $message, 'code' => $code];
    }

    private function appendRolesAndPermissions($user){
        $roles = [];

        foreach ($user->roles as $role){
            $roles[] = $role->name;
        }

        unset($user['roles']);
        $user['roles'] = $roles;

        $permissions = [];
        foreach ($user->permissions as $permission){
            $permissions[] = $permission->name;
        }
        unset($user['permissions']);
        $user['permissions'] = $permissions;

        return $user;
    }
}
