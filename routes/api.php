<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

Route::post('/login', [ApiController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user-profile', [ApiController::class, 'userProfile']);
    Route::post('/logout', [ApiController::class, 'logout']);
    Route::post('/userThreeFactorCode', [ApiController::class, 'userThreeFactorCode']);
});
