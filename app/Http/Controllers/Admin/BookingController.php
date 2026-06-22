<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
        $bookings = Booking::orderByDesc('id')->with('property')->get();
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
        try {
            $booking = Booking::find($id);
            $booking->status = $request->status;
            $booking->save();

            // Send a mail from admin to user
            if ($booking->status == 'confirmed') {

                $paymentLink = route('make-payment', $booking->booking_id);

                $mailBody = "
                        <h3>Your booking has been approved.</h3>

                        <p>To confirm your booking, please proceed with payment.</p>

                        <p><strong>Booking ID:</strong> {$booking->booking_id}</p>
                        <p><strong>Amount:</strong> $" . number_format($booking->booking_amount, 2) . "</p>

                        <p>
                            Please click the link below to complete your payment:
                        </p>

                        <p>
                            <a href='{$paymentLink}'
                            style='background:#28a745;color:#fff;padding:10px 15px;text-decoration:none;border-radius:5px;'>
                                Complete Payment
                            </a>
                        </p>
                    ";

                $subject = 'Booking Approved - Proceed to Payment';
            } else {

                $mailBody = "
                        <h3>Your booking request has been rejected.</h3>

                        <p>We are sorry to inform you that your booking request has been rejected.</p>

                        <p><strong>Booking ID:</strong> {$booking->booking_id}</p>

                        <p>
                            If you have any questions, please contact our support team.
                        </p>
                    ";

                $subject = 'Booking Rejected';
            }


            $userEmail = trim($booking->user_email);

            try {
                Mail::html($mailBody, function ($message) use ($userEmail, $subject) {
                    $message->to($userEmail)
                        ->subject($subject);
                });
            } catch (\Throwable $e) {
                Log::error('Booking email failed: ' . $e->getMessage());
            }

            return redirect()->route('admin.bookings.index')->with('sussess', 'Status updated successfully');
        } catch (\Throwable $th) {
            return back()->with('sussess', 'Status updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::find($id);
        if (
            $booking &&
            $booking->payment_status == 'pending'
        ) {
            $booking->delete();
            return redirect()->back()
                ->with('success', 'Booking session expired.');
        } else {
            return back()->with('error', 'Can not delete the booking.');
        }
    }


    public function getBookingCalender(Request $request)
    {
        
    }
}
