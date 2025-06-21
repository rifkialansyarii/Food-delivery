<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
                'picture' => $this->whenNotNull($this->picture),
                'merchants' => [
                    'id' => $this->merchants->id,
                    'user_id' => $this->merchants->user_id,
                    'name' => $this->merchants->name,
                    'address' => $this->merchants->address,
                    'phone' => $this->merchants->phone,
                    'picture' => $this->merchants->picture,
                    'status' => $this->merchants->status,
                    'is_verified' => $this->merchants->is_verified,
                ],
        ];
    }
}
