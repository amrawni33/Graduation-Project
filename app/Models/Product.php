<?php

namespace App\Models;

use App\Triats\CommonScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'url',
        'short_description',
        'image',
        'average_rating',
        'total_reviews',
        'seller_name',
        'brand_id',
        'website_id',
    ];

    /**
     *
     *
     */
    public function favourites(): HasMany
    {
        return $this->hasMany(Favourite::class);
    }

    /**
     *
     *
     */
    public function recents(): HasMany
    {
        return $this->hasMany(Recent::class);
    }

    /**
     *
     *
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    /**
     *
     *
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     *
     *
     */
    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}
