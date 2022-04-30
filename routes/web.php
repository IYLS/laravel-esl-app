<?php

use Illuminate\Support\Facades\Route;
use Facade\FlareClient\View;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProficiencyLevelController;
use App\Http\Controllers\UnitController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home
Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('auth.authenticate');

// Users Routes
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::put('/users/update/{user}', [UserController::class, 'update'])->name('users.update');
Route::get('/users/show/{user}', [UserController::class, 'show'])->name('users.show');

// Auth Router
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');

// ProficiencyLevels Routes
Route::get('/levels', [ProficiencyLevelController::class, 'index'])->name('levels.index');
Route::get('/levels/create', [ProficiencyLevelController::class, 'create'])->name('levels.create');
Route::post('/levels/store', [ProficiencyLevelController::class, 'store'])->name('levels.store');
Route::put('/levels/update/{level}', [ProficiencyLevelController::class, 'update'])->name('levels.update');
Route::get('/levels/show/{level}', [ProficiencyLevelController::class, 'show'])->name('levels.show');

// Units Routes
Route::get('/units', [UnitController::class, 'index'])->name('units.index');
Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
Route::post('/units/store', [UnitController::class, 'store'])->name('units.store');
Route::put('/units/update/{level}', [UnitController::class, 'update'])->name('units.update');
Route::get('/units/show/{level}', [UnitController::class, 'show'])->name('units.show');