<?php

namespace App\Http\Requests\Api\Companies;

use App\DTO\Company\CompanyDTO;
use App\Http\Requests\BaseRequest;

class CompanyStoreRequest extends BaseRequest
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
            'name'=> 'required|string',
            'email'=> 'required|email',
            'ceo'=> 'required|string',
            'phone'=> 'required|numeric|unique:compaines,phone',
            'show_dashboard'=> 'required|boolean',
            'notes'=> 'required|string',
            'status'=> 'required|boolean',

            'city_id'=> 'required|integer|exists:locations,id',
            'area_id'=> 'required|integer|exists:locations,id',
            'address'=> 'required|string',
            'lat'=> 'required|numeric',
            'lng'=> 'required|numeric',
            'postal_code'=> 'required|numeric',
            'map_url'=> 'required|url',
            'is_default'=> 'required',
            
            'branches'=> 'required|array',
            'departments'=> 'required|array',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_default' => true,
        ]);

    }

    public function toCompanyDTO(): \App\DTO\BaseDTO
    {
        return CompanyDTO::fromRequest($this);
    }
}
