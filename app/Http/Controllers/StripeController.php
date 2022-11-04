<?php

namespace App\Http\Controllers;

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
                'name' => $result['firstname'] . ' ' . $result['lastname'],
                'shipping' => [
                    'address' => [
                        'city' => $result['city'],
                        'country' => $result['country'],
                        'line1' => $result['address'],
                        'postal_code' => $result['postalcode'],
                        'state' => $result['state'],
                    ],
                    'name' => $result['firstname'] . ' ' . $result['lastname'],
                ],
                'address' => [
                    'city' => $result['city'],
                    'country' => $result['country'],
                    'line1' => $result['address'],
                    'postal_code' => $result['postalcode'],
                    'state' => $result['state'],
                ],
            ]
        );

        $productsdata = [];

        $products = $this->stripe->products->all();

        foreach ($products as $product) {
            $productsdata[] = [
                $product['default_price'],
                $product['name'],
                $this->stripe->prices->retrieve(
                    $product['default_price'],
                    []
                )->unit_amount / 100,
            ];
        }

        return response()->json([
            'customerId' => $customer->id,
            'products' => $productsdata,
        ]);
    }

    public function create_subscription(Request $request)
    {
        $body = json_decode($request->getContent(), true);
        $customer_id = $body['customerId'];

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
