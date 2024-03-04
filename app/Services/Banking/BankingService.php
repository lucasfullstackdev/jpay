<?php

namespace App\Services\Banking;

use App\Dtos\Billing\BillingOshi;
use App\Dtos\Customer\CustomerOshi;
use App\Exceptions\RequestException;
use App\Services\Banking\Asaas\AsaasBilling;
use App\Services\Banking\Asaas\AsaasCustomer;
use GuzzleHttp\Client;

class BankingService
{
  public function createCustomer(AsaasCustomer $customer): CustomerOshi
  {
    $client = new Client();

    try {
      $response = $client->post(env('ASAAS_URL') . '/customers', [
        'headers' => [
          'access_token' => env('ASAAS_TOKEN')
        ],
        'body' => json_encode($customer)
      ]);

      $statusCode = $response->getStatusCode();

      if ($statusCode === 200) {
        $response = json_decode($response->getBody()->getContents(), true);
        $response['document'] = $customer->document;

        return new CustomerOshi((object) $response);
      }
    } catch (\GuzzleHttp\Exception\RequestException $e) {
      throw new RequestException('Erro ao criar o Customer no ASAAS', $e->getMessage(), $customer);
    }
  }

  public function createBilling(AsaasBilling $billing)
  {
    $client = new Client();

    try {
      $response = $client->post(env('ASAAS_URL') . '/payments', [
        'headers' => [
          'access_token' => env('ASAAS_TOKEN')
        ],
        'body' => json_encode($billing)
      ]);

      $statusCode = $response->getStatusCode();

      if ($statusCode === 200) {
        return new BillingOshi(
          (object) json_decode($response->getBody()->getContents(), true)
        );
      }
    } catch (\GuzzleHttp\Exception\RequestException $e) {
      throw new RequestException('Erro ao criar cobrança no ASAAS', $e->getMessage(), $billing);
    }
  }
}
