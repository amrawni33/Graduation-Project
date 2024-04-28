<?php

namespace App\Triats;

trait CommonScopes
{
    public function scopeDateBetween($query, ?string $from, ?string $to)
    {
        $query->when($from, fn ($query) => $query->where('created_at', '>=', $from))
            ->when($to, fn ($query) => $query->where('created_at', '<=', $to));
    }
}
