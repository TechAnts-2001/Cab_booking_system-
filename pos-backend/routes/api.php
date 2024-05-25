<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/register', [UserController::class, 'store']);

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login',[AuthController::class,'login']);
    Route::post('logout',[AuthController::class,'logout']);
    Route::post('refresh',[AuthController::class,'refresh']);
    Route::post('me',[AuthController::class,'me']);
});
Route::group(['middleware' => 'auth'],function($router){
    Route::group(['prefix' => 'v1/customers'],function($router){
        Route::get('/list',[CustomerController::class,'index']);
        Route::post('/',[CustomerController::class,'store']);
        Route::get('/{id}',[CustomerController::class,'show']);
        Route::put('/{id}',[CustomerController::class,'update']);
        Route::delete('/{id}',[CustomerController::class,'destroy']);
    });
});
