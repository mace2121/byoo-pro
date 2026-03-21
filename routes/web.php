<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\ThemeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    if ($request->attributes->has('custom_domain_profile')) {
        return app(PublicProfileController::class)->showByCustomDomain($request);
    }

    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/design', [ProfileController::class, 'updateDesign'])->name('profile.design.update');
    Route::patch('/profile/onboarding', [ProfileController::class, 'completeOnboarding'])->name('profile.onboarding.complete');
    Route::post('/profile/design/media', [ProfileController::class, 'uploadDesignMedia'])->name('profile.design.media.upload');
    Route::post('/profile/design/media/chunk', [ProfileController::class, 'uploadDesignMediaChunk'])->name('profile.design.media.chunk');
    Route::post('/profile/design/media/finalize', [ProfileController::class, 'finalizeDesignMediaUpload'])->name('profile.design.media.finalize');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/links', [LinkController::class, 'index'])->name('links.index');
    Route::post('/links', [LinkController::class, 'store'])->name('links.store');
    Route::put('/links/{link}', [LinkController::class, 'update'])->name('links.update');
    Route::patch('/links/{link}/toggle', [LinkController::class, 'toggle'])->name('links.toggle');
    Route::delete('/links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');
    Route::post('/links/reorder', [LinkController::class, 'reorder'])->name('links.reorder');

    Route::post('/blocks', [BlockController::class, 'store'])->name('blocks.store');
    Route::post('/blocks/previews/refresh', [BlockController::class, 'refreshPreviews'])->name('blocks.previews.refresh');
    Route::put('/blocks/{block}', [BlockController::class, 'update'])->name('blocks.update');
    Route::patch('/blocks/{block}/toggle', [BlockController::class, 'toggle'])->name('blocks.toggle');
    Route::delete('/blocks/{block}', [BlockController::class, 'destroy'])->name('blocks.destroy');
    Route::post('/blocks/reorder', [BlockController::class, 'reorder'])->name('blocks.reorder');

    Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    
    Route::post('/themes', [ThemeController::class, 'store'])->name('themes.store');
    Route::post('/themes/{theme}/apply', [ThemeController::class, 'apply'])->name('themes.apply');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::patch('/users/{user}/toggle', [AdminController::class, 'toggleStatus'])->name('users.toggle');
    Route::patch('/users/{user}/verified', [AdminController::class, 'toggleVerified'])->name('users.verified');
    Route::patch('/users/{user}/plan', [AdminController::class, 'updatePlan'])->name('users.plan');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/users/{user}/impersonate', [AdminController::class, 'impersonate'])->name('users.impersonate');
    
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    Route::get('/themes', [AdminController::class, 'themes'])->name('themes.index');
    Route::patch('/themes/{theme}/toggle', [AdminController::class, 'toggleTheme'])->name('themes.toggle');
    Route::patch('/themes/{theme}/approve', [AdminController::class, 'approveTheme'])->name('themes.approve');
});

Route::get('/admin/stop-impersonating', [AdminController::class, 'stopImpersonating'])
    ->middleware('auth')
    ->name('admin.stop-impersonating');

require __DIR__.'/auth.php';

Route::middleware('guest')->group(function () {
    Route::get('/auth/google', [\App\Http\Controllers\Auth\GoogleAuthController::class, 'redirect'])->name('google.login');
    Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\GoogleAuthController::class, 'callback'])->name('google.callback');
});

Route::get('/l/{link}', [PublicProfileController::class, 'redirect'])->name('public.redirect');
Route::post('/l/{link}/verify', [PublicProfileController::class, 'verifyPassword'])->name('public.verify-password');
Route::get('/{username}', [PublicProfileController::class, 'show'])->name('public.profile');
