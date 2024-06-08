<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'title' => $this->title,
            'reviewer' => $this->reviewer,
            'is_fake' => $this->is_fake,
            'summarize' => $this->summarize,
            'positivity' => $this->positivity,
            'negativity' => $this->negativity,
            'url' => $this->url,
            'rating' => $this->rating,
            'date' => $this->date,
            'images' => json_decode($this->images),
            'product_id' => $this->product?->id,
        ];
    }
}
