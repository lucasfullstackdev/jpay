<?php

namespace App\Services\Banking;

use App\Dtos\Billing\BillingOshi;
use App\Dtos\Customer\CustomerAsaas;
use App\Dtos\Customer\CustomerOshi;
use App\Exceptions\Customer\CustomerCreate;
use App\Exceptions\Customer\CustomerCreateException;
use App\Services\Banking\Asaas\AsaasBilling;
use App\Services\Banking\Asaas\AsaasCustomer;
use Exception;
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
        return new CustomerOshi(
          (object) json_decode($response->getBody()->getContents(), true)
        );
      }

      /**
       * TODO: Adicionar CustomException do nicho de Customers
       */
      throw new CustomerCreateException('asdfasdf');
    } catch (\GuzzleHttp\Exception\RequestException $e) {
      dd($e->getMessage());
      // Handle request exception
      // Log or return error response
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

      dd($statusCode, json_decode($response->getBody()->getContents(), true));

      /**
       * TODO: Adicionar CustomException do nicho de Customers
       */
      throw new CustomerCreateException('asdfasdf');
    } catch (\GuzzleHttp\Exception\RequestException $e) {
      dd($e->getMessage());
      // Handle request exception
      // Log or return error response
    }
  }
}
