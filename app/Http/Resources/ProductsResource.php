<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'price' => $this->price,
            'reviews' => $this->reviews,
            'rating' => $this->rating,
            'stock' => $this->stock,
            'image' => url("uploads/".$this->image),
            'discount' => $this->discount,
            'description' => $this->description,
            'status' => $this->status,
            'brand' => $this->brand_id,
            'category' => $this->category_id,
            'colors' => $this->colors->pluck('id')];
    }
}
