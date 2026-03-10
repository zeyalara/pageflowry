<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ContentBriefController;
use App\Http\Controllers\ProductionController;

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
Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->middleware(['auth'])->name('admin.dashboard');

<<<<<<< HEAD
Route::get('/test-production', function() {
    return "Production route works!";
=======
Route::get('/debug', function () {
    return view('debug');
})->middleware('auth');

Route::post('/test-brand', [App\Http\Controllers\TestController::class, 'testBrandStore'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');
});

Route::middleware(['auth', 'creator'])->group(function () {
    Route::resource('brief', ContentBriefController::class);
>>>>>>> 079717fe7589fd0dc098d6c93c483eee5cc7801f
});

Route::get('/admin/production', [ProductionController::class, 'index'])->name('production.index');
Route::post('/admin/production/store', [ProductionController::class, 'store'])->name('production.store');
Route::get('/admin/production/download/{id}', [ProductionController::class, 'download'])->name('production.download');
Route::post('/admin/production/{id}/send-to-review', [ProductionController::class, 'sendToReview'])->name('production.send-to-review');

// Brand Management Routes
Route::get('/admin/brands', [BrandController::class, 'index'])->name('brands.index');
Route::post('/admin/brands', [BrandController::class, 'store'])->name('brands.store');
Route::get('/admin/brands/create', [BrandController::class, 'create'])->name('brands.create');
Route::get('/admin/brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
Route::put('/admin/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
Route::delete('/admin/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');

// Content Tasks Routes
Route::get('/admin/content-tasks', [ContentBriefController::class, 'index'])->name('content-tasks.index');
Route::get('/admin/content-tasks/create', [ContentBriefController::class, 'create'])->name('content-tasks.create');
Route::post('/admin/content-tasks', [ContentBriefController::class, 'store'])->name('content-tasks.store');
Route::get('/admin/content-tasks/{id}/edit', [ContentBriefController::class, 'edit'])->name('content-tasks.edit');
Route::put('/admin/content-tasks/{id}', [ContentBriefController::class, 'update'])->name('content-tasks.update');
Route::delete('/admin/content-tasks/{id}', [ContentBriefController::class, 'destroy'])->name('content-tasks.destroy');
Route::get('/admin/revision/{content_task_id}', function($content_task_id) {
    return view('admin.revision.index', ['content_task_id' => $content_task_id]);
})->name('revision.index');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');