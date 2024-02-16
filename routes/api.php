<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SalleController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('salle', \App\Http\Controllers\Api\SalleController::class);


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');
});


// Route::apiResource('salles', SalleController::class);

Route::prefix('salles')->group(function () {
    Route::get('/', [SalleController::class, 'index'])
        ->middleware(['auth', 'role:visiteur'])
        ->name('salles.index ');
    Route::get('/{id}', [SalleController::class, 'show'])->where('id', '[0-9]+')
        ->middleware(['auth', 'role:view-salle'])
        ->name('salles.show');
    Route::put('/{id}', [SalleController::class, 'update'])->where('id', '[0-9]+')
        ->middleware(['auth', 'role:edit-salle'])
        ->name('salles.update');
    Route::post('/', [SalleController::class, 'store'])
        ->middleware(['auth', 'role:create-salle'])
        ->name('salles.store');
    Route::delete('/{id}', [SalleController::class, 'destroy'])->where('id', '[0-9]+')
        ->middleware(['auth', 'role:admin'])
        ->name('salles.destroy');
});

Route::prefix('users')->group(function () {
    Route::delete('/{id}', [UserController::class, 'destroy'])->where('id', '[0-9]+')
        ->middleware(['auth', 'role:admin'])
        ->name('users.destroy ');
});
