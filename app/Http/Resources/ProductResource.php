<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

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
            'productName' => $this->product_name,
            'category' => $this->category->category_name,
            'productPrice' => '£' . $this->product_price,
            'productStock' => $this->product_stock,
            'uploadedAt' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'uploadedBy' => UserResource::make($this->whenLoaded('user')),

        ];
    }
}
