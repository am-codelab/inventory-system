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

            'code' => $this->code,

            'name' => $this->name,

            'description' => $this->description,

            'purchase_price' => $this->purchase_price,

            'sale_price' => $this->sale_price,

            'stock' => $this->stock,

            'minimum_stock' => $this->minimum_stock,

            'is_active' => $this->is_active,

            'category' => new CategoryResource(
                $this->whenLoaded('category')
            ),

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
