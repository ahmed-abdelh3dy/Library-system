<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::get('/books', [BookController::class, 'index']);
Route::get('/categories/{category}/books/{book}', [BookController::class, 'show']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);

    Route::resource('borrow', BorrowController::class);
});

Route::middleware(['auth:sanctum', 'admin', 'throttle:api'])
    ->prefix('admin')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('categories.books', BookController::class);
    });
