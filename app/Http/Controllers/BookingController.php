<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $siteSetting = SiteSetting::find(1);
        $adminTax = $siteSetting->admin_tax ?? 5;
        $adminTax = 0;
        $finalTax = ($adminTax / 100);

        // $priceWithTax = ($finalTax * 390) + 390;
        // $priceWithOutTax = $priceWithTax / (1 + $adminTax / 100);
        $booking = Booking::where('booking_id', $id)->first();
        if ($booking) {
            $booking->price_without_tax = $booking->booking_amount / (1 + $adminTax / 100);
            $booking->tax_amount = ($finalTax * $booking->price_without_tax);
            $booking->dates = $this->getBetweenDay($booking->check_in, $booking->check_out);

            $property = Property::with('images', 'category')->find($booking->property_id);
            if ($property) {
                $images = $property->images->map(function ($img) {
                    $img->img_path = $img->img_path ? asset('storage/images/property/' . $img->img_path) : '';
                    return $img;
                });
                if ($property->thumbnail) {
                    $thumbnailUrl = $property->thumbnail
                        ? asset('storage/images/property/' . $property->thumbnail)
                        : asset('assets/images/no-img.png');

                    $property->thumbnail = $thumbnailUrl;
                    // Add thumbnail as first image
                    if ($thumbnailUrl) {
                        $thumbnailObj = (object) [
                            'id' => 0,
                            'img_path' => $thumbnailUrl,
                            'is_thumbnail' => true,
                        ];

                        $images->prepend($thumbnailObj);
                    }
                }

                $property->images = $images->values();
            }
            $stripeKey = $siteSetting->stripe_key ? $siteSetting->stripe_key : config('services.stripe.key');
            return view('book_cabin', compact('property',  'booking', 'stripeKey'));
        } else {
            return redirect()->route('home');
        }
        // dd($booking);
    }

    private function getBetweenDay($checkIn, $checkOut)
    {
        $start = Carbon::parse($checkIn);
        $end = Carbon::parse($checkOut)->subDay(); // exclude checkout date

        $dates = [];

        foreach (CarbonPeriod::create($start, $end) as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $siteSetting = SiteSetting::find(1);
        DB::beginTransaction();
        try {
            $booking = Booking::find($id);
            if ($booking->status == 'confirmed') {
                return redirect()->route('thank-you');
            } else {
                $booking->update([
                    'user_name'        => $request->first_name . ' ' . $request->last_name,
                    'user_email'       => $request->user_email,
                    'user_phone'       => $request->user_phone,
                    'user_address'     => $request->user_address,
                    'number_of_adult'  => $request->number_of_adult,
                    'number_of_child'  => $request->number_of_child,
                    'number_of_pet'    => $request->number_of_pet,
                    'booking_amount'   => $request->booking_amount,
                    'payment_id'       => $request->payment_id,
                    'status'           => 'confirmed',
                    'confirmed_at'     => now(),
                ]);

                // Send an email to admin
                $body = "A new booking has been created in website.\n\n";
                $body .= "Booking ID: " . $booking->booking_id . "\n";
                $body .= "User Name: " . $booking->user_name . "\n";
                $body .= "Email: " . $booking->user_email . "\n";
                $body .= "Phone: " . $booking->user_phone . "\n";
                $body .= "Amount: $" . $booking->booking_amount . "\n";

                $adminMail = trim($siteSetting->contact_email);

                try {
                    Mail::raw(
                        $body,
                        function ($message) {
                            $message->to('bibhuprasad.maastrix@gmail.com')
                                ->subject('New Booking created');
                        }
                    );
                } catch (\Throwable $e) {
                    Log::error('Booking email failed: ' . $e->getMessage());
                }

                $mailBody = "Your booking has been confirmed.\n\n";
                $mailBody .= "Booking ID: " . $booking->booking_id . "\n";
                $mailBody .= "Amount: $" . $booking->booking_amount . "\n";
                try {
                    Mail::raw(
                        $mailBody,
                        function ($message) {
                            $message->to('bibhuprasad.maastrix@gmail.com')
                                ->subject('Booking Confirmed');
                        }
                    );
                } catch (\Throwable $e) {
                    Log::error('Booking email failed: ' . $e->getMessage());
                }
                DB::commit();
                return redirect()->route('thank-you')->with('success', 'Booking ID: ' . $booking->booking_id);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);
        $booking = Booking::find($id);

        if (
            $booking &&
            $booking->status == 'locked' &&
            $booking->created_at->addMinutes(10)->isPast()
        ) {
            $booking->delete();
            return redirect()->route('home')
                ->with('error', 'Booking session expired.');
        } else {
            return back();
        }
    }
}
