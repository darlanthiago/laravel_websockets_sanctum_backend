<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'user'], function () {

    Route::post('/register', [UserController::class, 'store']);

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::get('/', [UserController::class, 'show']);
        Route::get('/test', function () {

            return "OK";
        })->middleware('sanctum.abilities:admin');
    });
});

Route::group(['prefix' => 'auth'], function () {

    Route::post('login', [AuthController::class, 'store']);

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::delete('/logout', [AuthController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'message', 'middleware' => ['auth:sanctum']], function () {

    Route::post('/', [MessageController::class, 'store']);

    Route::get('/', [MessageController::class, 'index']);
});

Broadcast::routes(["middleware" => ["auth:sanctum"]]);
