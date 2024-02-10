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
        "document" => "000999333221"
    ];

    public function test_purchase_blank()
    {
        $response = $this->json('POST', '/api/v1/tax-domicile/purchase', []);
        $response = (object) $response->json();

        $this->assertFalse($response->success);
        $this->assertCount(4, $response->errors);
        $this->assertEquals(['name', 'email', 'phone', 'document'], array_keys($response->errors));
        $this->assertEquals('O campo nome é obrigatório.', $response->errors['name'][0]);
        $this->assertEquals('O campo email é obrigatório.', $response->errors['email'][0]);
        $this->assertEquals('O campo telefone é obrigatório.', $response->errors['phone'][0]);
        $this->assertEquals('O campo documento é obrigatório.', $response->errors['document'][0]);
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
}
