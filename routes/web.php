<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ContentBriefController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', function () {
    return view('auth.register');
})->name('register.form');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/password/reset', function () { return 'Coming soon'; })->name('password.request');

Route::get('/dashboard', function () {
    return 'Dashboard coming soon!';
})->middleware('auth');

Route::get('/creator/dashboard', [DashboardController::class, 'creator'])->middleware(['auth', 'creator'])->name('creator.dashboard');

Route::middleware(['auth', 'creator'])->group(function () {
    Route::resource('brands', BrandController::class);
    Route::resource('brief', ContentBriefController::class);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');