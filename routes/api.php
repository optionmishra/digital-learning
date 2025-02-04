<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\ContentController;
use App\Http\Controllers\API\SubjectController;
use App\Http\Controllers\API\StandardController;
use App\Http\Controllers\API\AssessmentController;
use App\Http\Controllers\API\EvaluationController;

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::resource('standards', StandardController::class);

// Subjects
Route::resource('subjects', SubjectController::class);

// Books
Route::resource('books', BookController::class);
Route::get('books/subject/{subject}', [BookController::class, 'getBooksBySubjectId']);

Route::middleware('auth:sanctum')->group(function () {

    // Profile
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('update-profile', [AuthController::class, 'updateProfile']);
    Route::post('update-password', [AuthController::class, 'updatePassword']);

    // Standards
    Route::post('set-teacher-standard', [StandardController::class, 'setTeacherStandard']);

    // Articles
    Route::resource('articles', ArticleController::class);

    // Contents
    Route::get('videos', [ContentController::class, 'getThreeRandomVideos']);
    Route::get('videos/{video}', [ContentController::class, 'showVideo']);
    Route::get('videos/subject/{subject}', [ContentController::class, 'getVideosBySubjectId']);

    Route::get('ebooks/{ebook}', [ContentController::class, 'showEbook']);
    Route::get('ebooks/subject/{subject}', [ContentController::class, 'getEbooksBySubjectId']);

    // Assessments
    Route::get('mcq', [AssessmentController::class, 'mcq']);
    Route::get('mcq/subject/{subject}', [AssessmentController::class, 'getMcqAssessmentBySubjectId']);

    Route::get('olympiad', [AssessmentController::class, 'olympiad']);

    Route::get('assessment/questions/{assessment}', [AssessmentController::class, 'getQuestionsByAssessmentId']);
    Route::post('assessment/attempt', [AssessmentController::class, 'attemptAssessment']);

    // Evaluations
    Route::get('score', [EvaluationController::class, 'scoreIndex']);
    Route::get('answer-keys', [EvaluationController::class, 'answerKeyIndex']);
    Route::get('report/{assessment}', [EvaluationController::class, 'report']);
    Route::get('solutions/{assessment}', [EvaluationController::class, 'solutions']);
});
