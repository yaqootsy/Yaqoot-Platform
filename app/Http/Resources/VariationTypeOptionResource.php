<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariationTypeOptionResource extends JsonResource
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
            'variation_type_id' => $this->variation_type_id,
            'name' => $this->name,
            
            // Include relations
            'variation_type' => $this->whenLoaded('variation_type', function() {
                return [
                    'id' => $this->variation_type->id,
                    'name' => $this->variation_type->name,
                    'frontend_type' => $this->variation_type->frontend_type,
                ];
            }),
        ];
    }
}
