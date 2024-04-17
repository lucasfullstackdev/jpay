<?php

namespace App\Http\Requests;

class Purchase extends BaseRequest
{

    public function authorize(): bool
    {
        /** Se não tiver o segredo, abortar */
        if (empty($this->secret)) {
            return false;
        }

        /** Se o segredo for diferente do esperado, abortar */
        if ($this->secret != env('LANDING_PAGE_SECRET')) {
            return false;
        }

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
            'name'                 => 'required|string|regex:/^\w+(\s+\w+)+$/',
            'email'                => 'required|string|email:rfc,dns',
            'document'             => 'required|string|min:11|max:11',
            'phone'                => 'required|string|max:20',

            # Endereco do cliente
            'street'               => 'required|string',
            'number'               => 'required|string',
            'neighborhood'         => 'required|string',
            'city'                 => 'required|string',
            'state'                => 'required|string',
            'country'              => 'required|string',
            'postal_code'          => 'required|string|min:8|max:8',
            'complement'           => 'nullable|string',

            # Dados da empresa
            'company.document'     => 'required|string',
            'company.name'         => 'required|string',
            'company.street'       => 'required|string',
            'company.number'       => 'required|string',
            'company.neighborhood' => 'required|string',
            'company.city'         => 'required|string',
            'company.state'        => 'required|string',
            'company.country'      => 'required|string',
            'company.postal_code'  => 'required|string|min:8|max:8',
            'company.complement'   => 'nullable|string',
        ];
    }
}
