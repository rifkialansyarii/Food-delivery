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
            'menus' => [
                'name' => $this->name,
                'price' => $this->price,
                'picture' => $this->picture,
            ],

            'merchants' => [
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
