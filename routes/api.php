<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| List of application routes/endpoints
|
*/

Route::prefix('v1')->group(function(){
    Route::post('user', [\App\Http\Controllers\UserController::class, 'create']);
    Route::get('user/{id}', [\App\Http\Controllers\UserController::class, 'index']);
});