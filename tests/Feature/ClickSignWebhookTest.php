<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use App\Models\ClickSignEvent;
use App\Models\Document;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ClickSignWebhookTest extends TestCase
{
    use DatabaseTransactions;

    // Testa quando o campo 'event' é um array
    public function testEventIsArray()
    {
        // Create a ClicksignEvent and Document instance
        $clicksignEvent = ClickSignEvent::factory()->create();
        $document = Document::factory()->create();

        // Cria uma solicitação com 'event' como um array
        $requestData = [
            'event' => [
                'name' => $clicksignEvent->event,
            ],
            'document' => [
                'key' => $document->document_id,
            ],
        ];

        // Faz uma solicitação para o aplicativo
        $response = $this->withHeaders([
            'Content-Hmac' => $this->calculateValidHmac($requestData),
        ])->postJson('/api/v1/tax-domicile/document/webhook?secret=' . env('CLICKSIGN_WEBHOOK_SECRET'), $requestData);

        // Assert que a solicitação foi bem-sucedida
        $response->assertStatus(200);
    }

    // Testa quando o campo 'event' não é um array
    public function testEventIsNotArray()
    {
        // Create a ClicksignEvent and Document instance
        $clicksignEvent = ClickSignEvent::factory()->create();
        $document = Document::factory()->create();

        // Cria uma solicitação com 'event' como um array
        $requestData = [
            'event' => 'invalid_event',
            'document' => [
                'key' => $document->document_id,
            ],
        ];

        // Faz uma solicitação para o aplicativo
        $response = $this->withHeaders([
            'Content-Hmac' => $this->calculateValidHmac($requestData),
        ])->postJson('/api/v1/tax-domicile/document/webhook?secret=' . env('CLICKSIGN_WEBHOOK_SECRET'), $requestData);

        // Assert que a solicitação falha com código 403 (Forbidden)
        $response->assertStatus(422);
    }

    public function testClickSignRequestWithValidData()
    {
        // Create a ClicksignEvent and Document instance
        $clicksignEvent = ClickSignEvent::factory()->create();
        $document = Document::factory()->create();

        // Create a request data
        $requestData = [
            'event' => [
                'name' => $clicksignEvent->event,
            ],
            'document' => [
                'key' => $document->document_id,
            ],
        ];

        // Calculate HMAC
        $hmac = 'sha256=' . hash_hmac('sha256', json_encode($requestData), env('CLICKSIGN_WEBHOOK_HMAC_SECRET'));

        // Make a request to the application
        $response = $this->withHeaders([
            'Content-Hmac' => $hmac,
        ])->postJson('/api/v1/tax-domicile/document/webhook?secret=' . env('CLICKSIGN_WEBHOOK_SECRET'), $requestData);

        // Assert the request was successful
        $response->assertStatus(200);
    }

    public function testClickSignRequestWithInvalidSecret()
    {
        // Create a request data with invalid secret
        $requestData = [
            'secret' => 'invalid_secret',
        ];

        // Make a request to application
        $response = $this->postJson('/api/v1/tax-domicile/document/webhook', $requestData);

        // Assert the request was not successful
        $response->assertStatus(403);
    }

    public function testClickSignRequestWithInvalidHmac()
    {
        // Create a ClicksignEvent and Document instance
        $clicksignEvent = ClickSignEvent::factory()->create();
        $document = Document::factory()->create();

        // Create a request data
        $requestData = [
            'event' => [
                'name' => $clicksignEvent->event,
            ],
            'document' => [
                'key' => $document->document_id,
            ],
        ];

        // Calculate invalid HMAC
        $invalidHmac = 'invalid_hmac';

        // Make a request to the application with invalid HMAC
        $response = $this->withHeaders([
            'Content-Hmac' => $invalidHmac,
        ])->postJson('/api/v1/tax-domicile/document/webhook?secret=' . env('CLICKSIGN_WEBHOOK_SECRET'), $requestData);

        // Assert the request was not successful
        $response->assertStatus(403);
    }

    // Testa quando o campo 'event' é obrigatório
    public function testEventIsRequired()
    {
        // Create a Document instance
        $document = Document::factory()->create();

        // Cria uma solicitação sem 'event'
        $requestData = [
            'document' => [
                'key' => $document->document_id,
            ],
        ];

        // Faz uma solicitação para o aplicativo
        $response = $this->withHeaders([
            'Content-Hmac' => $this->calculateValidHmac($requestData),
        ])->postJson('/api/v1/tax-domicile/document/webhook?secret=' . env('CLICKSIGN_WEBHOOK_SECRET'), $requestData);

        // Assert que a solicitação falha com código 422 (Unprocessable Entity)
        $response->assertStatus(422)
            ->assertJson([
                'message' => 'O campo event é obrigatório. (e mais 1 erro)',
                'errors' => [
                    'event' => [
                        'O campo event é obrigatório.'
                    ],
                    'event.name' => [
                        'O campo event.name é obrigatório.'
                    ]
                ]
            ]);
    }

    // Testa quando o campo 'event.name' não é uma string
    public function testEventNameIsNotString()
    {
        // Create a Document instance
        $document = Document::factory()->create();

        // Cria uma solicitação com 'event.name' não sendo uma string
        $requestData = [
            'event' => [
                'name' => ['invalid_event_name'],
            ],
            'document' => [
                'key' => $document->document_id,
            ],
        ];

        // Faz uma solicitação para o aplicativo
        $response = $this->withHeaders([
            'Content-Hmac' => $this->calculateValidHmac($requestData),
        ])->postJson('/api/v1/tax-domicile/document/webhook?secret=' . env('CLICKSIGN_WEBHOOK_SECRET'), $requestData);

        // Assert que a solicitação falha com código 422 (Unprocessable Entity)
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['event.name']);
    }

    // Testa quando o campo 'event.name' não existe no banco de dados
    public function testEventNameDoesNotExist()
    {
        // Create a Document instance
        $document = Document::factory()->create();

        // Cria uma solicitação com 'event.name' que não existe no banco de dados
        $requestData = [
            'event' => [
                'name' => 'nonexistent_event_name',
            ],
            'document' => [
                'key' => $document->document_id,
            ],
        ];

        // Faz uma solicitação para o aplicativo
        $response = $this->withHeaders([
            'Content-Hmac' => $this->calculateValidHmac($requestData),
        ])->postJson('/api/v1/tax-domicile/document/webhook?secret=' . env('CLICKSIGN_WEBHOOK_SECRET'), $requestData);

        // Assert que a solicitação falha com código 422 (Unprocessable Entity) e os erros esperados
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['event.name']);
    }

    // Testa quando o campo 'document.key' não é uma string
    public function testDocumentKeyIsNotString()
    {
        // Create a Document instance
        $document = Document::factory()->create();

        // Cria uma solicitação com 'document.key' que não é uma string
        $requestData = [
            'event' => [
                'name' => 'valid_event_name',
            ],
            'document' => [
                'key' => ['invalid_key'],
            ],
        ];

        // Faz uma solicitação para o aplicativo
        $response = $this->withHeaders([
            'Content-Hmac' => $this->calculateValidHmac($requestData),
        ])->postJson('/api/v1/tax-domicile/document/webhook?secret=' . env('CLICKSIGN_WEBHOOK_SECRET'), $requestData);

        // Assert que a solicitação falha com código 422 (Unprocessable Entity) e os erros esperados
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['document.key']);
    }

    // Testa quando o campo 'document.key' não existe no banco de dados
    public function testDocumentKeyDoesNotExist()
    {
        // Cria uma solicitação com 'document.key' que não existe no banco de dados
        $requestData = [
            'event' => [
                'name' => 'valid_event_name',
            ],
            'document' => [
                'key' => 'nonexistent_document_key',
            ],
        ];

        // Faz uma solicitação para o aplicativo
        $response = $this->withHeaders([
            'Content-Hmac' => $this->calculateValidHmac($requestData),
        ])->postJson('/api/v1/tax-domicile/document/webhook?secret=' . env('CLICKSIGN_WEBHOOK_SECRET'), $requestData);

        // Assert que a solicitação falha com código 422 (Unprocessable Entity) e os erros esperados
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['document.key']);
    }


    // Calcula o HMAC válido para uma solicitação
    private function calculateValidHmac($requestData): string
    {
        $validHmac = 'sha256=' . hash_hmac('sha256', json_encode($requestData), env('CLICKSIGN_WEBHOOK_HMAC_SECRET'));
        return $validHmac;
    }
}
