<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    private array $body = [
        "name" =>  "João da Silva",
        "email" => "joao.silva@exemplo.com",
        "phone" => "11999999999",
        "document" => "12345678900",
        'street' => 'Rua de teste',
        'number' => '32',
        'neighborhood' => 'bairro',
        'city' => 'cidade',
        'state' => 'SP',
        'country' => 'Brasil',
        "postal_code" => "12345678",
        "company" => [
            "document" => "12345678000199",
            "name" => "Empresa Exemplo Ltda",
            "street" => "rua da empresa",
            "number" => "48",
            "neighborhood" => "bairro",
            "city" => "São Paulo",
            "state" => "SP",
            "country" => "Brasil",
            "postal_code" => "12345678"
        ]
    ];

    public function testPurchaseReturnsConflictIfRequestAlreadyReceived()
    {
        // Limpa o cache antes de fazer a solicitação
        Cache::flush();

        // Envia a requisição pela primeira vez
        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);

        // Verifica se a primeira requisição foi bem sucedida
        $response->assertStatus(Response::HTTP_OK);
        
        // Envia a mesma requisição novamente
        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);

        // Verifica se a segunda requisição retorna um status de conflito
        $response->assertStatus(Response::HTTP_CONFLICT)
            ->assertJson([
                'success' => true,
                'message' => 'Você já enviou uma requisição com esses dados. Aguarde o processamento da sua requisição.',
            ]);
    }

    // clear && ./artisan cache:clear && ./artisan test
    public function test_purchase_blank()
    {
        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', []);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(20, $response->errors);
        $this->assertEquals([
            "name",
            "email",
            "document",
            "phone",
            "street",
            "number",
            "neighborhood",
            "city",
            "state",
            "country",
            "postal_code",
            "company.document",
            "company.name",
            "company.street",
            "company.number",
            "company.neighborhood",
            "company.city",
            "company.state",
            "company.country",
            "company.postal_code",
        ], array_keys($response->errors));

        $this->assertEquals('O campo nome é obrigatório.', $response->errors['name'][0]);
        $this->assertEquals('O campo email é obrigatório.', $response->errors['email'][0]);
        $this->assertEquals('O campo telefone é obrigatório.', $response->errors['phone'][0]);
        $this->assertEquals('O campo documento é obrigatório.', $response->errors['document'][0]);

        # Endereço do cliente
        $this->assertEquals('O campo rua é obrigatório.', $response->errors['street'][0]);
        $this->assertEquals('O campo número é obrigatório.', $response->errors['number'][0]);
        $this->assertEquals('O campo bairro é obrigatório.', $response->errors['neighborhood'][0]);
        $this->assertEquals('O campo cidade é obrigatório.', $response->errors['city'][0]);
        $this->assertEquals('O campo estado é obrigatório.', $response->errors['state'][0]);
        $this->assertEquals('O campo cep é obrigatório.', $response->errors['postal_code'][0]);
        $this->assertEquals('O campo país é obrigatório.', $response->errors['country'][0]);

        # Dados da empresa
        $this->assertEquals('O campo CNPJ da empresa é obrigatório.', $response->errors['company.document'][0]);
        $this->assertEquals('O campo razão social da empresa é obrigatório.', $response->errors['company.name'][0]);
        $this->assertEquals('O campo logradouro da empresa é obrigatório.', $response->errors['company.street'][0]);
        $this->assertEquals('O campo número da empresa é obrigatório.', $response->errors['company.number'][0]);
        $this->assertEquals('O campo bairro da empresa é obrigatório.', $response->errors['company.neighborhood'][0]);
        $this->assertEquals('O campo cidade da empresa é obrigatório.', $response->errors['company.city'][0]);
        $this->assertEquals('O campo estado da empresa é obrigatório.', $response->errors['company.state'][0]);
        $this->assertEquals('O campo país da empresa é obrigatório.', $response->errors['company.country'][0]);
        $this->assertEquals('O campo cep da empresa é obrigatório.', $response->errors['company.postal_code'][0]);
    }

    public function test_purchase_whitout_name()
    {
        unset($this->body['name']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O campo nome é obrigatório.', $response->errors['name'][0]);
    }

    public function test_purchase_whitout_phone()
    {
        unset($this->body['phone']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O campo telefone é obrigatório.', $response->errors['phone'][0]);
    }

    public function test_purchase_whitout_document()
    {
        unset($this->body['document']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O campo documento é obrigatório.', $response->errors['document'][0]);
    }

    public function test_purchase_whitout_email()
    {
        unset($this->body['email']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O campo email é obrigatório.', $response->errors['email'][0]);
    }

    public function test_purchast_company_street()
    {
        unset($this->body['street']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEQuals("O campo rua é obrigatório.", $response->errors['street'][0]);
    }

    public function test_purchase_whitout_number()
    {
        unset($this->body['number']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEQuals("O campo número é obrigatório.", $response->errors['number'][0]);
    }

    public function test_purchase_whitout_neighborhood()
    {
        unset($this->body['neighborhood']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEQuals("O campo bairro é obrigatório.", $response->errors['neighborhood'][0]);
    }

    public function test_purchase_whitout_city()
    {
        unset($this->body['city']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEQuals("O campo cidade é obrigatório.", $response->errors['city'][0]);
    }

    public function test_purchase_whitout_state()
    {
        unset($this->body['state']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEQuals("O campo estado é obrigatório.", $response->errors['state'][0]);
    }

    public function test_purchase_whitout_postal_code()
    {
        unset($this->body['postal_code']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O campo cep é obrigatório.', $response->errors['postal_code'][0]);
    }

    public function test_purchase_whitout_country()
    {
        unset($this->body['country']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O campo país é obrigatório.', $response->errors['country'][0]);
    }

    public function test_purchase_whitout_company_document()
    {
        unset($this->body['company']['document']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O campo CNPJ da empresa é obrigatório.', $response->errors['company.document'][0]);
    }

    public function test_purchase_whitout_company_name()
    {
        unset($this->body['company']['name']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O campo razão social da empresa é obrigatório.', $response->errors['company.name'][0]);
    }

    public function test_purchase_whitout_company_street()
    {
        unset($this->body['company']['street']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O campo logradouro da empresa é obrigatório.', $response->errors['company.street'][0]);
    }

    public function test_purchase_whitout_company_number()
    {
        unset($this->body['company']['number']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O campo número da empresa é obrigatório.', $response->errors['company.number'][0]);
    }

    public function test_purchase_whitout_company_neighborhood()
    {
        unset($this->body['company']['neighborhood']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O campo bairro da empresa é obrigatório.', $response->errors['company.neighborhood'][0]);
    }

    public function test_purchase_whitout_company_state()
    {
        unset($this->body['company']['postal_code']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O campo cep da empresa é obrigatório.', $response->errors['company.postal_code'][0]);
    }

    public function test_purchase_whitout_company_city()
    {
        unset($this->body['company']['city']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O campo cidade da empresa é obrigatório.', $response->errors['company.city'][0]);
    }

    public function test_purchase_whitout_company_country()
    {
        unset($this->body['company']['country']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O campo país da empresa é obrigatório.', $response->errors['company.country'][0]);
    }
}
