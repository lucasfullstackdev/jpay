<?php

namespace App\Services\Banking;

use App\Dtos\Billing\BillingOshi;
use App\Dtos\Customer\CustomerOshi;
use App\Dtos\Subscription\SubscriptionOshi;
use App\Exceptions\RequestException;
use App\Services\Banking\Asaas\{AsaasBilling, AsaasCustomer, AsaasSubscription};
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
        return new CustomerOshi((object) $response);
      }
    } catch (\GuzzleHttp\Exception\RequestException $e) {
      throw new RequestException('Erro ao criar o Customer no ASAAS', $e->getMessage(), (array) $customer);
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
      throw new RequestException('Erro ao criar cobrança no ASAAS', $e->getMessage(), (array) $billing);
    }
  }

  public function createSubscription(AsaasSubscription $subscription)
  {
    $client = new Client();
    try {
      $response = $client->post(env('ASAAS_URL') . '/subscriptions', [
        'headers' => [
          'access_token' => env('ASAAS_TOKEN')
        ],
        'body' => json_encode($subscription)
      ]);

      $statusCode = $response->getStatusCode();

      if ($statusCode === 200) {
        return new SubscriptionOshi(
          (object) json_decode($response->getBody()->getContents(), true)
        );
      }
    } catch (\GuzzleHttp\Exception\RequestException $e) {
      throw new RequestException('Erro ao criar assinatura no ASAAS', $e->getMessage(), (array) $subscription);
    }
  }
}
