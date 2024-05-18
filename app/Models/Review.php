<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'text',
        'summarize',
        'positivity',
        'negativity',
        'url',
        'stars',
        'date',
        'images',
        'product_id',
    ];

    /**
     *
     *
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
