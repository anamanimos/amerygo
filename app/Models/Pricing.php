<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'original_price',
        'discounted_price',
        'is_best_seller',
        'features',
        'cta_text',
        'cta_link'
    ];

    protected $casts = [
        'features' => 'array',
        'is_best_seller' => 'boolean'
    ];
}
