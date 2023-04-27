<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ReceiverUpdateRequest extends FormRequest
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
            'name'         => 'required|string',
            'phone'        => 'required|numeric|unique:receivers,phone,'.$this->receiver,
            'company_name' => 'required|string',
            'branch_name'  => 'required|string',
            'branch_id'    => 'required|integer|exists:branches,id',
            'city_id'      => 'required|integer|exists:locations,id',
            'area_id'      => 'required|integer|exists:locations,id',
            'reference'    => 'required|string',
            'title'        => 'required|string',
            'notes'        => 'required|string',
        ];
    }
}
