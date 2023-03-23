<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function() {
    // 取得使用者資訊
    Route::get('/user', function(Request $request) {
        return $request->user();
    });

    // 使用者登出
    Route::post('logout', [AuthController::class, 'logout']);
});

// 使用者登入
Route::post('login', [AuthController::class, 'login']);
