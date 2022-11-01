<?php

use App\Http\Controllers\StripeController;
use GoCardlessPro\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\StripeClient;

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

Route::webhooks('/gocardless/webhooks');

Route::get('/', function () {
    // Set Default Language
    Session::put(['lang' => Session::get('lang') ? Session::get('lang') : 'EN']);
    return Inertia::render(Session::get('lang') . '/Hello');
});

Route::get('/donation/success', [StripeController::class, 'success']);
Route::post('/stripe/webhook', function (Request $request) {
    \Illuminate\Support\Facades\Log::info($request);
});

Route::get('/donate', function () {
    return Inertia::render(Session::get('lang') . '/StripeCreate');
});

Route::post('/lang', function (Request $request) {
    // Set Language Preference
    Session::put(['lang' => json_decode($request->getContent(), true)['lang']]);
    return redirect()->back();
});

Route::post('/create-customer', [StripeController::class, 'create_customer']);
Route::post('/create-subscription', [StripeController::class, 'create_subscription']);

Route::get('/test', function () {
    $client = new Client([
        // We recommend storing your access token in an
        // environment variable for security
        'access_token' => getenv('GC_ACCESS_TOKEN'),
        // Change me to LIVE when you're ready to go live
        'environment' => \GoCardlessPro\Environment::SANDBOX
    ]);

    $billingRequest = $client->billingRequests()->create([
        "params" => [
            "mandate_request" => [
                "currency" => "NZD"
            ]
        ]
    ]);

    $flow = $client->billingRequestFlows()->create([
        "params" => [
            "redirect_uri" => "http://localhost/",
            "exit_uri" => "http://localhost/",
            "links" => [
                "billing_request" => $billingRequest->id,
            ],
            "prefilled_customer" => [
                "given_name" => "Paddington",
                "family_name" => "Bear",
                "email" => "paddington.bear@acmeplc.com"
            ],
        ]
    ]);

    echo '<pre>';
    print_r($billingRequest->links->customer);
    echo '</pre>';
});

