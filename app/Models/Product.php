<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'meta_title',
        'meta_description',
        'is_active',
        'is_featured',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function getThumbnailAttribute()
    {
        $firstImage = $this->images->first();
        return $firstImage ? $firstImage->image_path : null;
    }
}
