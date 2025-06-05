<?php

namespace App\Services\Signature\ClickSign;

use App\Enums\Payment\PaymentCycle;
use App\Enums\Person;
use App\Enums\SignerAs;
use App\Exceptions\DocumentException;
use App\Models\Customer;
use App\Models\OfficeSigner;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ClickSignDocument
{
  public array $document;

  public function __construct(public Customer $customer)
  {
    try {
      $this->document['path'] = '/' . Carbon::now()->format('Y/m/d') . "/$customer->document-$customer->email-" . Str::uuid() . '.docx';

      $witnessess = $this->getWitnessess();
      $this->document['template'] = [
        'data' => [
          'contractor'              => $this->getContractor(),

          'payment.cycle' => $this->getPaymentCycle(),
          'payment.value' => $this->getPaymentValue(),
          'payment.cycleDescription' => $this->getPaymentCycleDescription(),

          'customer_name'           => $customer->name,
          'customer_document'       => $customer->documentFormatted,

          'first_witness_name'      => $witnessess[0]['name'],
          'first_witness_document'  => $witnessess[0]['document'],
          'second_witness_name'     => $witnessess[1]['name'],
          'second_witness_document' => $witnessess[1]['document'],
        ]
      ];
    } catch (\Throwable $th) {
      throw new DocumentException('Erro ao criar estrutura que será utilizada para criar documento na ClickSign', $th->getMessage());
    }
  }

  private function getPaymentCycle()
  {
    $ciclos = [
      PaymentCycle::MONTHLY->value => 'mensal',
      PaymentCycle::SEMIANNUALLY->value => 'semestral',
      PaymentCycle::YEARLY->value => 'anual',
    ];

    return $ciclos[$this->customer->subscription->cycle];
  }

  private function getPaymentValue()
  {
    return number_format($this->customer->subscription->value, 2, ',', '.');
  }

  private function getPaymentCycleDescription()
  {
    if ($this->customer->subscription->cycle == PaymentCycle::MONTHLY->value) {
      return 'todo dia ' . Carbon::now()->format('d') . ' de cada mês';
    }

    if ($this->customer->subscription->cycle == PaymentCycle::YEARLY->value) {
      return 'todo dia ' . Carbon::now()->format('d/m') . ' de cada ano';
    }

    if ($this->customer->subscription->cycle == PaymentCycle::SEMIANNUALLY->value) {
      return 'a cada 6 meses, tomando como base o dia ' . Carbon::now()->format('d/m/Y');
    }
  }

  private function getWitnessess(): array
  {
    return OfficeSigner::where('sign_as', SignerAs::WITNESS->value)->get()->map(fn ($witness) => [
      'name'     => $witness->name,
      'document' => $witness->documentFormatted,
    ])->toArray();
  }

  private function getContractor(): string
  {
    if ($this->customer->person == Person::PF->value) {
      return $this->getContractorPhysicalPerson();
    }

    return $this->getContractorLegalPerson();
  }

  private function getContractorPhysicalPerson(): string
  {
    return "{$this->customer->name}, brasileiro(a), portador do CPF de número {$this->customer->documentFormatted}, residente e domiciliado na {$this->customer->address}.";
  }

  private function getContractorLegalPerson(): string
  {
    return "{$this->customer->company->name}, pessoa Jurídica de direito privado, inscrita no CNPJ sob o número {$this->customer->company->documentFormatted}, com sede na {$this->customer->company->address} neste ato representado por {$this->customer->name}, brasileiro(a), portador do CPF de número {$this->customer->documentFormatted}.";
  }
}
