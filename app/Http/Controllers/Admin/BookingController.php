<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $bookings = Booking::orderByDesc('id')->where('status', '!=', 'blocked')->with('property')->get();
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
        $bookings = Booking::orderByDesc('id')->with('property')->get();

        $properties = Property::with(['bookings' => function ($q) {

            $q->where(function ($q) {

                $q->where('status', 'confirmed')
                    ->where('payment_status', 'paid');
            })
                ->orWhere(function ($q) {

                    $q->where('status', 'locked')
                        ->where('payment_status', 'pending');
                })
                ->orWhere(function ($q) {

                    $q->where('status', 'blocked')
                        ->where('payment_status', 'pending');
                });
        }])->get();




        $today = Carbon::now()->startOfDay();

        $start = $today->copy()
            ->subMonth()
            ->startOfMonth();

        $end = $today->copy()
            ->addMonths(5)
            ->endOfMonth();


        $dates = [];

        while ($start <= $end) {

            $dates[] = $start->copy();

            $start->addDay();
        }

        return view('admin.bookings.booking_calender', compact('bookings', 'properties', 'dates'));
    }

    public function pastDates(Request $request)
    {
        $before = Carbon::parse($request->before);

        $today = Carbon::now()->startOfDay();

        // last month first date
        $minDate = $today->copy()
            ->subMonth()
            ->startOfMonth();


        $date = $before->copy()->subDay();


        // stop loading older than last month start
        if ($date < $minDate) {

            return response()->json([
                'date' => null
            ]);
        }


        return response()->json([
            'date' => $date->format('Y-m-d')
        ]);
    }

    public function getReservedDates(Request $request)
    {

        $bookings = Booking::where('property_id', $request->property_id)

            ->whereIn('status', [

                'confirmed',
                'locked',
                'blocked'

            ])

            ->get();


        $dates = [];


        foreach ($bookings as $booking) {


            $start = Carbon::parse($booking->check_in);

            $end = Carbon::parse($booking->check_out);



            while ($start < $end) {

                $dates[] = $start->format('Y-m-d');

                $start->addDay();
            }
        }


        return response()->json([
            'dates' => $dates
        ]);
    }

    public function blockNewProperty(Request $request)
    {
        $property = Property::find($request->property_id);
        if (!$property) {
            return back()->with('error', 'Property Not Found');
        }

        DB::beginTransaction();

        try {
            $lastBooking = Booking::latest('id')->first();

            if ($lastBooking) {
                // Extract last number
                $lastNumber = (int) substr($lastBooking->booking_id, -4);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            // Generate formatted booking number
            $bookingNo = 'BK-' . date('Y') . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            $bb = new Booking();
            $bb->booking_id = $bookingNo;
            $bb->property_id = $request->property_id;
            $bb->category_id = $property->category_id;
            $bb->total_nights = 0;
            $bb->booking_amount = 0;
            $bb->check_in = $request->from_date;
            $bb->check_out = $request->to_date;
            $bb->status = 'blocked';
            $bb->save();

            DB::commit();
            return back()->with('success', 'Booking blocked successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    public function getBlockedProperty()
    {
        $bookings = Booking::orderByDesc('id')->where('status', 'blocked')->with('property')->get();
        $properties = Property::all();
        return view('admin.bookings.blocked_list', compact('bookings', 'properties'));
    }
}
