<?php

use App\Http\Controllers\GoCardlessController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StripeController;
use GoCardlessPro\Client;
use GoCardlessPro\Environment;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


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


// GoCardless Routes ------------------------

Route::webhooks('/gocardless/webhooks');

Route::post('/gocardless/create', [GoCardlessController::class, 'create']);

// Admin Routes -----------------------------

Route::get('/admin/overview', function () {
    return Inertia::render('AdminOverview');
})->middleware(['auth']);

Route::get('test', function () {

    $client = new Client(array(
        'access_token' => getenv('GC_ACCESS_TOKEN'),
        'environment' => Environment::SANDBOX
    ));

    $customer = $client->customers()->get('CU000QC2AS9RXS');

    \App\Models\Members::first()->update([
        'city' => $customer->city,
        'address' => $customer->address_line1 . ' ' . $customer->address_line2,
        'country' => $customer->country_code,
        'state' => $customer->region,
        'postal_code' => $customer->postal_code,
    ]);

    return 'Yes';
});
