<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'orders'=>[
                'amount' => $this->amount,
                'total' => $this->total,
                'location' => $this->location,
            ],
            'users' => [
                'name' => $this->users->name,
                'phone' => $this->users->phone,
            ],
            'menus' => [
                'name' => $this->menus->name,
                'price' => $this->menus->price,
                'picture' => $this->menus->picture,
                'status' => $this->menus->status,
            ],

            'merchants' => [
                'name' => $this->menus->merchants->name,
                'address' => $this->menus->merchants->address,
                'phone' => $this->menus->merchants->phone,
                'picture' => $this->menus->merchants->picture,
                'status' => $this->menus->merchants->status,
                'is_verified' => $this->menus->merchants->is_verified,
            ],

            
            // 'drivers' => $this->whenNotNull([
            //     'name' => $this->whenNotNull($this->drivers->name),
            //     'phone' => $this->whenNotNull($this->drivers->phone),
            //     'is_verified' => $this->whenNotNull($this->drivers->is_verified),
            // ]),
        ];
    }
}
