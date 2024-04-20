<?php

namespace App\Http\Requests;

use App\Enums\Retreats;
use App\Enums\StateIndicators;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
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
            'supplier_type' => ['required'],
            'cpf' => ['required_if:supplier_type,pf', 'size:11', 'nullable'],
            'personal_name' => ['required_with:cpf','min:3','max:255', 'nullable'],
            'nickname' => ['min:3', 'max:255'],
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
            'status' => ['required'],
        ];
    }
}
