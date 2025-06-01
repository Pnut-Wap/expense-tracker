<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard');
});

Route::get('/users', [UserController::class, 'index'])->name('user.index');
