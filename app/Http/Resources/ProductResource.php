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
            'description' => $this->description,
            'price' => '$' . number_format($this->price, 2),
            'stock' => $this->stock,
            'stock_status' => $this->getStockStatus(),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'created_at' => $this->created_at->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i'),
        ];
    }

    /**
     * Get stock status based on quantity
     */
    private function getStockStatus(): string
    {
        if ($this->stock == 0) {
            return __('messages.stock.out_of_stock');
        } elseif ($this->stock <= 5) {
            return __('messages.stock.low_stock');
        } else {
            return __('messages.stock.in_stock');
        }
    }
}
