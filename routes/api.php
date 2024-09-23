<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout']);



Route::post('/create', [LoginController::class, 'create'])->middleware('auth:sanctum');
Route::post('/view', [LoginController::class, 'view'])->middleware('auth:sanctum');


//->middleware('auth:sanctum')