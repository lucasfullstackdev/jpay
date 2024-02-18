<?php

namespace App\Services\Signature\ClickSign;

use App\Models\Customer;
use App\Models\Witness;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ClickSignDocument
{
  public array $document;

  public function __construct(public Customer $customer)
  {
    $this->document['path'] = '/' . Carbon::now()->format('Y/m/d') . "/$customer->document-$customer->email-" . Str::uuid() . '.docx';

    $witnessess = $this->getWitnessess();
    $this->document['template'] = [
      'data' => [
        'company_name'            => $customer->company->name,
        'company_document'        => $customer->company->documentFormatted,
        'company_address'         => $customer->company->address,
        'customer_name'           => $customer->name,
        'customer_document'       => $customer->documentFormatted,
        'customer_address'        => $customer->address,
        'first_witness_name'      => $witnessess[0]['name'],
        'first_witness_document'  => $witnessess[0]['document'],
        'second_witness_name'     => $witnessess[1]['name'],
        'second_witness_document' => $witnessess[1]['document']
      ]
    ];
  }

  private function getWitnessess(): array
  {
    return Witness::all()->map(fn ($witness) => [
      'name'     => $witness->name,
      'document' => $witness->documentFormatted,
    ])->toArray();
  }
}
