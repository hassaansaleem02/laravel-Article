<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;

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

Route::Get('/showall', [ArticleController::class, 'index']);
Route::Get('/show/{id}', [ArticleController::class, 'show']);
Route::get('/search/{name}', [ArticleController::class, 'search']);
Route::Post('/register', [AuthController::class, 'register']);
Route::Post('/login', [AuthController::class, 'login']);



Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::Post('/store', [ArticleController::class, 'store']);
    Route::delete('/delete/{id}', [ArticleController::class, 'destroy']);
    Route::put('/update/{id}', [ArticleController::class, 'update']);
    Route::Post('/logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
