<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $fillable = [
        'booking_id',
        'property_id',
        'category_id',
        'booking_type',
        'check_in',
        'check_out',
        'total_nights',
        'booking_amount',
        'created_at',
        'updated_at'
    ];
}
