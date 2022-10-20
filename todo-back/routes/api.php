<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TaskController;

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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});



Route::middleware('auth:sanctum')->group( function () {
    // Route::resource('tasks', TaskController::class);
});
Route::resource('tasks', TaskController::class);
Route::post('updateAllTasks', [TaskController::class, 'updateAllTasks']);

// Route::middleware('auth:sanctum')->get('/tasks', function (Request $request) {
//     return $request->task();
// });

// Route::group(['middleware' => ['auth:sanctum']], function () {
//     // Route::post('/logout', [AuthController::class, 'logout']);
//     Route::apiResource('tasks',TaskController::class);
// });

