<?php

namespace App\Http\Resources;

use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
            'image' =>$this->image,
            'average_rating' => $this->average_rating,
            'total_reviews' => $this->total_reviews,
            'seller_name' => $this->seller_name,
            'is_favorite' => $this->isFavorite($this->id),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'website' => new WebsiteResource($this->whenLoaded('website')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
        ];
    }

    public function isFavorite($id){
        $isFound = Favourite::query()->where('created_by', Auth::user()->id)->where('product_id', $id)->first();
        if ($isFound) {
            return 1;
        }
        return 0;
    }
}
