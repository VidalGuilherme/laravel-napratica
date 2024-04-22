<?php

namespace App\Http\Requests;

use App\Enums\EmailTypes;
use App\Enums\PhoneTypes;
use App\Enums\Retreats;
use App\Enums\StateIndicators;
use App\Enums\SupplierTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSupplierRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'supplier_type' => [
                'required',
                Rule::in(array_column(SupplierTypes::cases(),'value'))
            ],
            'cpf' => ['required_if:supplier_type,pf', 'size:11', 'nullable'],
            'personal_name' => ['required_with:cpf','min:3','max:255', 'nullable'],
            'nickname' => ['min:3', 'max:255', 'nullable'],
            'rg' => ['required_with:cpf','min:3','max:255', 'nullable'],

            'cnpj' => ['required_if:supplier_type,pj','size:14', 'nullable'],
            'company_name' => ['required_with:cnpj','min:3','max:255', 'nullable'],
            'fantasy_name' => ['required_with:cnpj','min:3','max:255', 'nullable'],
            'state_indicator' => [
                'required_with:cnpj',
                Rule::in(array_column(StateIndicators::cases(),'value')),
                'nullable'
            ],
            'state_registration' => ['required_with:cnpj','min:3','max:255', 'nullable'],
            'municipal_registration' => ['min:3','max:255', 'nullable'],
            'cnpj_status' => ['min:3','max:20', 'nullable'],
            'retreat' => [
                'required_with:cnpj',
                Rule::in(array_column(Retreats::cases(),'value')),
                'nullable'
            ],
            'active' => ['required'],

            'addresses' => ['required', 'array'],
            'addresses.*.zipcode' => ['required', 'max:8'],
            'addresses.*.street' => ['required', 'max:255'],
            'addresses.*.number' => ['required', 'max:40'],
            'addresses.*.complement' => ['nullable'],
            'addresses.*.district' => ['required', 'max:60'],
            'addresses.*.reference_point' => ['nullable'],
            'addresses.*.city_id' => ['required', 'exists:cities,id'],
            'addresses.*.condominium' => ['required'],

            'contacts' => ['required', 'array'],
            'contacts.*.name' => ['max:255', 'nullable'],
            'contacts.*.company' => ['max:255', 'nullable'],
            'contacts.*.office' => ['max:255', 'nullable'],

            'contacts.*.phones' => ['required', 'array'],
            'contacts.*.phones.*.phone_number' => ['required', 'max:15'],
            'contacts.*.phones.*.phone_type' => [
                'required',
                Rule::in(array_column(PhoneTypes::cases(),'value')),
            ],

            'contacts.*.emails' => ['array', 'nullable'],
            'contacts.*.emails.*.email' => ['email', 'nullable'],
            'contacts.*.emails.*.email_type' => [                
                Rule::in(array_column(EmailTypes::cases(),'value')),
                'nullable'
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'cpf' => preg_replace('/[^0-9]/', '', $this->cpf),
            'cnpj' => preg_replace('/[^0-9]/', '', $this->cnpj),
        ]);
    }
}
