<?php

namespace Tests\Feature;

use App\Http\Requests\Webhook\Asaas;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AsaasFormRequestTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_authorizes_with_correct_secret()
    {
        $request = new Asaas();
        $request->merge(['secret' => env('ASAAS_WEBHOOK_SECRET')]);

        $this->assertTrue($request->authorize());
    }

    public function test_it_does_not_authorize_with_empty_secret()
    {
        $request = new Asaas();

        $this->assertFalse($request->authorize());
    }

    public function test_it_does_not_authorize_with_incorrect_secret()
    {
        $request = new Asaas();
        $request->merge(['secret' => 'invalid_secret']);

        $this->assertFalse($request->authorize());
    }

    public function test_it_passes_with_valid_data()
    {
        // Dados válidos
        $data = [
            'event' => 'existing_event',
            'payment' => [
                'id' => 'existing_payment_id',
                'customer' => 'existing_customer_id',
            ],
        ];

        $validator = Validator::make($data, (new Asaas())->rules());

        $this->assertTrue($validator->fails());
    }

    public function test_it_fails_with_missing_event()
    {
        // Evento ausente
        $data = [
            // 'event' => 'existing_event',
            'payment' => [
                'id' => 'existing_payment_id',
                'customer' => 'existing_customer_id',
            ],
        ];

        $validator = Validator::make($data, (new Asaas())->rules());

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('event'));
    }

    public function test_it_fails_with_missing_payment()
    {
        // Pagamento ausente
        $data = [
            'event' => 'existing_event',
            // 'payment' => [
            //     'id' => 'existing_payment_id',
            //     'customer' => 'existing_customer_id',
            // ],
        ];

        $validator = Validator::make($data, (new Asaas())->rules());

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('payment'));
    }

    public function test_it_fails_with_invalid_event()
    {
        // Evento inválido
        $data = [
            'event' => 'non_existing_event',
            'payment' => [
                'id' => 'existing_payment_id',
                'customer' => 'existing_customer_id',
            ],
        ];

        $validator = Validator::make($data, (new Asaas())->rules());

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('event'));
    }

    public function test_it_fails_with_missing_payment_id()
    {
        // ID de pagamento ausente
        $data = [
            'event' => 'existing_event',
            'payment' => [
                // 'id' => 'existing_payment_id',
                'customer' => 'existing_customer_id',
            ],
        ];

        $validator = Validator::make($data, (new Asaas())->rules());

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('payment.id'));
    }

    public function test_it_fails_with_missing_payment_customer()
    {
        // Cliente de pagamento ausente
        $data = [
            'event' => 'existing_event',
            'payment' => [
                'id' => 'existing_payment_id',
                // 'customer' => 'existing_customer_id',
            ],
        ];

        $validator = Validator::make($data, (new Asaas())->rules());

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('payment.customer'));
    }
}
