<?php

namespace App\Dtos\Document;

use App\Exceptions\DocumentException;

class DocumentOshi
{
  public string $customer;
  public string $document_id;
  public string $document;

  public function __construct(object $response)
  {
    try {
      $this->customer    = $response->customer;
      $this->document_id = $response->document['key'];
      $this->document    = json_encode($response->document);
    } catch (\Throwable $th) {
      throw new DocumentException('Erro ao criar estrutura que será utilizada para salvar documento da ClickSign no Banco de Dados', $th->getMessage());
    }
  }
}
