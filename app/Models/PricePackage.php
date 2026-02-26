<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricePackage extends Model
{
    use HasFactory;
    protected $table = 'price_packages';
    protected $fillable = [
        'cat_id',
        'package_title',
        'package_text',
        'price',
        'status',
        'created_at',
        'updated_at'
    ];
}
