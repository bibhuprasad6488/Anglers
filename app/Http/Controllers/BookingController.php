<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $adminTax = SiteSetting::find(1)->admin_tax ?? 5;
        $finalTax = ($adminTax / 100);

        $priceWithTax = ($finalTax * 390) + 390;
        $priceWithOutTax = $priceWithTax / (1 + $adminTax / 100);
        $booking = Booking::where('booking_id', $id)->first();
        if ($booking) {
            $booking->price_without_tax = $booking->booking_amount / (1 + $adminTax / 100);
            $booking->tax_amount = ($finalTax * $booking->price_without_tax);
            $booking->dates = $this->getBetweenDay($booking->check_in, $booking->check_out);
        }
        $property = Property::with('images', 'category')->find($booking->property_id);
        if ($property) {
            $property->images = $property->images->map(function ($img) {
                $img->img_path = $img->img_path ? asset('storage/images/property/' . $img->img_path) : '';
                return $img;
            });
        }

        // dd($booking);
        return view('book_cabin', compact('property',  'booking'));
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
        DB::beginTransaction();
        try {
            $booking = Booking::find($id);
            $booking->user_name = $request->first_name . ' ' . $request->last_name;
            $booking->user_email = $request->user_email;
            $booking->user_phone = $request->user_phone;
            $booking->number_of_adult = $request->number_of_adult;
            $booking->number_of_child = $request->number_of_child;
            $booking->status = 'confirmed';
            $booking->save();
            DB::commit();
            return redirect()->route('thank-you');
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
        //
    }
}
