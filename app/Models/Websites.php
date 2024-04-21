<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Websites extends Model
{
    protected $fillable = ['website_name', 'url', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
