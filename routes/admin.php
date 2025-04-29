<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BoardController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\SeriesController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\StandardController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AssessmentController;
use App\Http\Controllers\Admin\ContentTypeController;

Route::group(['middleware' => ['auth']], function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  // Schools
  Route::resource('schools', SchoolController::class);
  Route::get('/schools-data', [SchoolController::class, 'dataTable'])->name('schools.datatable');
  Route::get('/schools-codes-data/{school}/{role}', [SchoolController::class, 'codesTable'])->name('schools.codesTable');
  Route::post('/schools-codes-store/{role}', [SchoolController::class, 'storeCode'])->name('schools.code.store');

  // Boards
  Route::resource('boards', BoardController::class);
  Route::get('/boards-data', [BoardController::class, 'dataTable'])->name('boards.datatable');

  // Series
  Route::resource('series', SeriesController::class);
  Route::get('/series-data', [SeriesController::class, 'dataTable'])->name('series.datatable');

  // Standards
  Route::resource('standards', StandardController::class);
  Route::get('/standards-data', [StandardController::class, 'dataTable'])->name('standards.datatable');

  // Subjects
  Route::resource('subjects', SubjectController::class);
  Route::get('/subjects-data', [SubjectController::class, 'dataTable'])->name('subjects.datatable');

  // Authors
  Route::resource('authors', AuthorController::class);
  Route::get('/authors-data', [AuthorController::class, 'dataTable'])->name('authors.datatable');

  // Books
  Route::resource('books', BookController::class);
  Route::get('/books-data', [BookController::class, 'dataTable'])->name('books.datatable');

  // Articles
  Route::resource('articles', ArticleController::class);
  Route::get('/articles-data', [ArticleController::class, 'dataTable'])->name('articles.datatable');

  // ContentTypes
  Route::resource('content_types', ContentTypeController::class);
  Route::get('/content_types-data', [ContentTypeController::class, 'dataTable'])->name('content_types.datatable');

  // Contents
  Route::resource('contents', ContentController::class);
  Route::get('/contents-data', [ContentController::class, 'dataTable'])->name('contents.datatable');

  // Topics
  Route::resource('topics', TopicController::class);
  Route::get('/topics-data', [TopicController::class, 'dataTable'])->name('topics.datatable');

  // Assessments
  Route::resource('assessments', AssessmentController::class);
  Route::get('/assessments-data', [AssessmentController::class, 'dataTable'])->name('assessments.datatable');

  // Questions
  Route::resource('questions', QuestionController::class);
  Route::get('/questions-data', [QuestionController::class, 'dataTable'])->name('questions.datatable');

  // Users
  Route::resource('users', UserController::class);
  Route::get('/users-data', [UserController::class, 'dataTable'])->name('users.datatable');
  Route::post('/reset-password/{user}', [UserController::class, 'resetPassword'])->name('users.reset.password');
  Route::post(
    '/approve-user/{user}',
    [UserController::class, 'approveUser']
  )->name(
    'users.approve'
  );

  Route::post(
    '/reject-user/{user}',
    [UserController::class, 'rejectUser']
  )->name(
    'users.reject'
  );

  Route::post('/extend-trial/{user}', [UserController::class, 'extendTrial'])->name('users.extend.trial');
});
