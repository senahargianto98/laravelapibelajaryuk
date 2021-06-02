<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsTestController;
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
        Route::get('product/test/{id}', [ProductsTestController::class, 'edit']);
        Route::delete('products/{product}  ', [ProductsTestController::class, 'destroy']);        
        Route::get('detail/{id}', [ProductsTestController::class, 'detail']);
        Route::post('product/post/test', [ProductsTestController::class, 'store']);
        Route::post('product/update/test', [ProductsTestController::class, 'update']);
    });
});