<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            'phone' => $this->phone,
            'company_name' => $this->company_name,
            'city_name' => $this->defaultAddress->city_name,
            'area_name' => $this->defaultAddress->area_name,
            'address' => $this->defaultAddress->address
        ];
    }
}
