<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\GoCardlessController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OfflineController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


// UI Routes ------------------------

Route::get('/', function () {
    return Inertia::render('SubscriptionCreate', [
        'csrf' => csrf_token(),
    ]);
});

// Auth Routes ----------------------

Route::get('/login', [LoginController::class, 'create'])->name('login');

Route::post('/login', [LoginController::class, 'store']);

Route::post('/logout', [LoginController::class, 'destroy'])->middleware(['auth']);


// Stripe Routes ------------------------

Route::post('/stripe/create-customer', [StripeController::class, 'create_customer']);

Route::post('/stripe/create-subscription', [StripeController::class, 'create_subscription']);

Route::post('/stripe/create-payment', [StripeController::class, 'create_payment']);

Route::get('/stripe/success', [StripeController::class, 'success']);

Route::webhooks('/stripe/webhooks', 'stripe');

Route::put('/stripe/{id}', [StripeController::class, 'update'])->where('id', '[0-9]+');

// GoCardless Routes ------------------------

Route::webhooks('/gocardless/webhooks', 'gocardless');

Route::post('/gocardless/create', [GoCardlessController::class, 'create']);

Route::put('/gocardless/{id}', [GoCardlessController::class, 'update'])->where('id', '[0-9]+');

Route::get('/gocardless/success', [GoCardlessController::class, 'success']);

// Admin Routes -----------------------------

Route::get('/admin/overview', [AdminController::class, 'overview'])->middleware(['auth']);

Route::get('/admin/members', [AdminController::class, 'index'])->middleware(['auth']);

Route::get('/admin/members/{id}', [AdminController::class, 'show'])->where('id', '[0-9]+')->middleware(['auth']);

Route::get('/admin/payments', [AdminController::class, 'index_payments'])->middleware(['auth']);

Route::get('/admin/export', [ExportController::class, 'create'])->middleware(['auth']);

Route::get('/admin/export/store', [ExportController::class, 'store'])->middleware(['auth']);

// Offline Routes -----------------------------

Route::post('/offline/create', [OfflineController::class, 'create'])->middleware(['auth']);
