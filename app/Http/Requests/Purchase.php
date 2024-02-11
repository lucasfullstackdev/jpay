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
            'name'     => 'required|string|',
            'email'    => 'required|string|email:rfc,dns',
            'phone'    => 'required|string|min:11|max:11',
            'document' => 'required|string|max:20'
        ];
    }

    public function messages(): array
    {
        return [
            'document.required' => 'O campo documento é obrigatório.'
        ];
    }
}
