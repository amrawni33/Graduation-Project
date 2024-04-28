<?php

namespace App\Models;

use App\Triats\CommonScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'url',
        'short_description',
        'images',
        'average_rating',
        'total_reviews',
        'seller_name',
        'brand_id',
        'category_id',
        'website_id',
    ];

    // public function favourites()
    // {
    //     return $this->hasMany(Favourites::class);
    // }

    // public function Recent()
    // {
    //     return $this->hasMany(Recent::class);
    // }

    // public function websites()
    // {
    //     return $this->belongsTo(Websites::class);
    // }
}
