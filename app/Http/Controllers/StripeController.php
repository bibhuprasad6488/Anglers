<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function handleWebhook(Request $request)
    {
        $endpoint_secret = config('services.stripe.webhook_secret');

        $event = Webhook::constructEvent(
            $request->getContent(),
            $request->header('Stripe-Signature'),
            $endpoint_secret
        );

        if ($event->type === 'payment_intent.succeeded') {

            $paymentIntent = $event->data->object;

            $bookingId = $paymentIntent->metadata->booking_id;

            // ✅ Confirm booking
            $booking = Booking::find($bookingId);
            $booking->status = 'confirmed';
            $booking->payment_id = $paymentIntent->id;
            $booking->save();
        }

        return response()->json(['status' => 'success']);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $booking = Booking::find($request->booking_id);

        // if ($booking->status == 'confirmed') {
        //     return response()->json([
        //         'error' => true,
        //         'client_secret' => ''
        //     ]);
        // }
        $siteSetting = SiteSetting::find(1);
        $stripeSecret = $siteSetting->stripe_secret ? $siteSetting->stripe_secret : config('services.stripe.secret');

        Stripe::setApiKey($stripeSecret);

        // $amount = $request->amount * 100; // INR → paisa
        $amount = $request->amount * 100; // USD → cents

        $intent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd',
            'receipt_email' => $request->email,
            'metadata' => [
                'booking_id' => $request->booking_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ],
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        return response()->json([
            'client_secret' => $intent->client_secret
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
