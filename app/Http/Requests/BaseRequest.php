<?php

namespace App\Http\Requests;

use App\Dtos\DiscordMessage;
use App\Jobs\SendErrorToDiscordJob;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
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
    // Envia o erro para o Discord
    SendErrorToDiscordJob::dispatch(
      new DiscordMessage('Erro nos dados recebidos pela Landing Page', Response::HTTP_BAD_REQUEST, [
        'payload' => $this->all(),
        'errors'  => $validator->errors()
      ]),
      env('DISCORD_WEBHOOK_URL_LANDING_PAGE_ERRORS')
    );

    throw new HttpResponseException(response()->json([
      'success' => false,
      'errors'  => $validator->errors(),
      'data'    => []
    ], Response::HTTP_BAD_REQUEST));
  }
}
