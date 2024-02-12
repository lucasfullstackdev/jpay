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
        $this->assertCount(10, $response->errors);
        $this->assertEquals([
            'name',
            'email',
            'phone',
            'document',
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
