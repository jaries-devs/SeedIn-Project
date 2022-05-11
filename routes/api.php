<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthenticationController;

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
session_start();
//Route::resource('admins', AdminController::class);

//Public Routes
Route::group(['middleware' => ['web']], function () {
    // your routes here
});
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('/admins', [AdminController::class, 'index']);
Route::get('/admins/{id}', [AdminController::class, 'show']);
Route::get('/admins/search/{name}', [AdminController::class, 'search']);



//Protected Routes
Route::group(['middleware'=> ['auth:sanctum']], function () {
    Route::post('/admins', [AdminController::class, 'store']);
    Route::get('/admins/{id}', [AdminController::class, 'update']);
    Route::delete('/admins/{id}', [AdminController::class, 'destroy']);
    Route::post('/logout',[AuthenticationController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
