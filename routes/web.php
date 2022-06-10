<?php

use Illuminate\Support\Facades\Route;
use Facade\FlareClient\View;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\ExcerciseController;

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

// Groups Routes
Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
Route::post('/groups/store', [GroupController::class, 'store'])->name('groups.store');
Route::put('/groups/update/{group}', [GroupController::class, 'update'])->name('groups.update');
Route::get('/groups/show/{group}', [GroupController::class, 'show'])->name('groups.show');

// Units Routes
Route::get('/units', [UnitController::class, 'index'])->name('units.index');
Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
Route::post('/units/store', [UnitController::class, 'store'])->name('units.store');
Route::put('/units/update/{unit}', [UnitController::class, 'update'])->name('units.update');
Route::get('/units/show/{unit}', [UnitController::class, 'show'])->name('units.show');

// Strudent module Routes
Route::get('/student/level_selection', [StudentController::class, 'level_selection'])->name('student.level_selection');
Route::get('/student/dashboard/{unit}', [StudentController::class, 'show'])->name('student.show');

// Keywords Routes
Route::get('/units/{unit}/keywords', [KeywordController::class, 'index'])->name('keywords.index');
Route::post('/units/{unit}/keywords/store', [KeywordController::class, 'store'])->name('keywords.store');
Route::delete('/units/{unit}/keywords/{keyword}/destroy', [KeywordController::class, 'destroy'])->name('keywords.destroy');
Route::delete('/units/{unit}/keywords/{keyword}/update', [KeywordController::class, 'update'])->name('keywords.update');


// Excercises Routes
Route::get('/units/{unit}/excercises', [ExcerciseController::class, 'index'])->name('excercises.index');
Route::post('/units/{unit}/excercises/create', [ExcerciseController::class, 'create'])->name('excercises.create');

// Multiplce choice Routes
Route::get('/units/{unit}/excercises/multiple-choice/create', [MultipleChoiceController::class, 'create'])->name('multiple_choice.create');
Route::post('/units/{unit}/excercises/multiple-choice/store', [MultipleChoiceController::class, 'store'])->name('multiple_choice.store');

// Meet the character Routes
Route::get('/units/{unit}/excercises/meet-the-characters/create', [MeetCharactersController::class, 'create'])->name('meet_characters.create');
Route::post('/units/{unit}/excercises/multiple-choice/store', [MeetCharactersController::class, 'store'])->name('meet_characters.store');

// Open answer Routes
Route::get('/units/{unit}/excercises/open-answer/create', [OpenAnswerController::class, 'create'])->name('open_answer.create');
Route::post('/units/{unit}/excercises/open-answer/store', [OpenAnswerController::class, 'store'])->name('open_answer.store');

// Drag and Drop Routes
Route::get('/units/{unit}/excercises/drag-and-drop/create', [DragAndDropController::class, 'create'])->name('drag_and_drop.create');
Route::post('/units/{unit}/excercises/drag-and-drop/store', [DragAndDropController::class, 'store'])->name('drag_and_drop.store');
