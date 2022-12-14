<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\UserController;

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

Route::name('api.')->group(function () {
  Route::prefix('auth')->name('auth.')->group(function () {
    // LOGIN
    Route::post('login', [ AuthController::class, 'attempLogin' ])->name('login');
  });

  Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
      Route::get('user', [ AuthController::class, 'showAuthenticatedUser' ])->name('user.show');
    });

    Route::prefix('settings')->name('settings.')->group(function () {
      Route::prefix('groups')->name('groups.')
        ->middleware('can:viewAny,App\Models\Group')
        ->group(function () {
          Route::get('/', [ GroupController::class, 'index' ])->name('index');
          Route::post('/', [ GroupController::class, 'store' ])->name('store');
          Route::patch('/{group}', [ GroupController::class, 'update' ])->name('update');
          Route::delete('/{group}', [ GroupController::class, 'destroy' ])->name('destroy');
        });

      Route::prefix('users')->name('users.')
        ->middleware('can:viewAny,App\Models\User')
        ->group(function () {
          Route::get('/', [ UserController::class, 'index' ])->name('index');
        });
    });
  });
});
