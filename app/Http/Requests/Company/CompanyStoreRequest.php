<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\BaseRequest;
use App\Rules\PhoneValidation;
use Illuminate\Support\Arr;

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
        $branches_array_size = count(Arr::get($this->all(),'branch_names',[]));
        return [
            'name' => 'required|string',
            'email' => 'required|unique:companies,email',
            'ceo' => 'nullable|string',
            'phone' => ['required',new PhoneValidation()],
            'show_dashboard' => 'required|bool',
            'commercial_number' => 'nullable|string',
            'notes' => 'nullable|string',
            'title' => 'nullable|string',
            'status' => 'required|bool',
            'address' => 'string|required',
            'branch_names'=>'required|array|min:1',
            'branch_phones'=>'required|array|size:' . $branches_array_size,
            'branch_addresses'=>'required|array|size:' . $branches_array_size,
            'branch_cities'=>'required|array|size:' . $branches_array_size,
            'branch_areas'=>'required|array|size:' . $branches_array_size,
            'departments_names'=>'required|array|min:1'
        ];
    }
}
