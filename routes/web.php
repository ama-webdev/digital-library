<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\UserPageController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\BookCategoryController;

Auth::routes();
Route::name('user.')->group(function () {
    Route::get('/', [UserPageController::class, 'home'])->name('home');
});
Route::middleware(['auth'])->name('user.')->group(function () {
    Route::get('/about', [UserPageController::class, 'about'])->name('about');
    Route::get('/books', [UserPageController::class, 'books'])->name('books');
    Route::get('/books/{book_id}', [UserPageController::class, 'bookDetail'])->name('book-detail');

    Route::get('change-password', [UserPageController::class, 'showChangePassword'])->name('show-change-password');
    Route::post('change-password', [UserPageController::class, 'changePassword'])->name('change-password');
    Route::post('change-student-password', [UserPageController::class, 'changeStudentPassword'])->name('change-student-password');
});

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'insert'])->name('users.insert');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/{id}/destroy', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::middleware(['auth', 'role:admin|librarian'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminPageController::class, 'dashboard'])->name('dashboard');

    // book categories
    Route::get('/book-categories', [BookCategoryController::class, 'index'])->name('book-categories');
    Route::get('/book-categories/create', [BookCategoryController::class, 'create'])->name('book-categories.create');
    Route::post('/book-categories', [BookCategoryController::class, 'insert'])->name('book-categories.insert');
    Route::get('/book-categories/{id}/edit', [BookCategoryController::class, 'edit'])->name('book-categories.edit');
    Route::post('/book-categories/{id}/update', [BookCategoryController::class, 'update'])->name('book-categories.update');
    Route::post('/book-categories/{id}/destroy', [BookCategoryController::class, 'destroy'])->name('book-categories.destroy');

    // books
    Route::get('/books', [BookController::class, 'index'])->name('books');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'insert'])->name('books.insert');
    Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::post('/books/{id}/update', [BookController::class, 'update'])->name('books.update');
    Route::post('/books/{id}/destroy', [BookController::class, 'destroy'])->name('books.destroy');

    // change password
    Route::get('change-password', [AdminPageController::class, 'changePassword'])->name('change-password');
    Route::get('change-student-password', [AdminPageController::class, 'showChangeStudentPassword'])->name('change-student-password');
});