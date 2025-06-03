<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard');
});

Route::controller(UserController::class)
    ->group(function () {
        Route::get('/users', 'index')->name('users.index');
        Route::get('/users/create', 'create')->name('users.create');
        Route::post('/users', 'store')->name('users.store');
        Route::get('/users/{user}/edit', 'edit')->name('users.edit');
        Route::put('/users/{user}', 'update')->name('users.update');
        Route::delete('/users/{user}', 'destroy')->name('users.destroy');
    });

Route::controller(CategoryController::class)
    ->group(function () {
        Route::get('/categories', 'index')->name('category.index');
        Route::get('/categories/create', 'create')->name('category.create');
        Route::post('/categories', 'store')->name('category.store');
        Route::get('/categories/{category}/edit', 'edit')->name('category.edit');
        Route::put('/categories/{category}', 'update')->name('category.update');
        Route::delete('/categories/{category}', 'destroy')->name('category.destroy');
    });
