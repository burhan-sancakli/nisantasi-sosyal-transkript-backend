<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ApplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;

Route::get('/message', function (Request $request) {
    return "hallo brudimongo :^)";
});

Route::controller(AuthController::class)->group(function () {
    // CORE
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

    // MISCELLANEOUS
    Route::post('get-student', 'getStudent')->withoutMiddleware(['auth:api']);
    Route::post('check-sanalkampus', 'checkSanalkampus')->withoutMiddleware(['auth:api']);
});

Route::controller(TodoController::class)->group(function () {
    Route::get('todos', 'index');
    Route::post('todo', 'store');
    Route::get('todo/{id}', 'show');
    Route::put('todo/{id}', 'update');
    Route::delete('todo/{id}', 'destroy');
}); 
Route::controller(ActivityController::class)->group(function () {
    Route::get('/activities', 'index');
}); 
Route::controller(ApplicationController::class)->group(function () {
    Route::get('/applications', 'index');
    Route::post('/applications', 'store');
    Route::post('/applications/{id}/accept', 'accept');
    Route::post('/applications/{id}/reject', 'reject');
    Route::post('/applications/{id}/object', 'object');
    Route::get('/applications/{id}/download', 'ApplicationController@downloadFile');
}); 

Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index');
    Route::get('/user/{id}', [UserController::class, 'getUserDetails']);
}); 




