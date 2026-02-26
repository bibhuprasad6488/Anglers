<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;
    protected $table = 'pricings';
    protected $fillable = [
        'pricing_cat_id',
        'pricing_title',
        'pricing_text',
        'price',
        'status',
        'created_at',
        'updated_at'
    ];

    public function category()
    {
        return $this->belongsTo(PricingCategory::class, 'pricing_cat_id');
    }
}
