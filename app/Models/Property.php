<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    public function images()
    {
        return $this->hasMany(PropertyImage::class, 'property_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(PropertyCategory::class, 'category_id', 'id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'property_id');
        // ->where(function ($q) {

        //     $q->where(function ($q) {

        //         // confirmed paid bookings
        //         $q->where('status', 'confirmed')
        //             ->where('payment_status', 'paid');
        //     })
        //         ->orWhere(function ($q) {

        //             // locked pending bookings
        //             $q->where('status', 'locked')
        //                 ->where('payment_status', 'pending');
        //         });
        // });
    }
}
