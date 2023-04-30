<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\BaseRequest;
use App\Rules\PhoneValidation;

class CompanyUpdateRequest extends BaseRequest
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
            'email' => 'required|unique:companies,email,'. $this->receiver,
            'ceo' => 'nullable|string',
            'phone' => ['required',new PhoneValidation()],
            'show_dashboard' => 'required|bool',
            'commercial_number' => 'nullable|string',
            'notes' => 'nullable|string',
            'title' => 'nullable|string',
            'status' => 'required|bool',
            'address' => 'string|required',


        ];
    }
}
