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
            'quantity' => $this->quantity,
            'rating' => $this->rating,
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'category' => $this->relationLoaded('category') ? $this->category->name : null,
            'color' => $this->relationLoaded('color') ? $this->category->name : null,
            'discounts' => DiscountResource::collection($this->whenLoaded('discounts'))
        ];
    }
}
