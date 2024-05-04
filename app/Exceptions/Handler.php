<?php

namespace App\Exceptions;

use App\Dtos\DiscordMessage;
use App\Jobs\SendErrorToDiscordJob;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception): void
    {
        /**
         * Se for erro customizado, já está enviando para o Discord, então não precisa enviar novamente.
         * Se não for erro customizado, envia para o Discord.
         * 
         * Assim temos uma cobertura de 100% dos erros da aplicação sendo enviados para o Discord.
         * 
         * Erros de:
         * - código mesmo
         * - Customizados (Requisições, Dtos, Validações, etc)
         * - Landing Page
         */
        if (!($exception instanceof CustomException)) {
            SendErrorToDiscordJob::dispatch(
                new DiscordMessage('Erro não mapeado!', $exception->getMessage(), [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'previous' => $exception->getPrevious(),
                    'trace' => substr($exception->getTraceAsString(), 0, 700) . '...'
                ])
            );
        }

        parent::report($exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
