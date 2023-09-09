<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
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
Route::prefix('auth')->group(static function () {
    Route::post('register', [RegistrationController::class, 'register'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::prefix('{tenant:subdomain}/projects')->name('project.')->group(static function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::get('/{project:uuid}', [ProjectController::class, 'show'])->name('show');
        Route::put('/{project:uuid}', [ProjectController::class, 'update'])->name('update');
    });

    Route::prefix('{tenant:subdomain}/users')->name('user.')->group(static function () {
        Route::post('/', [UserController::class, 'store'])->name('store');
    });
});
