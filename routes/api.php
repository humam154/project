<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SalariesController;
use App\Http\Controllers\SalaryGradesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function (){

    Route::post('/userLogin', 'userLogin')->name('user.login');

    Route::post('/adminLogin', 'adminLogin')->name('admin.login');

    Route::group(['middleware' => 'auth:sanctum'], function (){
       Route::get('/logout', 'logout')->name('all.logout');
       Route::post('/change', 'changePassword')->name('changePassword');
    });

});

Route::prefix('grades')->controller(SalaryGradesController::class)->group(function (){
        Route::get('/', 'get')->name('grades.get');
        Route::post('/', 'create')->name('grades.create');
        Route::post('/{id}', 'update')->name('grades.update');
        Route::delete('/{id}', 'delete')->name('grades.delete');
});


Route::prefix('salary')->controller(SalariesController::class)->group(function (){
    Route::get('/', 'get')->name('salary.get');
    Route::post('/', 'create')->name('salary.create');
    Route::post('/{id}', 'update')->name('salary.update');
    Route::delete('/{id}', 'delete')->name('salary.delete');
});
