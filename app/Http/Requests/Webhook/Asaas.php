<?php

namespace App\Http\Requests\Webhook;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class Asaas extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** Se não tiver o segredo, abortar */
        if (empty($this->secret ?? null)) {
            return false;
        }

        /** Se o segredo for diferente do esperado, abortar */
        if ($this->secret != env('ASAAS_WEBHOOK_SECRET')) {
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
            'event' => 'required|string|exists:asaas_events,event',
            'payment' => 'required',
            'payment.id' => 'required|exists:billing_sending,sku',
            'payment.customer' => 'required|exists:customers,sku'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return new JsonResponse([
            'success' => false,
            'errors'  => ['Unauthorized.'],
            'data'    => []
        ], 200);
    }
}
