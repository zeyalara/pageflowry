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
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ExportPdfController;
use App\Http\Controllers\PublicBriefController;

Route::get('/', function () {
    // Always show landing page first
    return view('landing');
});

Route::get('/dashboard', function () {
    // Single post-auth landing page
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $role = auth()->user()->role;

    if ($role === 'creator') {
        return redirect()->route('creator.dashboard');
    }

    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/login', function () {

    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('auth.login');

})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {

    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    // Use a single combined Login & Register page.
    return redirect()->route('login', ['tab' => 'register']);

})->name('register.form');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/password/reset', function () { return 'Coming soon'; })->name('password.request');

Route::get('/creator/dashboard', [DashboardController::class, 'creator'])->middleware(['auth'])->name('creator.dashboard');
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
    Route::get('/brands/export-pdf', [ExportPdfController::class, 'brands'])->name('brands.export-pdf');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('brands.show');
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');
});

// Debug route for testing
Route::get('/debug-token/{token}', function($token) {
    return response()->json([
        'share_token' => $token,
        'message' => 'Debug route working',
        'timestamp' => now()->toDateTimeString()
    ]);
});

// Public route for token-based access (no authentication required) - MUST BE BEFORE AUTH ROUTES
Route::get('/brief/{token}', [PublicBriefController::class, 'showByToken'])->name('brief.public');
Route::post('/production/{token}', [PublicBriefController::class, 'storeProduction'])->name('production.store.public');

Route::middleware(['auth'])->group(function () {
    Route::get('/content-briefs', [ContentBriefController::class, 'index'])->name('brief.index');
    Route::post('/content-briefs', [ContentBriefController::class, 'store'])->name('brief.store');
    Route::post('/content-briefs/search', [ContentBriefController::class, 'search'])->name('brief.search');
    Route::get('/content-briefs/{id}', [ContentBriefController::class, 'show'])->name('brief.show');
    Route::get('/content-briefs/{id}/edit', [ContentBriefController::class, 'edit'])->name('brief.edit');
    Route::put('/content-briefs/{id}', [ContentBriefController::class, 'update'])->name('brief.update');
    Route::delete('/content-briefs/{id}', [ContentBriefController::class, 'destroy'])->name('brief.destroy');
});

// Public route for creators to view brief without login
Route::get('/content-briefs/{id}/view', [ContentBriefController::class, 'publicView'])->name('brief.public-view');

// Email log viewer for testing
Route::get('/email-log', function() {
    return view('email-log');
})->name('email.log');

// Email debug route for hosting diagnostics
Route::get('/debug-email', function() {
    $to = request()->query('to', 'alyamutiazahra.0804@gmail.com');
    try {
        \Illuminate\Support\Facades\Mail::raw('Test email from PAGEFLOWRY hosting!', function($message) use ($to) {
            $message->to($to)
                    ->subject('Diagnostic: Test Email Hosting');
        });
        return response()->json([
            'success' => true,
            'message' => "Email berhasil dikirim ke $to! Silakan cek inbox/spam.",
            'config' => [
                'mailer' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'from' => config('mail.from.address'),
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'config' => [
                'mailer' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'from' => config('mail.from.address'),
            ]
        ], 500);
    }
});

Route::get('/admin/production', [ProductionController::class, 'index'])->middleware('auth')->name('production.index');
Route::post('/admin/production/store', [ProductionController::class, 'store'])->middleware('auth')->name('production.store');
Route::get('/admin/production/download/{id}', [ProductionController::class, 'download'])->middleware('auth')->name('production.download');
Route::get('/admin/production/preview/{id}', [ProductionController::class, 'preview'])->middleware('auth')->name('production.preview');
Route::post('/admin/production/{id}/approve', [ProductionController::class, 'approve'])->middleware('auth')->name('production.approve');
Route::post('/admin/production/{id}/revision', [ProductionController::class, 'revision'])->middleware('auth')->name('production.revision');

// Serve production files directly (Windows symlink workaround)
Route::get('/storage/productions/{filename}', function($filename) {
    $path = public_path('storage/productions/' . $filename);
    if (!file_exists($path)) {
        $path = storage_path('app/public/productions/' . $filename);
    }
    
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->where('filename', '.*');

// Task Routes
Route::post('/admin/tasks', [ContentBriefController::class, 'storeTask'])->middleware('auth')->name('tasks.store');
Route::delete('/admin/tasks/{id}', [ContentBriefController::class, 'destroyTask'])->middleware('auth')->name('tasks.destroy');

// Content Tasks Routes
Route::get('/admin/content-tasks', [ContentBriefController::class, 'index'])->middleware('auth')->name('content-tasks.index');
Route::get('/admin/content-tasks/export-pdf', [ExportPdfController::class, 'contentTasks'])->middleware('auth')->name('content-tasks.export-pdf');
Route::get('/admin/content-tasks/create', [ContentBriefController::class, 'create'])->middleware('auth')->name('content-tasks.create');
Route::post('/admin/content-tasks', [ContentBriefController::class, 'store'])->middleware('auth')->name('content-tasks.store');

Route::put('/admin/content-tasks/{id}', [ContentBriefController::class, 'update'])->middleware('auth')->name('content-tasks.update');
Route::delete('/admin/content-tasks/{id}', [ContentBriefController::class, 'destroy'])->middleware('auth')->name('content-tasks.destroy');
Route::get('/admin/revision', [RevisionController::class, 'index'])->middleware('auth')->name('revision.index');
Route::post('/admin/revision/send-to-approval', [RevisionController::class, 'sendToApproval'])->middleware('auth')->name('revision.send-to-approval');
Route::post('/admin/revision/request-revision', [RevisionController::class, 'requestRevision'])->middleware('auth')->name('revision.request-revision');
Route::post('/admin/revision/update-revision', [RevisionController::class, 'updateRevision'])->middleware('auth')->name('revision.update-revision');
Route::post('/admin/revision/{id}/notify', [RevisionController::class, 'notifyRevision'])->middleware('auth')->name('revision.notify');
Route::post('/admin/revision/upload', [RevisionController::class, 'uploadRevision'])->middleware('auth')->name('revision.upload');

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

Route::get('/admin/analytics', [AnalyticsController::class, 'index'])->middleware('auth')->name('analytics.index');
Route::get('/admin/report', [ReportController::class, 'index'])->middleware('auth')->name('report.index');

Route::get('/admin/settings', [SettingsController::class, 'index'])->middleware('auth')->name('settings.index');
Route::put('/admin/settings', [SettingsController::class, 'update'])->middleware('auth')->name('settings.update');

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

// Public routes for token-based access (no authentication required)
Route::get('/production/{token}/view', [PublicBriefController::class, 'showProduction'])->name('public.production');
Route::get('/all-briefs/{token}', [PublicBriefController::class, 'showAllBriefs'])->name('public.all-briefs');