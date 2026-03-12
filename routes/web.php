<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ContentBriefController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\RevisionController;
use App\Http\Controllers\PublishingController;

Route::get('/', function () {
    // Always show landing page first
    return view('landing');
});

Route::get('/login', function () {

    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }

    return view('auth.login');

})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {

    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }

    return view('auth.register');

})->name('register.form');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/password/reset', function () { return 'Coming soon'; })->name('password.request');

Route::get('/dashboard', function () {
    return 'Dashboard coming soon!';
})->middleware('auth');

// Route::get('/creator/dashboard', [DashboardController::class, 'creator'])->middleware(['auth'])->name('creator.dashboard');
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

Route::middleware(['auth'])->group(function () {
    Route::resource('brief', ContentBriefController::class);
});

Route::get('/admin/production', [ProductionController::class, 'index'])->middleware('auth')->name('production.index');
Route::post('/admin/production/store', [ProductionController::class, 'store'])->middleware('auth')->name('production.store');
Route::get('/admin/production/download/{id}', [ProductionController::class, 'download'])->middleware('auth')->name('production.download');

// Content Tasks Routes
Route::get('/admin/content-tasks', [ContentBriefController::class, 'index'])->middleware('auth')->name('content-tasks.index');
Route::get('/admin/content-tasks/create', [ContentBriefController::class, 'create'])->middleware('auth')->name('content-tasks.create');
Route::post('/admin/content-tasks', [ContentBriefController::class, 'store'])->middleware('auth')->name('content-tasks.store');

Route::put('/admin/content-tasks/{id}', [ContentBriefController::class, 'update'])->middleware('auth')->name('content-tasks.update');
Route::delete('/admin/content-tasks/{id}', [ContentBriefController::class, 'destroy'])->middleware('auth')->name('content-tasks.destroy');
Route::get('/admin/revision', [RevisionController::class, 'index'])->middleware('auth')->name('revision.index');
Route::post('/admin/revision/send-to-approval', [RevisionController::class, 'sendToApproval'])->middleware('auth')->name('revision.send-to-approval');
Route::post('/admin/revision/request-revision', [RevisionController::class, 'requestRevision'])->middleware('auth')->name('revision.request-revision');
Route::post('/admin/revision/update-revision', [RevisionController::class, 'updateRevision'])->middleware('auth')->name('revision.update-revision');

// Additional Sidebar Routes
Route::get('/admin/approval', [ApprovalController::class, 'index'])
    ->middleware('auth')
    ->name('approval.index');
Route::post('/admin/approval/approve-selected', [ApprovalController::class, 'approveSelected'])
    ->middleware('auth')
    ->name('approval.approve-selected');
Route::post('/admin/approval/approve-single', [ApprovalController::class, 'approveSingle'])
    ->middleware('auth')
    ->name('approval.approve-single');

Route::get('/admin/publishing', [PublishingController::class, 'index'])->middleware('auth')->name('publishing.index');
Route::post('/admin/publishing/publish', [PublishingController::class, 'publish'])->middleware('auth')->name('publishing.publish');

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

// Temporary route to create dummy data
Route::get('/create-dummy-data', function() {

    $brand = \App\Models\Brand::firstOrCreate([
        'name' => 'Test Brand'
    ]);

    for ($i = 1; $i <= 3; $i++) {

        \App\Models\ContentTask::firstOrCreate(
            ['title' => "Test Content Task $i"],
            [
                'title' => "Test Content Task $i",
                'brand_id' => $brand->id,
                'platform' => 'instagram',
                'content_format' => 'video',
                'target_duration' => '30s',
                'production_deadline' => now()->addDays(3),
                'publish_deadline' => now()->addDays(7),
                'status' => 'in_production',
            ]
        );

    }

    return "Dummy content tasks created";

});