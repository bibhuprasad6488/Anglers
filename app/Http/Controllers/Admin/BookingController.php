<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::orderByDesc('id')->with('property')->where('status', 'confirmed')->get();
        return view('admin.bookings.list', compact('bookings'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Booking::with('property')->find($id);
        $siteSetting = SiteSetting::find(1);
        $stripeSecret = $siteSetting->stripe_secret ? $siteSetting->stripe_secret : config('services.stripe.secret');

        if ($booking->payment_id) {
            Stripe::setApiKey($stripeSecret);
            $paymentIntent = PaymentIntent::retrieve($booking->payment_id);
            $chargeId = $paymentIntent->latest_charge;
            $charge = Charge::retrieve($chargeId);
        } else {
            $paymentIntent = '';
            $charge = '';
        }

        // dd($paymentIntent);
        return view('admin.bookings.view', compact('booking', 'paymentIntent', 'charge'));
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
