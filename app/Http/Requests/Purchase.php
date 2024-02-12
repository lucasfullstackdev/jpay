<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Purchase extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'                 => 'required|string|',
            'email'                => 'required|string|email:rfc,dns',
            'phone'                => 'required|string|min:11|max:11',
            'document'             => 'required|string|max:20',
            'company.document'     => 'required|string',
            'company.name'         => 'required|string',
            'company.street'       => 'required|string',
            'company.number'       => 'required|string',
            'company.neighborhood' => 'required|string',
            'company.zipCode'      => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'document.required' => 'O campo documento é obrigatório.',
            'company.document.required'     => 'O documento da empresa é obrigatório.',
            'company.name.required'         => 'A Razão Social da empresa é obrigatório.',
            'company.street.required'       => 'O Logradouro da empresa é obrigatório.',
            'company.number.required'       => 'O Número da Sede da empresa é obrigatório.',
            'company.neighborhood.required' => 'O Bairro da empresa é obrigatório.',
        ];
    }
}
