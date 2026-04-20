<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Price;
use Stripe\Stripe;
use Stripe\Subscription;
use Stripe\Customer;

class DonationController extends Controller
{
    /**
     * Create a payment intent for one-off donations or a subscription for recurring donations
     */
    public function createPaymentIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $amount = floatval($request->amount);
            $donationType = $request->donation_type;
            $frequency = $request->frequency ?? 'one-off';
            $giftAid = $request->gift_aid ? true : false;
            $donorName = $request->donor_name;
            $donorEmail = $request->donor_email;

            // Validate amount
            if ($amount < 1) {
                return response()->json(['error' => 'Minimum donation amount is £1'], 422);
            }

            if ($donationType === 'regular') {
                return $this->createSubscription($amount, $frequency, $giftAid, $donorName, $donorEmail);
            } else {
                return $this->createOneOffPayment($amount, $giftAid, $donorName, $donorEmail);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Create a one-off payment intent
     */
    private function createOneOffPayment($amount, $giftAid, $donorName, $donorEmail)
    {
        $paymentIntent = PaymentIntent::create([
            'amount' => $amount * 100, // convert £ to pence
            'currency' => 'gbp',
            'payment_method_types' => ['card'],
            'metadata' => [
                'donation_type' => 'one-off',
                'gift_aid' => $giftAid ? 'yes' : 'no',
                'donor_name' => $donorName ?? '',
                'donor_email' => $donorEmail ?? '',
            ],
        ]);

        // Create donation record
        $donation = Donation::create([
            'donor_name' => $donorName,
            'donor_email' => $donorEmail,
            'amount' => $amount,
            'type' => 'one-off',
            'frequency' => null,
            'status' => 'pending',
            'gift_aid' => $giftAid,
            'stripe_payment_intent_id' => $paymentIntent->id,
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
            'donation_id' => $donation->id,
            'type' => 'one-off',
        ]);
    }

    /**
     * Create a subscription for recurring donations
     */
    private function createSubscription($amount, $frequency, $giftAid, $donorName, $donorEmail)
    {
        // Map frequency to Stripe interval
        $intervalMap = [
            'monthly' => 'month',
            'quarterly' => 'month',  // We'll use interval_count for quarterly
            'annually' => 'year',
        ];

        $interval = $intervalMap[$frequency] ?? 'month';
        $intervalCount = $frequency === 'quarterly' ? 3 : 1;

        // Create a customer if email is provided
        $customerData = [];
        if ($donorEmail) {
            $customerData['email'] = $donorEmail;
        }
        if ($donorName) {
            $customerData['name'] = $donorName;
        }

        $customer = Customer::create($customerData);

        // Create a price for the subscription
        $price = Price::create([
            'unit_amount' => $amount * 100, // in pence
            'currency' => 'gbp',
            'recurring' => [
                'interval' => $interval,
                'interval_count' => $intervalCount,
            ],
            'product_data' => [
                'name' => ucfirst($frequency) . ' Donation',
                'metadata' => [
                    'gift_aid' => $giftAid ? 'yes' : 'no',
                ],
            ],
        ]);

        // Create the subscription (requires payment method to be attached)
        // We'll create it in "incomplete" state and let the frontend confirm it
        $subscription = Subscription::create([
            'customer' => $customer->id,
            'items' => [['price' => $price->id]],
            'payment_behavior' => 'default_incomplete',
            'payment_settings' => [
                'save_default_payment_method' => 'on_subscription',
            ],
            'metadata' => [
                'donation_type' => 'regular',
                'frequency' => $frequency,
                'gift_aid' => $giftAid ? 'yes' : 'no',
                'donor_name' => $donorName ?? '',
                'donor_email' => $donorEmail ?? '',
            ],
        ]);

        // Get the payment intent from the subscription's latest invoice
        $paymentIntent = null;
        try {
            // Retrieve the subscription with expanded latest_invoice.payment_intent
            $subscription = \Stripe\Subscription::retrieve([
                'id' => $subscription->id,
                'expand' => ['latest_invoice.payment_intent'],
            ]);

            \Log::info('Subscription retrieved', [
                'subscription_id' => $subscription->id,
                'latest_invoice' => $subscription->latest_invoice ? $subscription->latest_invoice->id : null,
            ]);

            if ($subscription->latest_invoice) {
                // Get the invoice with payment intent expanded
                $invoice = \Stripe\Invoice::retrieve([
                    'id' => $subscription->latest_invoice->id,
                    'expand' => ['payment_intent'],
                ]);

                \Log::info('Invoice retrieved', [
                    'invoice_id' => $invoice->id,
                    'payment_intent' => $invoice->payment_intent ? $invoice->payment_intent->id : null,
                ]);

                if ($invoice->payment_intent) {
                    $paymentIntent = $invoice->payment_intent;
                } else {
                    // If no payment intent exists, create one for the invoice
                    \Log::info('No payment intent found, creating payment intent for invoice', [
                        'invoice_id' => $invoice->id,
                    ]);
                    
                    $paymentIntent = \Stripe\PaymentIntent::create([
                        'amount' => $invoice->amount_due,
                        'currency' => $invoice->currency,
                        'payment_method_types' => ['card'],
                        'metadata' => [
                            'invoice_id' => $invoice->id,
                            'subscription_id' => $subscription->id,
                        ],
                    ]);
                    
                    \Log::info('Payment intent created for invoice', [
                        'payment_intent_id' => $paymentIntent->id,
                        'invoice_id' => $invoice->id,
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Log error with full details
            \Log::error('Failed to get payment intent for subscription: ' . $e->getMessage(), [
                'exception' => $e,
                'subscription_id' => $subscription->id ?? null,
            ]);
            
            // Return the error to the client for debugging
            return response()->json([
                'error' => 'Failed to create payment intent for subscription: ' . $e->getMessage()
            ], 500);
        }

        // Create donation record
        $donation = Donation::create([
            'donor_name' => $donorName,
            'donor_email' => $donorEmail,
            'amount' => $amount,
            'type' => 'regular',
            'frequency' => $frequency,
            'status' => 'pending',
            'gift_aid' => $giftAid,
            'stripe_customer_id' => $customer->id,
            'stripe_subscription_id' => $subscription->id,
            'stripe_price_id' => $price->id,
            'stripe_payment_intent_id' => $paymentIntent ? $paymentIntent->id : null,
        ]);

        if (!$paymentIntent) {
            return response()->json(['error' => 'Failed to create payment intent for subscription'], 500);
        }

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
            'subscription_id' => $subscription->id,
            'donation_id' => $donation->id,
            'type' => 'regular',
        ]);
    }

    /**
     * Handle successful payment/subscription confirmation
     */
    public function confirmPayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $paymentIntentId = $request->payment_intent_id;
            $donationId = $request->donation_id;

            // Retrieve the payment intent
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            if ($paymentIntent->status === 'succeeded') {
                $donation = Donation::find($donationId);
                if ($donation) {
                    $donation->status = 'completed';
                    $donation->save();
                }

                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false, 'message' => 'Payment not completed'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show success page
     */
    public function success(Request $request)
    {
        $paymentIntentId = $request->input('payment_intent');
        $donation = null;

        if ($paymentIntentId) {
            $donation = Donation::where('stripe_payment_intent_id', $paymentIntentId)
                ->orWhere('id', $request->input('donation_id'))
                ->first();
        }

        return view('payment-success', [
            'donationAmount' => $donation ? $donation->amount : session('donation_amount'),
            'donorName' => $donation ? $donation->donor_name : session('donor_name'),
            'donationType' => $donation ? $donation->type : null,
            'frequency' => $donation ? $donation->frequency : null,
        ]);
    }

    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => ucfirst($request->donation_type) . ' Donation',
                        ],
                        'unit_amount' => $request->amount * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => url('/donation-success'),
                'cancel_url' => url('/donation-cancel'),
            ]);

            return response()->json(['id' => $session->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}