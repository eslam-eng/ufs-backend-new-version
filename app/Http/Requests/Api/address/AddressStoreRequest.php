<?php

namespace App\Http\Requests\Api\Address;

use App\DTO\Address\AddressDTO;
use App\Http\Requests\BaseRequest;

class AddressStoreRequest extends BaseRequest
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
            'addressable_type'=>'required|integer',
            'addressable_id'=>'required|integer',
            'lat'=>'required|numeric',
            'lng'=>'required|numeric',
            'address'=>'required|string',
            'map_url'=>'required|url',
            'city_id'=>'required|integer|exists:locations,id',
            'area_id'=>'required|integer|exists:locations,id',
            'postal_code'=>'required|numeric',
            'is_default'=>'nullable|boolean',
        ];
    }

    public function toAddressDTO(): \App\DTO\BaseDTO
    {
        return AddressDTO::fromRequest($this->all());
    }
}
