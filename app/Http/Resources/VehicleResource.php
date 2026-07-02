<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            'vehicle_id' => $this->vehicle_id,
            'owner_name' => $this->owner_name,
            'owner_type' => $this->owner_type,
            'license_plate' => $this->license_plate,
            'make' => $this->make,
            'model' => $this->model,
            'color' => $this->color,
            'status' => $this->status,
            'notes' => $this->notes,
            'photo' => $this->photo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
