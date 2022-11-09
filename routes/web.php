<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GoCardlessController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


// UI Routes ------------------------

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/donate', function () {
    return Inertia::render('SubscriptionCreate');
});

// Auth Routes ----------------------

Route::get('/login', [LoginController::class, 'create'])->name('login');

Route::post('/login', [LoginController::class, 'store']);

Route::post('/logout', [LoginController::class, 'destroy'])->middleware(['auth']);


// Stripe Routes ------------------------

Route::post('/stripe/create-customer', [StripeController::class, 'create_customer']);

Route::post('/stripe/create-subscription', [StripeController::class, 'create_subscription']);

Route::get('/stripe/success', [StripeController::class, 'success']);

Route::webhooks('/stripe/webhooks', 'stripe');

Route::put('/stripe/{id}', [StripeController::class, 'update']);

// GoCardless Routes ------------------------

Route::webhooks('/gocardless/webhooks', 'gocardless');

Route::post('/gocardless/create', [GoCardlessController::class, 'create']);

Route::put('/gocardless/{id}', [GoCardlessController::class, 'update']);

Route::get('/gocardless/success', [GoCardlessController::class, 'success']);

// Admin Routes -----------------------------

Route::get('/admin/overview', [AdminController::class, 'overview'])->middleware(['auth']);

Route::get('/admin/members', [AdminController::class, 'index'])->middleware(['auth']);

Route::get('/admin/members/{id}', [AdminController::class, 'show'])->where('id', '[0-9]+')->middleware(['auth']);
