<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function (){

    Route::post('/userLogin', 'userLogin')->name('user.login');

    Route::post('/adminLogin', 'adminLogin')->name('admin.login');

    Route::group(['middleware' => 'auth:sanctum'], function (){
       Route::get('/logout', 'logout')->name('logout');
       Route::post('/change', 'changePassword')->name('changePassword');
    });

});
