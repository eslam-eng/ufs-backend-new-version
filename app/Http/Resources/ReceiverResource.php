<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceiverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'phone'        => $this->phone,
            'company_name' => $this->company_name,
            'branch_name'  => $this->branch_name,
            'reference'    => $this->reference,
            'title'        => $this->title,
            'notes'        => $this->notes,
            'branch_id'    => $this->whenLoaded('branch', new BranchResource($this->branch)),
            'city_id'      => $this->whenLoaded('city',   new BranchResource($this->city)),
            'area_id'      => $this->whenLoaded('area',   new BranchResource($this->area)),
        ];
    }
}
