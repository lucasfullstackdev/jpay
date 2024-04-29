<?php

namespace App\Jobs\CMS;

use App\Models\Customer;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class CMSJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   */
  public function __construct(protected string $document)
  {
  }

  protected function getCustomer(): ?Customer
  {
    // Verificar se o documento existe
    $document = $this->getDocument();
    if (empty($document)) {
      return null;
    }

    return Customer::where('sku', $document->customer)->first();
  }

  protected function getDocument(): Document
  {
    return Document::where('document_id', $this->document)->first();
  }
}
