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
use App\Http\Controllers\VoiceRecognitionQuestionController;
use App\Http\Controllers\VoiceRecognitionExcerciseController;
use App\Http\Controllers\DragAndDropExcerciseController;
use App\Http\Controllers\DragAndDropQuestionController;
use App\Http\Controllers\MultipleChoiceExcerciseController;
use App\Http\Controllers\MultipleChoiceQuestionController;
use App\Http\Controllers\OpenEndedExcerciseController;
use App\Http\Controllers\OpenEndedQuestionController;
use App\Http\Controllers\FillInTheGapsExcerciseController;
use App\Http\Controllers\FillInTheGapsQuestionController;


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



// Excercises Routes
Route::get('/units/{unit}/excercises', [ExcerciseController::class, 'index'])->name('excercises.index');
Route::post('/units/{unit}/excercises/add', [ExcerciseController::class, 'add'])->name('excercises.add');

// Voice recognition  Routes
Route::get('/units/{unit}/excercises/create/voice_recognition/{section}/{excercise}', [VoiceRecognitionExcerciseController::class, 'create'])->name('excercises.voice_recognition.create');
Route::post('/units/{unit}/excercises/store/voice_recognition/{section}', [VoiceRecognitionExcerciseController::class, 'store'])->name('excercises.voice_recognition.store');
Route::delete('/units/{unit}/excercises/destroy/{excercise}', [VoiceRecognitionExcerciseController::class, 'destroy'])->name('excercises.voice_recognition.destroy');
Route::get('/units/{unit}/excercises/show/{excercise}', [VoiceRecognitionExcerciseController::class, 'show'])->name('excercises.voice_recognition.show');

Route::get('/units/{unit}/excercises/create/voice_recognition/{excercise}/question', [VoiceRecognitionQuestion::class, 'create'])->name('questions.voice_recognition_question.create');
Route::post('/units/{unit}/excercises/store/voice_recognition/{section}/{excercise}/question', [VoiceRecognitionQuestionController::class, 'store'])->name('questions.voice_recognition.store');
Route::delete('/units/{unit}/excercises/destroy/{excercise}/{question}', [VoiceRecognitionQuestionController::class, 'destroy'])->name('questions.voice_recognition.destroy');
Route::get('/units/{unit}/excercises/{excercise}/questions/show/{question}', [VoiceRecognitionQuestionController::class, 'show'])->name('questions.voice_recognition.show');

// Multiple Choice Routes
Route::get('/units/{unit}/excercises/create/multiple_choice/{section}', [MultipleChoiceExcerciseController::class, 'create'])->name('excercises.multiple_choice.create');
Route::post('/units/{unit}/excercises/store/multiple_choice/{section}', [MultipleChoiceExcerciseController::class, 'store'])->name('excercises.multiple_choice.store');
Route::delete('/units/{unit}/excercises/destroy/{excercise}', [MultipleChoiceExcerciseController::class, 'destroy'])->name('excercises.multiple_choice.destroy');
Route::get('/units/{unit}/excercises/show/{excercise}', [MultipleChoiceExcerciseController::class, 'show'])->name('excercises.multiple_choice.show');

Route::get('/units/{unit}/excercises/create/multiple_choice/{excercise}/question', [MultipleChoiceQuestionController::class, 'create'])->name('questions.multiple_choice_question.create');
Route::post('/units/{unit}/excercises/store/multiple_choice/{excercise}/question', [MultipleChoiceQuestionController::class, 'store'])->name('questions.multiple_choice_question.store');
Route::delete('/units/{unit}/excercises/destroy/{excercise}/{question}', [MultipleChoiceQuestionController::class, 'destroy'])->name('questions.multiple_choice.destroy');
Route::get('/units/{unit}/excercises/{excercise}/questions/show/{question}', [MultipleChoiceQuestionController::class, 'show'])->name('questions.multiple_choice.show');

// Drag and drop Routes
Route::get('/units/{unit}/excercises/create/{section}/{excercise}', [DragAndDropExcerciseController::class, 'create'])->name('excercises.drag_and_drop.create');
Route::post('/units/{unit}/excercises/store/{section}', [DragAndDropExcerciseController::class, 'store'])->name('excercises.drag_and_drop.store');
Route::delete('/units/{unit}/excercises/destroy/{excercise}', [DragAndDropExcerciseController::class, 'destroy'])->name('excercises.drag_and_drop.destroy');
Route::get('/units/{unit}/excercises/show/{excercise}', [DragAndDropExcerciseController::class, 'show'])->name('excercises.drag_and_drop.show');

Route::get('/units/{unit}/excercises/create/{excercise}/question', [DragAndDropQuestionController::class, 'create'])->name('questions.drag_and_drop.create');
Route::post('/units/{unit}/excercises/store/{excercise}/question', [DragAndDropQuestionController::class, 'store'])->name('questions.drag_and_drop.store');
Route::delete('/units/{unit}/excercises/destroy/{excercise}/{question}', [DragAndDropQuestionController::class, 'destroy'])->name('questions.drag_and_drop.destroy');
Route::get('/units/{unit}/excercises/{excercise}/questions/show/{question}', [DragAndDropQuestionController::class, 'show'])->name('questions.drag_and_drop.show');

// Open ended Routes
Route::get('/units/{unit}/excercises/create/open_ended/{section}/{excercise}', [OpenEndedExcerciseController::class, 'create'])->name('excercises.open_ended.create');
Route::post('/units/{unit}/excercises/store/open_ended/{section}', [OpenEndedExcerciseController::class, 'store'])->name('excercises.open_ended.store');
Route::delete('/units/{unit}/excercises/destroy/{excercise}', [OpenEndedQuestionController::class, 'destroy'])->name('excercises.open_ended.destroy');
Route::get('/units/{unit}/excercises/show/{excercise}', [OpenEndedQuestionController::class, 'show'])->name('excercises.open_ended.show');

Route::get('/units/{unit}/excercises/create/open_ended/{excercise}/question', [OpenEndedQuestionController::class, 'create'])->name('questions.open_ended.create');
Route::post('/units/{unit}/excercises/store/open_ended/{section}/{excercise}/question', [OpenEndedQuestionController::class, 'store'])->name('questions.open_ended.store');
Route::delete('/units/{unit}/excercises/destroy/{excercise}/{question}', [OpenEndedQuestionController::class, 'destroy'])->name('questions.open_ended.destroy');
Route::get('/units/{unit}/excercises/{excercise}/questions/show/{question}', [OpenEndedQuestionController::class, 'show'])->name('questions.open_ended.show');

// Fill In The Gaps Routes
Route::get('/units/{unit}/excercises/create/fill_in_the_gaps/{section}', [FillInTheGapsExcerciseController::class, 'create'])->name('excercises.fill_in_the_gaps.create');
Route::post('/units/{unit}/excercises/store/fill_in_the_gaps/{section}', [FillInTheGapsExcerciseController::class, 'store'])->name('excercises.fill_in_the_gaps.store');
Route::delete('/units/{unit}/excercises/destroy/{excercise}', [FillInTheGapsExcerciseController::class, 'destroy'])->name('excercises.fill_in_the_gaps.destroy');
Route::get('/units/{unit}/excercises/show/{excercise}', [FillInTheGapsExcerciseController::class, 'show'])->name('excercises.fill_in_the_gaps.show');

Route::get('/units/{unit}/excercises/create/fill_in_the_gaps/{excercise}/question', [FillInTheGapsQuestionController::class, 'create'])->name('questions.fill_in_the_gaps.create');
Route::post('/units/{unit}/excercises/store/fill_in_the_gaps/{excercise}/question', [FillInTheGapsQuestionController::class, 'store'])->name('questions.fill_in_the_gaps.store');
Route::delete('/units/{unit}/excercises/destroy/{excercise}/{question}', [FillInTheGapsQuestionController::class, 'destroy'])->name('questions.fill_in_the_gaps.destroy');
Route::get('/units/{unit}/excercises/{excercise}/questions/show/{question}', [FillInTheGapsExcerciseController::class, 'show'])->name('questions.fill_in_the_gaps.show');