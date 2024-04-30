<?php

namespace App\Http\Requests;

use App\Dtos\DiscordMessage;
use App\Jobs\SendErrorToDiscordJob;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Symfony\Component\HttpFoundation\Response;

class BaseRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  protected function failedValidation(Validator $validator)
  {
    /**
     * Verifica se o email é válido e envia o erro para o Discord.
     * Essa verificação é necessária para evitar que o Discord seja inundado com mensagens de erro, afinal
     * o canal para captura dos erros da Landing Page será utilizado para recuperação de vendas.
     */
    if ($this->emailIsValid()) {
      $this->sendErrorToDiscord($validator);
    }

    throw new HttpResponseException(response()->json([
      'success' => false,
      'errors'  => $validator->errors(),
      'data'    => []
    ], Response::HTTP_BAD_REQUEST));
  }

  private function emailIsValid(): bool
  {
    $validator = FacadesValidator::make(['email' => $this->customer['email'] ?? null], [
      'email' => 'email:rfc,dns'
    ]);

    return !$validator->fails();
  }

  /**
   * Envio de erro para o Discord
   */
  private function sendErrorToDiscord($validator)
  {
    SendErrorToDiscordJob::dispatch(
      new DiscordMessage('Erro nos dados recebidos pela Landing Page', Response::HTTP_BAD_REQUEST, [
        'payload' => $this->all(),
        'errors'  => $validator->errors()
      ]),
      env('DISCORD_WEBHOOK_URL_LANDING_PAGE_ERRORS')
    );
  }
}
