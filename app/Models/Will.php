<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Will extends Model
{
    use HasFactory;

    protected $fillable = [
        'will_unique_id',
        'setup',
        'full_name',
        'email',
        'postcode',
        'confirm_england',
        'confirm_self',
        'confirm_no_advice',
        'confirm_free_will',
        'assets',
        'created_at',
        'updated_at',
    ];

    protected $appends = ['setup_array', 'assets_array'];

    public function getSetupArrayAttribute()
    {
        return $this->setup
            ? array_map('trim', explode(',', $this->setup))
            : [];
    }

    public function getAssetsArrayAttribute()
    {
        return $this->assets
            ? array_map('trim', explode(',', $this->assets))
            : [];
    }
}
