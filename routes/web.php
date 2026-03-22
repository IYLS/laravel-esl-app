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
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\GlossedWordsController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeaderboardController;

// Home
Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('auth.authenticate');

// Users Routes
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::put('/users/update/{user}', [UserController::class, 'update'])->name('users.update');
Route::post('/users/update-password/{user}', [UserController::class, 'updatePassword'])->name('users.update_password');
Route::get('/users/show/{user}', [UserController::class, 'show'])->name('users.show');
Route::delete('/users/delete/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::post('/users/filter', [UserController::class, 'executeFilter'])->name('users.execute_filter');

// Auth Router
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');

// Profile Routes
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

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
Route::post('/units/duplicate/{unit}', [UnitController::class, 'duplicate'])->name('units.duplicate');
Route::delete('/units/delete/{unit}', [UnitController::class, 'destroy'])->name('units.destroy');

// Student module Routes
Route::get('/student/welcome', [StudentController::class, 'welcome'])->name('student.welcome');
Route::get('/student/level_selection', [StudentController::class, 'level_selection'])->name('student.level_selection');
Route::post('/student/select/unit', [StudentController::class, 'select'])->name('student.select');
Route::get('/student/dashboard/{unit}', [StudentController::class, 'show'])->name('student.show');

// Leaderboard Routes
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

// Keywords Routes
Route::get('/units/{unit}/keywords', [KeywordController::class, 'index'])->name('keywords.index');
Route::post('/units/{unit}/keywords/store', [KeywordController::class, 'store'])->name('keywords.store');
Route::delete('/keywords/{keyword}/destroy', [KeywordController::class, 'destroy'])->name('keywords.destroy');
Route::post('/units/{unit}/keywords/{keyword}/update', [KeywordController::class, 'update'])->name('keywords.update');

// Exercises Routes
Route::get('/exercises/{exercise}', [ExerciseController::class, 'show'])->name('exercises.show');
Route::get('/units/{unit}/exercises', [ExerciseController::class, 'index'])->name('exercises.index');
Route::get('/units/{unit}/exercises/add-form/{exercise_type}/{section}', [ExerciseController::class, 'addForm'])->name('exercises.add-form');
Route::get('/units/{unit}/exercises/metacognition-form/{section}/{underscore_type}', [ExerciseController::class, 'metacognitionForm'])->name('exercises.metacognition-form');
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
Route::put('/questions/update/{question}', [QuestionController::class, 'update'])->name('questions.update');

// Feedback Routes
Route::post('/feedback/{exercise}/store/', [FeedbackController::class, 'store'])->name('feedback.store');
Route::post('/feedback/{exercise}/create', [FeedbackController::class, 'create'])->name('feedback.create');
Route::get('/feedback/{exercise}/edit', [FeedbackController::class, 'edit'])->name('feedback.edit');
Route::put('/feedback/{exercise}/update', [FeedbackController::class, 'update'])->name('feedback.update');
Route::delete('/feedback/{exercise}/destroy', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

// Forum Routes
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::post('/forum/comment/store', [ForumController::class, 'store'])->name('forum.store');
Route::get('/forum/comment/{comment}/show', [ForumController::class, 'show'])->name('forum.show');
Route::delete('/forum/comment/{comment}/delete', [ForumController::class, 'destroy'])->name('forum.destroy');

// Reply Routes
Route::post('/forum/comment/{comment}/reply/store', [ReplyController::class, 'store'])->name('replies.store');

// Reaction Routes (AJAX)
Route::post('/forum/comment/{comment}/reaction', [ReactionController::class, 'comment'])->name('reactions.comment');
Route::post('/forum/reply/{reply}/reaction', [ReactionController::class, 'reply'])->name('reactions.reply');

// Sections Routes
Route::get('/units/{unit}/sections', [SectionController::class, 'index'])->name('sections.index');
Route::post('/units/{unit}/sections/store', [SectionController::class, 'store'])->name('sections.store');
Route::delete('/sections/{section}/destroy', [SectionController::class, 'destroy'])->name('sections.destroy');
Route::post('/units/{unit}/sections/{section}/update', [SectionController::class, 'update'])->name('sections.update');

// Tracking Routes
Route::get('tracking/index', [TrackingController::class, 'index'])->name('tracking.index');
Route::post('tracking/store/{exercise}/{user}', [TrackingController::class, 'store'])->name('tracking.store');
Route::get('/tracking/show/{tracking}', [TrackingController::class, 'show'])->name('tracking.show');
Route::post('/tracking/filter', [TrackingController::class, 'executeFilter'])->name('tracking.execute_filter');
Route::post('/tracking/exportData', [TrackingController::class, 'exportData'])->name('tracking.export_data');

// Set positions
Route::post('/exercises/{unit}/set_positions', [ExerciseController::class, 'setPositions'])->name('exercises.positions');
Route::post('/sections/{unit}/set_positions', [SectionController::class, 'setPositions'])->name('sections.positions');
Route::post('/questions/set_positions', [QuestionController::class, 'setPositions'])->name('questions.positions');

// FAQ Routes
Route::get('/faq/student', [FAQController::class, 'student'])->name('faq.student');
Route::get('/faq/teacher', [FAQController::class, 'teacher'])->name('faq.teacher');
Route::post('/units/set_positions', [UnitController::class, 'setPositions'])->name('units.positions');

// GlossedWords Routes
Route::get('/units/{unit}/glossed_words', [GlossedWordsController::class, 'index'])->name('glossed_words.index');
Route::post('/units/{unit}/glossed_words/store', [GlossedWordsController::class, 'store'])->name('glossed_words.store');
Route::delete('/glossed_words/{word}/destroy', [GlossedWordsController::class, 'destroy'])->name('glossed_words.destroy');
Route::post('/units/{unit}/glossed_words/{word}/update', [GlossedWordsController::class, 'update'])->name('glossed_words.update');