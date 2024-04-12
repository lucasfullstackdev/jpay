<?php

namespace App\Services;

use App\Exceptions\CreateException;
use App\Models\Customer;
use App\Models\Document;
use App\Services\Signature\ClickSign\ClickSignDocument;
use App\Services\Signature\SignatureService;
use Illuminate\Support\Facades\DB;

class DocumentService
{
  public function __construct(private SignatureService $signatureService)
  {
  }

  public function createDocument(object $payment)
  {
    $customer = $this->getCustomer($payment);
    /** Se nao encontrar o customer, barrar */
    if (empty($customer)) {
      return;
    }

    /** Se encontrar documento, barrar */
    if ($this->hasDocument($customer)) {
      return;
    }

    // Envia o documento para a ClickSign
    $document = $this->sendDocument($customer);

    // Cria o documento no banco de dados
    try {
      DB::beginTransaction();
      $document = Document::create($document);
      DB::commit();

      return $document;
    } catch (\Throwable $th) {
      throw new CreateException('Erro ao salvar Documento no Banco de Dados', $th->getMessage());
    }
  }

  private function getCustomer(object $payment)
  {
    return Customer::with('company')->where('sku', $payment->customer)->first();
  }

  private function hasDocument(Customer $customer): bool
  {
    return (bool) Document::where('customer', $customer->sku)->first() ?? null;
  }

  private function sendDocument(Customer $customer)
  {
    return (array) $this->signatureService->sendDocument(
      new ClickSignDocument($customer)
    );
  }
}
