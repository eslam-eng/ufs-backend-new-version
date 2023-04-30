<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompaniesResource extends JsonResource
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
            'email' => $this->phone,
            'phone' => $this->phone,
            'status' => $this->receiving_company,
            'show_dashboard' => $this->company_name,
            'address' => $this->address,
            'logo'=>$this->image_path,
            'branches_count'=>$this->branches_count,
            'branches'=>BranchesResource::make($this->whenLoaded('branches')),
            'departments'=>DepartmentsResource::make($this->whenLoaded('departments'))
        ];
    }
}
