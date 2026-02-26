<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    protected $table = 'testimonials';
    protected $fillable = [
        'client_name',
        'client_position',
        'client_photo_path',
        'testimonial_text',
        'client_company',
        'client_rating',
        'status',
        'created_at',
        'updated_at'
    ];
}
