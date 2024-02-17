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

            # Endereco do cliente
            'street'               => 'required|string',
            'number'               => 'required|string',
            'neighborhood'         => 'required|string',
            'city'                 => 'required|string',
            'state'                => 'required|string',
            'country'              => 'required|string',
            'postal_code'          => 'required|string',

            # Dados da empresa
            'company.document'     => 'required|string',
            'company.name'         => 'required|string',
            'company.street'       => 'required|string',
            'company.number'       => 'required|string',
            'company.neighborhood' => 'required|string',
            'company.city'         => 'required|string',
            'company.state'        => 'required|string',
            'company.country'      => 'required|string',
            'company.postal_code'  => 'required|string',
        ];
    }
}
