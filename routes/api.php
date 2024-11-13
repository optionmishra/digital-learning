<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\ContentController;
use App\Http\Controllers\API\McqController;
use App\Http\Controllers\API\SubjectController;
use App\Http\Controllers\API\StandardController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');

    Route::resource('standards', StandardController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('books', BookController::class);
    Route::get('books/subject/{subject}', [BookController::class, 'getBooksBySubjectId']);

    Route::resource('subjects', SubjectController::class);

    Route::resource('articles', ArticleController::class);

    Route::get('videos', [ContentController::class, 'getThreeRandomVideos']);
    Route::get('videos/{video}', [ContentController::class, 'showVideo']);
    Route::get('videos/subject/{subject}', [ContentController::class, 'getVideosBySubjectId']);

    Route::get('ebooks/{ebook}', [ContentController::class, 'showEbook']);
    Route::get('ebooks/subject/{subject}', [ContentController::class, 'getEbooksBySubjectId']);

    Route::get('mcq', [McqController::class, 'index']);
    Route::get('mcq/subject/{subject}', [McqController::class, 'getSeriesBySubject']);
});
