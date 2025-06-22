<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'picture' => $this->picture,
            "latitude" => $this->latitude,
            "longtitude" => $this->longtitude,
            "user_id" => $this->user_id,
        ];
    }
}
