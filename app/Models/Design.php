<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;

    protected $fillable = [
        'design_category_id',
        'name',
        'slug',
        'image',
        'description',
        'is_active',
        'meta_title',
        'meta_description',
    ];

    public function category()
    {
        return $this->belongsTo(DesignCategory::class, 'design_category_id');
    }
}
