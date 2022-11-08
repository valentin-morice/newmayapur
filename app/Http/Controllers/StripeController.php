<?php

namespace App\Http\Controllers;

use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Stripe\StripeClient;

class StripeController extends Controller
{
    public $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(
            getenv('STRIPE_SECRET_KEY')
        );
    }

    public function create_customer(Request $request)
    {
        $result = json_decode($request->getContent(), true);

        $customer = $this->stripe->customers->create(
            [
                'email' => $result['email'],
                'name' => ucfirst(strtolower($result['firstname'])) . ' ' . ucfirst(strtolower($result['lastname'])),
            ]
        );

        return response()->json([
            'customerId' => $customer->id,
        ]);
    }

    public function create_subscription(Request $request)
    {
        $body = json_decode($request->getContent(), true);
        $customer_id = $body['customerId'];

        Members::create([
            'name' => ucfirst(strtolower($body['firstname'])) . ' ' . ucfirst(strtolower($body['lastname'])),
            'email' => $request->input('email'),
            'customer_id' => $customer_id,
            'city' => $body['city'],
            'address' => $body['address'],
            'country' => $body['country'],
            'state' => $body['state'],
            'postal_code' => $body['postalcode'],
        ]);

        $setPriceId = function ($amount) {
            if ($amount === 16) {
                return 'price_1M0L1pAO5frM15J3cTPJ3cq2';
            } else if ($amount === 32) {
                return 'price_1M0L2FAO5frM15J3fnVXGaNG';
            } else if ($amount === 64) {
                return 'price_1M0L2eAO5frM15J3112QQSbZ';
            } else if ($amount === 108) {
                return 'price_1M0L31AO5frM15J3NJ21bK2v';
            }
        };

        $price_id = $setPriceId($body['amount']);


        // Create the subscription. Note we're expanding the Subscription's
        // latest invoice and that invoice's payment_intent
        // so we can pass it to the front end to confirm the payment
        $subscription = $this->stripe->subscriptions->create([
            'customer' => $customer_id,
            'items' => [[
                'price' => $price_id,
            ]],
            'currency' => $body['currency'],
            'payment_behavior' => 'default_incomplete',
            'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
            'expand' => ['latest_invoice.payment_intent'],
        ]);

        return response()->json([
            'subscriptionId' => $subscription->id,
            'clientSecret' => $subscription->latest_invoice->payment_intent->client_secret
        ]);
    }


    public function success(Request $request)
    {
        $currentPayment = $this->stripe->paymentIntents->retrieve(
            $request->query('payment_intent'),
            []
        );

        return Inertia::render('StripeSuccess', [
            'data' => [
                'customer' => $this->stripe->customers->retrieve($currentPayment->customer)->name,
                'amount' => $currentPayment->amount / 100,
                'paymentId' => $request->query('payment_intent'),
                'status' => $currentPayment->status,
            ],
        ]);
    }
}
