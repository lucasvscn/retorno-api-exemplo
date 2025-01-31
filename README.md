# Aplicação Exemplo

## Descrição

O objetivo desse exemplo é demonstrar o uso de técnicas para padronizar as
respostas de API em uma aplicação Laravel.

*Problemas:*

 - Monolito tem rotas Web e AJAX
 - Mesma aplicação é usada como backend para app mobile
 - Monolito web e app mobile compartilham algumas rotas, mas não todas
 - Base de código grande e complexa

*Premissas:*

 - Padronização não deve exigir mudanças estruturantes
 - Ponto único de controle para respostas de erro
 - Rotas Web e AJAX não devem sofrer alterações

*Solução:*

 - Definir classe de resposta padrão para API
 - Configurar renderable() para tratar exceções e retornar respostas padronizadas
 - Criar um middleware para injetar cabeçalho na request para identificar chamadas da API

*Arquivos de interesse da solução:*

 - `app/ApiResponse.php`
 - `app/Exceptions/Handler.php`

## Instruções para execução

```shell
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

Acesse a aplicação em `http://localhost:8000`.

Use as credenciais `test@example.com` e `password` para acessar a aplicação.

## Exemplos de Request e Response para API

### Request rota Web via API não autenticado:

```shell
curl -s -X GET --url http://localhost:8000/post \
--header 'Accept: application/json'
```

Response:

```json
{
  "status": 401,
  "error_code": 1003,
  "message": "Não autenticado",
  "data": null,
  "validation_errors": [],
  "meta": []
}
```

### Request para rota Web via API:

```shell
curl -s -X GET --url http://localhost:8000/post/1 \
--header 'Accept: application/json'
```

Response:

```json
{
  "status": 200,
  "error_code": 0,
  "message": "Sucesso",
  "data": {
    "id": 1,
    "title": "Post 1",
    "content": "Conteúdo do post 1"
  },
  "validation_errors": [],
  "meta": []
}
```

### Post para rota Web sem CSRF token:

```shell
curl -s -X POST --url http://localhost:8000/post \
--header 'Accept: application/json' \
--header 'Content-Type: application/x-www-form-urlencoded'
```

Response:

```json
{
  "status": 419,
  "error_code": 1002,
  "message": "CSRF token mismatch.",
  "data": null,
  "validation_errors": [],
  "meta": {
    "exception": "Symfony\\Component\\HttpKernel\\Exception\\HttpException"
  }
}
```

### Request API para obter lista de posts:

```shell
curl -s -X GET --url http://localhost:8000/api/posts \
--header 'Accept: application/json'
```

Response:

```json
{
  "status": 200,
  "error_code": 0,
  "message": "Sucesso!",
  "data": [
    {
      "id": 1,
      "title": "Optio aut dolores ea voluptates voluptates sunt ut ea.",
      "created_at": "2025-01-31T02:09:40.000000Z"
    },
    {
      "id": 2,
      "title": "Itaque accusamus consequuntur eum libero reprehenderit deleniti praesentium.",
      "created_at": "2025-01-31T02:09:40.000000Z"
    },
    {
      "id": 3,
      "title": "Libero facilis eos aut porro omnis.",
      "created_at": "2025-01-31T02:09:40.000000Z"
    }
  ],
  "validation_errors": [],
  "meta": []
}
```

### Request API para criar um post:

```shell
curl -s -X POST --url http://localhost:8000/api/post \
--header 'Accept: application/json' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'title=Post via API' \
--data-urlencode 'body=Conteúdo do post via API'
```

Response:

```json
{
  "status": 200,
  "error_code": 0,
  "message": "Sucesso!",
  "data": {
    "id": 8,
    "title": "Post via API"
  },
  "validation_errors": [],
  "meta": []
}
```

### Request API para criar um post, com erro de validação:

```shell
curl -s -X POST --url http://localhost:8000/api/post \
--header 'Accept: application/json' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'title='
```

Response:

```json
{
  "status": 422,
  "error_code": 1001,
  "message": "Erro de validação",
  "data": null,
  "validation_errors": {
    "title": [
      "The title field is required."
    ],
    "body": [
      "The body field is required."
    ]
  },
  "meta": []
}
```
