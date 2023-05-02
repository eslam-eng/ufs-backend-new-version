<?php

namespace App\Http\Requests\Api\Branches;

use App\DTO\Branch\BranchDTO;
use App\Http\Requests\BaseRequest;

class BranchStoreRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'phone' => 'required|numeric|unique:branches,phone',
            'company_id' => 'required|numeric|exists:companies,id',
            'city_id' => 'required|integer|exists:locations,id',
            'area_id' => 'required|integer|exists:locations,id',
            'address' => 'required|string',
            'lat' => 'string|nullable',
            'lng' => 'string|nullable',
            'postal_code' => 'string|nullable',
            'map_url' => 'string|nullable',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_default' => true,
        ]);

    }

    public function toBranchDTO(): \App\DTO\BaseDTO
    {
        return BranchDTO::fromRequest($this);
    }
}
