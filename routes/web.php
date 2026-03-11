<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ContentBriefController;
use App\Http\Controllers\ProductionController;

Route::get('/', function () {
    // Check if user is already logged in
    if (auth()->check()) {
        // Redirect based on user role
        if (auth()->user()->role === 'creator') {
            return redirect()->route('creator.dashboard');
        } elseif (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect('/dashboard');
    }
    return view('landing');
});

Route::get('/login', function () {
    // Check if user is already logged in
    if (auth()->check()) {
        // Redirect based on user role
        if (auth()->user()->role === 'creator') {
            return redirect()->route('creator.dashboard');
        } elseif (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect('/dashboard');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', function () {
    // Check if user is already logged in
    if (auth()->check()) {
        // Redirect based on user role
        if (auth()->user()->role === 'creator') {
            return redirect()->route('creator.dashboard');
        } elseif (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect('/dashboard');
    }
    return view('auth.register');
})->name('register.form');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/password/reset', function () { return 'Coming soon'; })->name('password.request');

Route::get('/dashboard', function () {
    return 'Dashboard coming soon!';
})->middleware('auth');

Route::get('/creator/dashboard', [DashboardController::class, 'creator'])->middleware(['auth', 'creator'])->name('creator.dashboard');
Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->middleware(['auth'])->name('admin.dashboard');

Route::get('/test-production', function() {
    return "Production route works!";
});

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
});

Route::get('/admin/production', [ProductionController::class, 'index'])->middleware('auth')->name('production.index');
Route::post('/admin/production/store', [ProductionController::class, 'store'])->middleware('auth')->name('production.store');
Route::get('/admin/production/download/{id}', [ProductionController::class, 'download'])->middleware('auth')->name('production.download');
Route::post('/admin/production/{id}/send-to-review', [ProductionController::class, 'sendToReview'])->middleware('auth')->name('production.send-to-review');

// Content Tasks Routes
Route::get('/admin/content-tasks', [ContentBriefController::class, 'index'])->middleware('auth')->name('content-tasks.index');
Route::get('/admin/content-tasks/create', [ContentBriefController::class, 'create'])->middleware('auth')->name('content-tasks.create');
Route::post('/admin/content-tasks', [ContentBriefController::class, 'store'])->middleware('auth')->name('content-tasks.store');
Route::get('/admin/content-tasks/{id}/edit', [ContentBriefController::class, 'edit'])->middleware('auth')->name('content-tasks.edit');
Route::put('/admin/content-tasks/{id}', [ContentBriefController::class, 'update'])->middleware('auth')->name('content-tasks.update');
Route::delete('/admin/content-tasks/{id}', [ContentBriefController::class, 'destroy'])->middleware('auth')->name('content-tasks.destroy');
Route::get('/admin/revision/{content_task_id}', function($content_task_id) {
    return view('admin.revision.index', ['content_task_id' => $content_task_id]);
})->middleware('auth')->name('revision.index');

// Additional Sidebar Routes
Route::get('/admin/approval', function() {
    return view('admin.approval.index');
})->middleware('auth')->name('approval.index');

Route::get('/admin/publishing', function() {
    return view('admin.publishing.index');
})->middleware('auth')->name('publishing.index');

Route::get('/admin/analytics', function() {
    return view('admin.analytics.index');
})->middleware('auth')->name('analytics.index');

Route::get('/admin/report', function() {
    return view('admin.report.index');
})->middleware('auth')->name('report.index');

Route::get('/admin/settings', function() {
    return view('admin.settings.index');
})->middleware('auth')->name('settings.index');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');