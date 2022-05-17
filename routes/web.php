<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('dashboard',[AdminController::class, 'showDashboard']);

Route::get('login',[AuthenticationController::class, 'showLogin']);

Route::get('register',[AuthenticationController::class, 'showRegister']);

Auth::routes();

// Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
// });
// Route::get('roles',[AuthenticationController::class, 'showroles']);

