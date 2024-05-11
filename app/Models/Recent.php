<?php

namespace App\Models;

use App\Triats\CommonScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wildside\Userstamps\Userstamps;

class Recent extends Model
{
    use HasFactory, Userstamps, CommonScopes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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

    /**
     *
     *
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
