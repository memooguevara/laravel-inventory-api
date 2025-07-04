<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\IsAdminUser;
use App\Http\Middleware\IsAuthenticated;
use Illuminate\Support\Facades\Route;

// PUBLIC ROUTES
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// PROTECTED ROUTES
Route::middleware([IsAuthenticated::class])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::get('me', 'me');
    });

    Route::get('categories', [CategoryController::class, 'getCategories']);
    Route::get('categories/{id}', [CategoryController::class, 'getCategoryById']);
    Route::get('products', [ProductController::class, 'getProducts']);
    Route::get('products/{id}', [ProductController::class, 'getProductById']);

    // ADMIN ROUTES
    Route::middleware([IsAdminUser::class])->group(function () {
        Route::controller(CategoryController::class)->group(function () {
            Route::post('categories', 'createCategory');
            Route::patch('categories/{id}', 'updateCategory');
            Route::delete('categories/{id}', 'deleteCategory');
        });

        Route::controller(ProductController::class)->group(function () {
            Route::post('products', 'createProduct');
            Route::patch('products/{id}', 'updateProduct');
            Route::delete('products/{id}', 'deleteProduct');
        });
    });
});
