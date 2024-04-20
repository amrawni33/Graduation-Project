<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'image', 'url', 'short_description'];

    public function favourites()
    {
        return $this->hasMany(Favourites::class);
    }

    public function lastViewedProducts()
    {
        return $this->hasMany(Last_Viewed_Products::class);
    }

    public function websites()
    {
        return $this->hasMany(Websites::class);
    }
}
