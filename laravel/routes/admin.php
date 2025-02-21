<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreInformationController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'admin'

], function () {

    Route::post('login', [AuthController::class,'login']);
    Route::post('testRegister', [AuthController::class,'testRegister']);
    Route::post('testNameAndMobileStore', [StoreInformationController::class,'testNameAndMobileStore']); // التحقق من رقم المتجر ما اذ كان موجود سابقا
    Route::post('register', [AuthController::class,'register']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);
    Route::post('getReport', [AuthController::class,'getReport']);
    Route::post('store/information', [StoreInformationController::class,'store']);
    Route::get('tokenIsFound', [AuthController::class, 'tokenIsFound']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('changePassword', [AuthController::class, 'changePassword']);
    
    
    Route::middleware('auth:admin')->group(function () {
        // get current admin
        Route::post('getOwner', [AdminController::class, 'getOwner']);

        //get all admins 
        Route::post('getAllAdmins', [AdminController::class, 'getAllAdmins']);
    });
    
});

// delete,update,edit,create and show admins
Route::resource('admin',AdminController::class)->middleware('auth:admin');
// Route::resource('users',UsersController::class)->middleware('auth:trader');