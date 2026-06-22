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
        'payment_id',
        'property_id',
        'category_id',
        'booking_type',
        'check_in',
        'check_out',
        'total_nights',
        'user_name',
        'user_email',
        'user_phone',
        'user_address',
        'number_of_adult',
        'number_of_child',
        'number_of_pet',
        'booking_amount',
        'status',
        'payment_status',
        'confirmed_at',
        'created_at',
        'updated_at'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }
}
