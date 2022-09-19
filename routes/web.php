<?php

use Illuminate\Support\Facades\Route;
use Facade\FlareClient\View;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\FeedbackController;

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
Route::post('/units/{unit}/keywords/{keyword}/update', [KeywordController::class, 'update'])->name('keywords.update');

// Exercises Routes
Route::get('/units/{unit}/exercises', [ExerciseController::class, 'index'])->name('exercises.index');
Route::post('/units/{unit}/exercises/add', [ExerciseController::class, 'add'])->name('exercises.add');
Route::get('/exercises/{exercise}', [ExerciseController::class, 'show'])->name('exercises.show');
Route::post('/units/{unit}/exercises/store/{type}/section/{section}', [ExerciseController::class, 'store'])->name('exercises.store');
Route::get('/units/{unit}/exercises/create/{type}/section/{section}', [ExerciseController::class, 'create'])->name('exercises.create');
Route::delete('/units/{unit}/exercises/destroy/{type}/{exercise}', [ExerciseController::class, 'destroy'])->name('exercises.destroy');

// Questions Routes
Route::get('/units/{unit}/exercises/create/{type}/{exercise}/question', [QuestionController::class, 'create'])->name('questions.create');
Route::get('/units/{unit}/exercises/{exercise}/questions/show/{type}/{question}', [QuestionController::class, 'show'])->name('questions.show');
Route::post('/exercises/{exercise}/store/section/{section}/type/{type}/question', [QuestionController::class, 'store'])->name('questions.store');
Route::delete('/exercises/{exercise}/questions/destroy/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');




Route::post('/feedback/{exercise}/store', [FeedbackController::class, 'store'])->name('feedback.store');
Route::post('/feedback/{exercise}/create', [FeedbackController::class, 'create'])->name('feedback.create');
