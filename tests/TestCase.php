<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        // Configuração do ambiente de teste
        $this->artisan('migrate', ['--env' => 'testing']);
    }
}
