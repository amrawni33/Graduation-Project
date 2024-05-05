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
            'summarize' => $this->summarize,
            'positivity' => $this->positivity,
            'negativity' => $this->negativity,
            'url' => $this->url,
            'stars' => $this->stars,
            'date' => $this->date,
            'images' => $this->images,
            // 'product' => $this->updated_at,
        ];
    }
}
