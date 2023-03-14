<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\NotificationController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/overallnotice', [NotificationController::class, 'overallnotice']);
    Route::get('/specificnotice', [NotificationController::class, 'Specificnotice']);
    Route::get('/specificclassnotice', [NotificationController::class, 'Specificclass']);
    Route::get('/billprint', [NotificationController::class, 'BillAdded']);
    Route::get('/resultpublished', [NotificationController::class, 'ResultPublished']);
    Route::get('/markasread', [NotificationController::class, 'MarkasRead']);


//    Route::group(['middleware' => 'auth:api'], function () {
//        Route::post('/profile', [AuthController::class, 'profile']);
//        Route::post('/logout', [AuthController::class, 'logout']);
//        Route::post('/createtodo', [TodoController::class, 'store']);
//        Route::put('/edittodo', [TodoController::class, 'updatetodo']);
//        Route::delete('/deletetodo', [TodoController::class, 'deletetodo']);
//        Route::get('/search', [TodoController::class, 'search']);
//        Route::get('/searchclass', [TodoController::class, 'classSearch']);
//
//
//        Route::get('/searchownwork', [TodoController::class, 'search_own_work']);
//    });
//    Route::get('/ws', function () {
//        return view('websocket');
//    });

//    function () {
//        return auth()->user;
//        event(new \App\Events\OverallNotice());
//    });
//    Route::get('/billgenerated', function () {
//        $a=event(new \App\Events\OverallNotice());
//        return $a;
//    });
//    Route::view('/{path?}','websocket');
//    Route::get('/ws2', function () {
//        return view('websocket2');
//    });
});

