<?php

namespace Tests\Feature;

use App\Http\Requests\Webhook\Asaas;
use App\Models\AsaasEvent; // Certifique-se de importar o modelo AsaasEvent
use App\Models\BillingSending;
use App\Models\Customer; // Importe o modelo Customer
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AsaasWebhookTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        // Adicione um evento na tabela asaas_events
        AsaasEvent::create(['event' => 'test_event']);

        // Adicione um cliente na tabela customers
        Customer::factory()->create();
    }

    public function testEventExistsInDatabase()
    {
        // Create a BillingSending instance
        $billingSending = BillingSending::factory()->create();

        // Create a request data
        $requestData = [
            'event' => 'test_event', // Use o evento 'test_event'
            'payment' => [
                'id' => $billingSending->sku,
                'customer' => Customer::first()->sku, // Use o SKU do primeiro cliente criado
                // other request data...
            ],
            'secret' => env('ASAAS_WEBHOOK_SECRET'), // Adiciona o segredo ao cabeçalho da solicitação
        ];

        // Make a request to the application
        $response = $this->post('/api/v1/tax-domicile/purchase/webhook', $requestData);

        // Assert the request was successful
        $response->assertStatus(200);
    }

    public function testEventDoesNotExistInDatabase()
    {
        // Criar um cliente válido no banco de dados
        Customer::factory()->create();

        // Dados da requisição com um evento inexistente
        $requestData = [
            'event' => 'nonexistent_event',
            'payment' => [
                'id' => 'existing_id', // Você pode usar um ID válido aqui se necessário
                'customer' => Customer::first()->sku, // SKU do primeiro cliente criado
                // Outros dados da requisição...
            ],
            'secret' => env('ASAAS_WEBHOOK_SECRET'), // Adiciona o segredo ao cabeçalho da solicitação
        ];

        // Fazer uma requisição para a aplicação
        $response = $this->post('/api/v1/tax-domicile/purchase/webhook', $requestData);

        // Verificar se a requisição retornou o código de status esperado
        $response->assertStatus(302); // Esperando um redirecionamento
        $response->assertSessionHasErrors(['event' => 'O campo event selecionado é inválido.']);
    }

    public function testPaymentIdExistsInDatabase()
    {
        // Create a BillingSending instance
        $billingSending = BillingSending::factory()->create();

        // Create a request data
        $requestData = [
            'event' => 'test_event', // Use o evento 'test_event'
            'payment' => [
                'id' => $billingSending->sku,
                'customer' => Customer::first()->sku, // Use o SKU do primeiro cliente criado
                // other request data...
            ],
            'secret' => env('ASAAS_WEBHOOK_SECRET'), // Adiciona o segredo ao cabeçalho da solicitação
        ];

        // Make a request to the application
        $response = $this->post('/api/v1/tax-domicile/purchase/webhook', $requestData);

        // Assert the request was successful
        $response->assertStatus(200);
    }

    public function testPaymentIdDoesNotExistInDatabase()
    {
        // Create a request data with a non-existent payment ID
        $requestData = [
            'payment' => [
                'id' => 'nonexistent_sku',
                // other request data...
            ],
        ];

        // Make a request to the application
        $response = $this->post('/api/v1/tax-domicile/purchase/webhook?secret=' . env('ASAAS_WEBHOOK_SECRET'), $requestData);

        // Assert the request was not successful
        $response->assertStatus(302); // Esperando um redirecionamento
        $response->assertSessionHasErrors(['payment.id' => 'O campo payment.id selecionado é inválido.']);
    }
}
