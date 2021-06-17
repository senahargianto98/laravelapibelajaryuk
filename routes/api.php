<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

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

function common(string $scope)
{ 
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('user/{id}', [AuthController::class, 'index']);
    Route::post('student/post', [StudentController::class, 'store']);
    Route::get('profile', [ProfileController::class, 'index']);
    Route::get('meet/{id}', [AuthController::class, 'meet']);

    Route::middleware(['auth:sanctum', $scope])->group(function () {
        // Route::get('user/test', [AuthController::class, 'test']);
        Route::get('user', [AuthController::class, 'test']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::put('users/info', [AuthController::class, 'updateInfo']);
        Route::put('users/password', [AuthController::class, 'updatePassword']);
    });
}

//Admin
Route::prefix('admin')->group(function () {
    common('scope.admin');
    Route::middleware(['auth:sanctum', 'scope.admin'])->group(function () { 
        Route::get('today', [AuthController::class, 'today']);       
        Route::post('profile/post', [ProfileController::class, 'store']);
        Route::post('profile/edit', [ProfileController::class, 'update']);
        Route::get('profile/edit/{id}', [ProfileController::class, 'edit']);
    });
});