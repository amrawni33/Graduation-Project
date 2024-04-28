<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'url' => $this->url,
            'short_description' => $this->short_description,
            'images' => $this->images,
            'average_rating' => $this->average_rating,
            'total_reviews' => $this->total_reviews,
            'seller_name' => $this->seller_name,
            'brand_id' => $this->brand_id,
            // 'category_id' => $this->category_id,
            // 'website_id' => $this->website_id,
        ];
    }
}
