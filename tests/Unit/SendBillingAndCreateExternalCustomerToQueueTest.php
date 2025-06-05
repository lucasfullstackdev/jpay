<?php

namespace Tests\Unit;

use App\Http\Requests\Purchase;
use App\Jobs\CreateBillingJob;
use App\Jobs\CreateExternalCustomerJob;
use App\Models\Customer;
use App\Services\TaxDomicileService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SendBillingAndCreateExternalCustomerToQueueTest extends TestCase
{
    use RefreshDatabase;

    private Purchase $purchase;

    public function setUp(): void
    {
        parent::setUp();

        // Mock Purchase object with required data
        $this->purchase = new Purchase([
            'name' => 'Maria Oliveira Santos',
            'email' => 'maria.santos@exemplo.com',
            'phone' => '11999999999',
            'document' => '12345678900',
            'street' => 'Rua do cliente',
            'number' => '123',
            'neighborhood' => 'bairro do cliente',
            'city' => 'São Paulo',
            'state' => 'SP',
            'postal_code' => '12345678',
            'country' => 'Brasil',
            'complement' => 'Sala 5',
            'company' => [
                'document' => '12345678000199',
                'name' => 'Empresa Exemplo Ltda',
                'street' => 'rua da empresa',
                'number' => '48',
                'neighborhood' => 'bairro',
                'city' => 'São Paulo',
                'state' => 'SP',
                'country' => 'Brasil',
                'postal_code' => '12345678',
                'complement' => 'Sala 5'
            ]
        ]);
    }

    public function testPurchaseDispatchesCreateBillingJobIfCustomerExists()
    {
        Queue::fake();

        // Create a customer
        $customer = Customer::factory()->create([
            'document' => $this->purchase->document,
        ]);

        // Call the purchase method
        $service = new TaxDomicileService();
        $service->purchase($this->purchase);

        // Assert that a CreateBillingJob was dispatched
        Queue::assertPushed(CreateBillingJob::class);
    }

    public function testPurchaseDispatchesCreateExternalCustomerJobIfCustomerDoesNotExist()
    {
        Queue::fake();

        // Call the purchase method
        $service = new TaxDomicileService();
        $service->purchase($this->purchase);

        // Assert that a CreateExternalCustomerJob was dispatched
        Queue::assertPushed(CreateExternalCustomerJob::class);
    }
}
