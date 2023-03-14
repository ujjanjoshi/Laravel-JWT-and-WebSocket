<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
Route::get('/markasread/{name}/{id}', [NotificationController::class, 'MarkasRead']);
Route::get('/schoollogin',  function () {
    return view('schoologin');
});

