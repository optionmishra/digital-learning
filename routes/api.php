<?php

use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\AssessmentController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\ConfigController;
use App\Http\Controllers\API\ContentController;
use App\Http\Controllers\API\EvaluationController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\SeriesController;
use App\Http\Controllers\API\StandardController;
use App\Http\Controllers\API\SubjectController;
use App\Http\Controllers\API\TopicController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::resource('standards', StandardController::class);

// Subjects
Route::resource('subjects', SubjectController::class);

// Series
Route::resource('series', SeriesController::class);

// Books
Route::resource('books', BookController::class);
Route::get('books/subject/{subject}', [BookController::class, 'getBooksBySubjectId']);

// TPG
// Topics
Route::get('topics/{book}', [TopicController::class, 'getTopicsByBookId']);
Route::get('question-types', [TopicController::class, 'getQuestionTypesByTopicIds']);
Route::get('questions', [QuestionController::class, 'index']);

// Notifications
Route::get('notifications', [NotificationController::class, 'index']);

// Configs
Route::get('configs', [ConfigController::class, 'index']);

// Forgot Password
Route::post('forgot-password', [PasswordResetLinkController::class, 'store']);

Route::middleware('auth:sanctum', 'check.approval.trial')->group(function () {

    // Profile
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('update-profile', [AuthController::class, 'updateProfile']);
    Route::post('update-password', [AuthController::class, 'updatePassword']);

    // Standards
    Route::post('set-teacher-standard', [StandardController::class, 'setTeacherStandard']);
    Route::get('get-teacher-standards', [StandardController::class, 'getTeacherStandards']);

    // Articles
    Route::resource('articles', ArticleController::class);

    // Contents
    Route::get('videos', [ContentController::class, 'indexVideos']);
    Route::get('videos/{video}', [ContentController::class, 'showVideo']);
    Route::get('videos/subject/{subject}', [ContentController::class, 'getVideosBySubjectId']);

    Route::get('ebooks', [ContentController::class, 'indexEbooks']);
    Route::get('ebooks/{ebook}', [ContentController::class, 'showEbook']);
    Route::get('ebooks/subject/{subject}', [ContentController::class, 'getEbooksBySubjectId']);

    Route::get('teacher-resource', [ContentController::class, 'teacherResource']);

    // Assessments
    Route::get('mcq', [AssessmentController::class, 'mcq']);
    // Route::get('mcq/subject/{subject}', [AssessmentController::class, 'getMcqAssessmentBySubjectId']);

    Route::get('olympiad', [AssessmentController::class, 'olympiad']);
    // Route::get('olympiad/subject/{subject}', [AssessmentController::class, 'getOlympiadAssessmentBySubjectId']);

    Route::get('assessment/questions/{assessment}', [AssessmentController::class, 'getQuestionsByAssessmentId']);
    Route::post('assessment/attempt', [AssessmentController::class, 'attemptAssessment']);

    // Evaluations
    Route::get('score', [EvaluationController::class, 'scoreIndex']);
    Route::get('score/{subject}', [EvaluationController::class, 'getAttemptsBySubjectId']);
    Route::get('answer-keys', [EvaluationController::class, 'answerKeyIndex']);
    Route::get('report/{assessment}', [EvaluationController::class, 'report']);
    Route::get('solutions/{assessment}', [EvaluationController::class, 'solutions']);
});
