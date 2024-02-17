<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    private array $body = [
        "name" =>  "Nome do biscoito",
        "email" => "biscoito@jellycode.com.br",
        "phone" => "87999794136",
        "document" => "000999333221",
        'street' => 'Rua de teste',
        'number' => '32',
        'neighborhood' => 'bairro',
        'city' => 'cidade',
        'state' => 'PE',
        'country' => 'Brasil',
        "company" => [
            "document" => "48248201031",
            "name" => "Razao social",
            "street" => "rua da empresa",
            "number" => "48",
            "neighborhood" => "bairro",
            "zipCode" => "56328130"
        ]
    ];

    public function test_purchase_blank()
    {
        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', []);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(16, $response->errors);
        $this->assertEquals([
            'name',
            'email',
            'phone',
            'document',
            'street',
            'number',
            'neighborhood',
            'city',
            'state',
            'country',
            'company.document',
            'company.name',
            'company.street',
            'company.number',
            'company.neighborhood',
            'company.zipCode',
        ], array_keys($response->errors));

        $this->assertEquals('O campo nome é obrigatório.', $response->errors['name'][0]);
        $this->assertEquals('O campo email é obrigatório.', $response->errors['email'][0]);
        $this->assertEquals('O campo telefone é obrigatório.', $response->errors['phone'][0]);
        $this->assertEquals('O campo documento é obrigatório.', $response->errors['document'][0]);
        
        # Endereco do cliente
        $this->assertEQuals("O campo rua é obrigatório.", $response->errors['street'][0]);
        $this->assertEQuals("O campo número é obrigatório.", $response->errors['number'][0]);
        $this->assertEQuals("O campo bairro é obrigatório.", $response->errors['neighborhood'][0]);
        $this->assertEQuals("O campo cidade é obrigatório.", $response->errors['city'][0]);
        $this->assertEQuals("O campo estado é obrigatório.", $response->errors['state'][0]);
        $this->assertEQuals("O campo país é obrigatório.", $response->errors['country'][0]);

        # Dados da empresa
        $this->assertEquals('O documento da empresa é obrigatório.', $response->errors['company.document'][0]);
        $this->assertEquals('A Razão Social da empresa é obrigatório.', $response->errors['company.name'][0]);
        $this->assertEquals('O Logradouro da empresa é obrigatório.', $response->errors['company.street'][0]);
        $this->assertEquals('O Número da Sede da empresa é obrigatório.', $response->errors['company.number'][0]);
        $this->assertEquals('O Bairro da empresa é obrigatório.', $response->errors['company.neighborhood'][0]);
        $this->assertEquals('O CEP da empresa é obrigatório.', $response->errors['company.zipCode'][0]);
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

    public function test_purchase_whitout_company_document()
    {
        unset($this->body['company']['document']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O documento da empresa é obrigatório.', $response->errors['company.document'][0]);
    }

    public function test_purchase_whitout_company_name()
    {
        unset($this->body['company']['name']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('A Razão Social da empresa é obrigatório.', $response->errors['company.name'][0]);
    }

    public function test_purchase_whitout_company_street()
    {
        unset($this->body['company']['street']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O Logradouro da empresa é obrigatório.', $response->errors['company.street'][0]);
    }

    public function test_purchase_whitout_company_number()
    {
        unset($this->body['company']['number']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O Número da Sede da empresa é obrigatório.', $response->errors['company.number'][0]);
    }

    public function test_purchase_whitout_company_neighborhood()
    {
        unset($this->body['company']['neighborhood']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O Bairro da empresa é obrigatório.', $response->errors['company.neighborhood'][0]);
    }

    public function test_purchase_whitout_company_state()
    {
        unset($this->body['company']['zipCode']);

        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', $this->body);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(1, $response->errors);
        $this->assertEquals('O CEP da empresa é obrigatório.', $response->errors['company.zipCode'][0]);
    }
}
