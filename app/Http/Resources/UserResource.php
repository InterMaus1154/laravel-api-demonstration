<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'userId' => $this->user_id,
            'username' => $this->username,
            'email' => $this->email,
            'registeredAt' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'numOfProducts' => $this->when($this->products_count, $this->products_count)
        ];
    }
}
