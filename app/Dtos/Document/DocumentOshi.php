<?php

namespace App\Dtos\Document;

class DocumentOshi
{
  public string $customer;
  public string $document_id;
  public string $document;

  public function __construct(object $response)
  {
    $this->customer = $response->customer;
    $this->document_id = $response->document['key'];
    $this->document = json_encode($response->document);
  }
}
