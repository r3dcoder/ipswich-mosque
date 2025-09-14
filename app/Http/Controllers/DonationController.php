<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session; // ✅ This is the important one!
use Stripe\PaymentIntent;
use Stripe\Stripe;

class DonationController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET')); // Secret key, server-side ONLY

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100, // convert £ to pence
                'currency' => 'gbp',
                 
                // ✅ Restrict payment methods
                'payment_method_types' => ['card'], 

                'metadata' => [
                    'donation_type' => $request->donation_type,
                    'frequency'     => $request->frequency ?? 'one-off',
                    'gift_aid'      => $request->gift_aid ? 'yes' : 'no',
                ],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success()
    {
        // You can pass dynamic data here if needed
        return view('payment-success', [
            'donationAmount' => session('donation_amount') ?? null,
            'donorName' => session('donor_name') ?? null,
        ]);
    }
    
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET')); // ✅ secret key, not publishable

        try {
            $session = Session::create([
                'payment_method_types' => ['card'], // Stripe will automatically support Apple/Google Pay here
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => ucfirst($request->donation_type) . ' Donation',
                        ],
                        'unit_amount' => $request->amount * 100, // in pence
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => url('/donation-success'),
                'cancel_url' => url('/donation-cancel'),
            ]);

            return response()->json(['id' => $session->id]); // ✅ must return JSON
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
