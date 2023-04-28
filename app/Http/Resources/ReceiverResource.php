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
            'city_name'    => $this->branch_name,
            'area_name'    => $this->area_name,
            'reference'    => $this->reference,
            'title'        => $this->title,
            'notes'        => $this->notes,
        ];
    }
}
