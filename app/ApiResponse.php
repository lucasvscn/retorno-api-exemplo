<?php

namespace App;

use Illuminate\Http\Response;

/**
 * Classe ApiResponse
 *
 * Essa classe é uma sugestão de implementação para padronizar as respostas da
 * API. Pode ser modificada conforme a necessidade do projeto e adaptada para
 * melhor se integrar com a base de código existente.
 */
class ApiResponse
{
    /**
     * Código de status HTTP
     *
     * @var int
     */
    public $statusCode;

    /**
     * Código de erro específico da aplicação
     *
     * @var int
     */
    public $errorCode;

    /**
     * Mensagem de resposta (opcional)
     *
     * @var string|null
     */
    public $message;

    /**
     * Dados da resposta (opcional)
     *
     * Aqui você pode passar os dados de retorno da requisição,
     * como um array, objeto ou qualquer outro tipo de dado.
     *
     * @var mixed
     */
    public $data;

    /**
     * Lista de erros de validação
     *
     * @var array
     */
    public $validationErrors = [];

    /**
     * Metadados da resposta
     *
     * Podem ser usados para passar informações adicionais, trace da requisição,
     * informações de paginação, mensagens de debug, etc.
     *
     * @var array
     */
    public $metaData = [];

    /**
     * Objeto de resposta do Laravel
     *
     * @var \Illuminate\Http\Response
     */
    private $response;

    /**
     * Construtor da classe
     *
     * @param \Illuminate\Http\Response|null $response
     * @return self
     */
    public function __construct($response = null)
    {
        $this->response = $response ?: response();

        // Podemos definir os atributos padrão, para o caso de
        // não serem definidos explicitamente.
        $this->statusCode = 200;
        $this->errorCode = 0;
        $this->message = 'Sucesso!';
    }

    /**
     * Cria uma nova instância da classe com os dados de resposta
     * definidos.
     *
     * @param mixed $data
     * @return self
     */
    public static function withData($data)
    {
        $instance = new self();
        $instance->data = $data;

        return $instance;
    }

    public function send()
    {
        // Prepara a resposta
        $response = [
            'status' => $this->statusCode,
            'error_code' => $this->errorCode,
            'message' => $this->message,
            'data' => $this->data,
            'validation_errors' => $this->validationErrors,
            'meta' => $this->metaData,
        ];

        // Envia a resposta
        return $this->response->json($response, $this->statusCode);
    }
}
