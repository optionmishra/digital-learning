<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BoardController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\StandardController;
use App\Http\Controllers\Admin\DashboardController;

Route::group(['middleware' => ['auth']], function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::resource('users', UserController::class);

  // Boards
  Route::resource('boards', BoardController::class);
  Route::get('/boards-data', [BoardController::class, 'dataTable'])->name('boards.datatable');

  // Standards
  Route::resource('standards', StandardController::class);
  Route::get('/standards-data', [StandardController::class, 'dataTable'])->name('standards.datatable');

  // Subjects
  Route::resource('subjects', SubjectController::class);
  Route::get('/subjects-data', [SubjectController::class, 'dataTable'])->name('subjects.datatable');

  // Authors
  Route::resource('authors', AuthorController::class);
  Route::get('/authors-data', [AuthorController::class, 'dataTable'])->name('authors.datatable');
});
