<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e) {
            // Se app está rodando no console ou não espera uma resposta JSON,
            // então não faz nada. O Laravel vai tratar a exceção normalmente.
            if (app()->runningInConsole()
                || ! request()->expectsJson()) {
                return;
            }

            $apiResponse = new \App\ApiResponse();

            // Vamos identificar os diferentes tipos de exceções e retornar
            // respostas apropriadas para cada uma delas.
            // Você pode adicionar mais tipos de exceções conforme necessário.
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $apiResponse->statusCode = 422;
                $apiResponse->errorCode = 1001;
                $apiResponse->message = 'Erro de validação';
                $apiResponse->validationErrors = $e->errors();
            } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                $apiResponse->statusCode = $e->getStatusCode();
                $apiResponse->errorCode = 1002;
                $apiResponse->message = $e->getMessage();
                $apiResponse->metaData = [
                    'exception' => get_class($e),
                ];
            } elseif ($e instanceof \Illuminate\Auth\AuthenticationException) {
                $apiResponse->statusCode = 401;
                $apiResponse->errorCode = 1003;
                $apiResponse->message = 'Não autenticado';
            } elseif ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
                $apiResponse->statusCode = 403;
                $apiResponse->errorCode = 1004;
                $apiResponse->message = 'Acesso negado';
            } else {
                $apiResponse->statusCode = 500;
                $apiResponse->errorCode = 1003;
                $apiResponse->message = 'Erro interno do servidor';
                $apiResponse->metaData = [
                    'exception' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTrace(),
                ];
            }

            return $apiResponse->send();
        });
    }
}
