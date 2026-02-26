<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GetInTouch extends Model
{
    use HasFactory;
    protected $table = 'get_in_touches';
    protected $fillable = [
        'ct_name',
        'ct_email',
        'ct_phone',
        'ct_message',
        'ip_address',
        'created_at',
        'updated_at',
    ];
}
