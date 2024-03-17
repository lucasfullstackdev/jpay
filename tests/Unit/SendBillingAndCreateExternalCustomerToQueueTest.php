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
            'name' => 'Andreia Valdizia Viana Pereira',
            'email' => 'lucas201293@gmail.com',
            'phone' => '87999794136',
            'document' => '06550340055',
            'street' => 'Rua do cliente',
            'number' => '323',
            'neighborhood' => 'bairro do cliente',
            'city' => 'Petrolina',
            'state' => 'PE',
            'postal_code' => '56328130',
            'country' => 'Brasil',
            'complement' => 'Sala 5',
            'company' => [
                'document' => '30338337000174',
                'name' => 'ngrok company',
                'street' => 'rua da empresa',
                'number' => '48',
                'neighborhood' => 'bairro',
                'city' => 'Camocim',
                'state' => 'CE',
                'country' => 'Brasil',
                'postal_code' => '56328130',
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
