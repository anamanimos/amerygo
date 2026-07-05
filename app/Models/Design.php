<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'is_active',
        'meta_title',
        'meta_description',
    ];

    public function categories()
    {
        return $this->belongsToMany(DesignCategory::class, 'design_design_category');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }
}
