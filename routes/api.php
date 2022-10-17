<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\ExerciseController;

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

Route::get('/migrate', function () {
    return Artisan::call('migrate');
});

Route::get('/config_cache', function () {
    Artisan::call('cache:clear');
	Artisan::call('route:cache');
 	Artisan::call('config:cache');
    Artisan::call('view:clear');
    return 'Cache clear and configured.';
});

Route::get('/link_storage', function () {
    return Artisan::call('storage:link');
});

Route::get('/migrate_fresh_seed', function () {
    return Artisan::call('migrate:fresh --seed');
});

Route::get('/seed', function () {
    return Artisan::call('db:seed');
});

Route::post('/units/{unit}/exercises/set/{exercise}', [ExerciseController::class, 'update_position'])->name('exercises.position');