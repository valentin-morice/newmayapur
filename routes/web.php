<?php

use App\Http\Controllers\GoCardlessController;
use App\Http\Controllers\StripeController;
use GoCardlessPro\Client;
use GoCardlessPro\Environment;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redis;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// UI Routes ------------------------

Route::get('/', function () {
    return Inertia::render('Hello');
});

Route::get('/donate', function () {
    return Inertia::render('SubscriptionCreate');
});


// Stripe Routes ------------------------

Route::post('/stripe/create-customer', [StripeController::class, 'create_customer']);

Route::post('/stripe/create-subscription', [StripeController::class, 'create_subscription']);

Route::get('/stripe/success', [StripeController::class, 'success']);


// GoCardless Routes ------------------------

Route::webhooks('/gocardless/webhooks');

Route::post('/gocardless/create', [GoCardlessController::class, 'create']);
