<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'name'=> $this->name,
            'email'=> $this->email,
            'ceo'=> $this->ceo,
            'phone'=> $this->phone,
            'show_dashboard'=> $this->show_dashboard,
            'notes'=> $this->notes,
            'status'=> $this->status,
            'city_name' => $this->defaultAddress->city_name,
            'area_name' => $this->defaultAddress->area_name,
            'address'=>$this->defaultAddress->address,
        ];
    }
}
