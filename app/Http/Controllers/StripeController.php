<?php

namespace App\Http\Controllers;

use App\Models\Members;
use Error;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;
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
                'email' => $result['member']['email'],
                'name' => ucfirst(strtolower($result['member']['firstname'])) . ' ' . ucfirst(strtolower($result['member']['lastname'])),
            ]
        );

        return response()->json([
            'customer_id' => $customer->id,
        ]);
    }

    public function create_payment(Request $request)
    {
        Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        try {

            // Alternatively, set up a webhook to listen for the payment_intent.succeeded event
            // and attach the PaymentMethod to a new Customer
            $customer = Customer::create([
                'name' => $request->input('firstname') . ' ' . $request->input('lastname'),
                'email' => $request->input('email'),
            ]);

            // Create a PaymentIntent with amount and currency
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->input('payment.amount') * 100,
                'customer' => $customer->id,
                'setup_future_usage' => 'off_session',
                'currency' => strtolower($request->input('payment.currency.currency')),
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return response()->json(
                [
                    'client_secret' => $paymentIntent->client_secret,
                    'stripe_pk' => getenv('STRIPE_PUBLISHABLE_KEY')
                ]
            );
        } catch (Error $e) {
            return response('', 500)->json(['error' => $e->getMessage()]);
        } catch (ApiErrorException $e) {
            return response('', 500)->json(['error' => $e->getMessage()]);
        }
    }

    public function create_subscription(Request $request)
    {
        $result = json_decode($request->getContent(), true);

        $customer_id = $result['member']['subscription']['customer_id'];

        Members::create([
            'name' => ucfirst(strtolower($result['member']['firstname'])) . ' ' . ucfirst(strtolower($result['member']['lastname'])),
            'email' => $result['member']['email'],
            'customer_id' => $customer_id,
            'city' => $result['member']['address']['city'],
            'address' => $result['member']['address']['street'],
            'country' => $result['member']['address']['country'],
            'state' => $result['member']['address']['state'],
            'postal_code' => $result['member']['address']['postal_code'],
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

        $price_id = $setPriceId($result['member']['subscription']['amount']);


        // Create the subscription. Note we're expanding the Subscription's
        // latest invoice and that invoice's payment_intent
        // so we can pass it to the front end to confirm the payment
        $subscription = $this->stripe->subscriptions->create([
            'customer' => $customer_id,
            'items' => [[
                'price' => $price_id,
            ]],
            'currency' => $result['member']['subscription']['currency'],
            'payment_behavior' => 'default_incomplete',
            'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
            'expand' => ['latest_invoice.payment_intent'],
        ]);

        return response()->json([
            'client_secret' => $subscription->latest_invoice->payment_intent->client_secret
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
                'currency' => $currentPayment->currency,
            ],
        ]);
    }

    public function update($id)
    {
        $member = Members::where('id', $id)->first();

        $data = $this->stripe->customers->retrieve(
            $member->customer_id,
            ['expand' => ['subscriptions.data']]
        );

        $this->stripe->subscriptions->cancel(
            $data->subscriptions->data[0]->id
        );

        return Inertia::render('RequestSent');
    }
}
