<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'user_id' => $this->user_id ?? $this->addressable_id, // Use one of these
            'addressable_type' => $this->addressable_type,
            'addressable_id' => $this->addressable_id,
            'type' => $this->type,
            'full_name' => $this->full_name,
            'address1' => $this->address1, 
            'address2' => $this->address2,
            'city' => $this->city,
            'state' => $this->state,
            'zipcode' => $this->zipcode,
            'phone' => $this->phone,
            'country_code' => $this->country_code, // Changed from country_id
            'latitude' => $this->latitude,       // Added
            'longitude' => $this->longitude,     // Added
            'default' => (bool) $this->default,
            'delivery_instructions' => $this->delivery_instructions,
            
            // Include relations
            'country' => $this->whenLoaded('country', function() {
                return [
                    'id' => $this->country->id,
                    'name' => $this->country->name,
                    'code' => $this->country->code,
                ];
            }),
            
            // Computed fields
            'full_address' => "{$this->address1}, {$this->city}, {$this->state} {$this->zipcode}",
        ];
    }
}
