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
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\SectionController;

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
Route::delete('/users/delete/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Auth Router
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');

// Groups Routes
Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
Route::post('/groups/store', [GroupController::class, 'store'])->name('groups.store');
Route::put('/groups/update/{group}', [GroupController::class, 'update'])->name('groups.update');
Route::get('/groups/show/{group}', [GroupController::class, 'show'])->name('groups.show');
Route::delete('/groups/delete/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');

// Units Routes
Route::get('/units', [UnitController::class, 'index'])->name('units.index');
Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
Route::post('/units/store', [UnitController::class, 'store'])->name('units.store');
Route::put('/units/update/{unit}', [UnitController::class, 'update'])->name('units.update');
Route::get('/units/show/{unit}', [UnitController::class, 'show'])->name('units.show');
Route::delete('/units/delete/{unit}', [UnitController::class, 'destroy'])->name('units.destroy');


// Strudent module Routes
Route::get('/student/level_selection', [StudentController::class, 'level_selection'])->name('student.level_selection');
Route::post('/student/dashboard', [StudentController::class, 'show'])->name('student.show');

// Keywords Routes
Route::get('/units/{unit}/keywords', [KeywordController::class, 'index'])->name('keywords.index');
Route::post('/units/{unit}/keywords/store', [KeywordController::class, 'store'])->name('keywords.store');
Route::delete('/keywords/{keyword}/destroy', [KeywordController::class, 'destroy'])->name('keywords.destroy');
Route::post('/units/{unit}/keywords/{keyword}/update', [KeywordController::class, 'update'])->name('keywords.update');

// Exercises Routes
Route::get('/exercises/{exercise}', [ExerciseController::class, 'show'])->name('exercises.show');
Route::get('/units/{unit}/exercises', [ExerciseController::class, 'index'])->name('exercises.index');
Route::post('/units/{unit}/exercises/add', [ExerciseController::class, 'add'])->name('exercises.add');
Route::post('/units/{unit}/exercises/store/{type}/section/{section}', [ExerciseController::class, 'store'])->name('exercises.store');
Route::get('/units/{unit}/exercises/create/{type}/section/{section}', [ExerciseController::class, 'create'])->name('exercises.create');
Route::delete('/units/{unit}/exercises/destroy/{type}/{exercise}', [ExerciseController::class, 'destroy'])->name('exercises.destroy');
Route::put('/units/{unit}/exercises/update/{type}/{exercise}', [ExerciseController::class, 'update'])->name('exercises.update');

// Questions Routes
Route::get('/units/{unit}/exercises/create/{type}/{exercise}/question', [QuestionController::class, 'create'])->name('questions.create');
Route::get('/units/{unit}/exercises/{exercise}/questions/show/{type}/{question}', [QuestionController::class, 'show'])->name('questions.show');
Route::post('/exercises/{exercise}/store/section/{section}/type/{type}/question', [QuestionController::class, 'store'])->name('questions.store');
Route::delete('/exercises/{exercise}/questions/destroy/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

// Feedback Routes
Route::post('/feedback/{exercise}/store/', [FeedbackController::class, 'store'])->name('feedback.store');
Route::post('/feedback/{exercise}/create', [FeedbackController::class, 'create'])->name('feedback.create');
Route::delete('/feedback/{exercise}/destroy', [FeedbackController::class, 'destroy'])->name('feedback.destroy');


// Forum Routes
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::post('/forum/comment/store', [ForumController::class, 'store'])->name('forum.store');
Route::get('/forum/comment/{comment}/show', [ForumController::class, 'show'])->name('forum.show');
Route::delete('/forum/comment/{comment}/delete', [ForumController::class, 'destroy'])->name('forum.destroy');

// Reply Routes
Route::post('/forum/comment/{comment}/reply/store', [ReplyController::class, 'store'])->name('replies.store');

// Sections Routes
Route::get('/units/{unit}/sections', [SectionController::class, 'index'])->name('sections.index');
Route::post('/units/{unit}/sections/store', [SectionController::class, 'store'])->name('sections.store');
Route::delete('/sections/{section}/destroy', [SectionController::class, 'destroy'])->name('sections.destroy');
Route::post('/units/{unit}/sections/{keyword}/update', [SectionController::class, 'update'])->name('sections.update');