<?php

namespace App\Http\Requests\Webhook;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ClickSign extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /* Validar se o segredo está presente */
        if (empty($this->secret)) {
            return false;
        }

        /* Validar se o segredo é válido */
        if ($this->secret !== env('CLICKSIGN_WEBHOOK_SECRET')) {
            return false;
        }

        /* Validar se o evento está presente */
        if (empty($this->event)) {
            return false;
        }

        /* Validar se o evento é válido */
        if (empty($this->event['name'])) {
            return false;
        }

        return $this->validateHmac();
    }

    public function rules(): array
    {
        return [
            'event' => 'required|array',
            'event.name' => 'required|string|exists:clicksign_events,event',
            'document.key' => 'required|string|exists:documents,document_id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Registrando no log para debug
        Log::error('ClickSign Webhook validation failed.', [
            'errors' => $validator->errors()->all(),
            'request' => $this->all()
        ]);

        return new JsonResponse([
            'success' => false,
            'errors'  => ['Unauthorized.'],
            'data'    => []
        ], Response::HTTP_OK);
    }


    private function validateHmac(): bool
    {
        return $this->calcHmac() === $this->header('Content-Hmac');
    }

    private function calcHmac(): string
    {
        return 'sha256=' . hash_hmac('sha256', $this->getContent(), env('CLICKSIGN_WEBHOOK_HMAC_SECRET'));
    }
}
