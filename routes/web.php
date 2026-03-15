<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    if ($request->attributes->has('custom_domain_profile')) {
        return app(PublicProfileController::class)->showByCustomDomain($request);
    }

    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

use App\Http\Controllers\LinkController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/design', [ProfileController::class, 'updateDesign'])->name('profile.design.update');
    Route::post('/profile/design/media', [ProfileController::class, 'uploadDesignMedia'])->name('profile.design.media.upload');
    Route::post('/profile/design/media/chunk', [ProfileController::class, 'uploadDesignMediaChunk'])->name('profile.design.media.chunk');
    Route::post('/profile/design/media/finalize', [ProfileController::class, 'finalizeDesignMediaUpload'])->name('profile.design.media.finalize');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Links
    Route::get('/links', [LinkController::class, 'index'])->name('links.index');
    Route::post('/links', [LinkController::class, 'store'])->name('links.store');
    Route::put('/links/{link}', [LinkController::class, 'update'])->name('links.update');
    Route::patch('/links/{link}/toggle', [LinkController::class, 'toggle'])->name('links.toggle');
    Route::delete('/links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');
    Route::post('/links/reorder', [LinkController::class, 'reorder'])->name('links.reorder');

    // Pricing
    Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
});

use App\Http\Controllers\AdminController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::patch('/users/{user}/toggle', [AdminController::class, 'toggleStatus'])->name('users.toggle');
    Route::get('/users/{user}/impersonate', [AdminController::class, 'impersonate'])->name('users.impersonate');
});

Route::get('/admin/stop-impersonating', [AdminController::class, 'stopImpersonating'])
    ->middleware('auth')
    ->name('admin.stop-impersonating');

require __DIR__.'/auth.php';

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\PublicProfileController;
use Illuminate\Http\Request;

// Public Profile & Link Redirection
Route::get('/l/{link}', [PublicProfileController::class, 'redirect'])->name('public.redirect');
Route::post('/l/{link}/verify', [PublicProfileController::class, 'verifyPassword'])->name('public.verify-password');
Route::get('/{username}', [PublicProfileController::class, 'show'])->name('public.profile');
