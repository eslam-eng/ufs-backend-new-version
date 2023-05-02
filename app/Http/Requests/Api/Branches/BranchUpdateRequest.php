<?php

namespace App\Http\Requests\Api\Branches;

use App\DTO\Branch\BranchDTO;
use App\Http\Requests\BaseRequest;

class BranchUpdateRequest extends BaseRequest
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
            'phone' => 'required|numeric|unique:branches,phone,' . $this->branch,
            'company_id' => 'required|integer|exists:companies,id',
        ];
    }

    public function toBranchDTO(): \App\DTO\BaseDTO|BranchDTO
    {
        return BranchDTO::fromArray($this->all());
    }
}