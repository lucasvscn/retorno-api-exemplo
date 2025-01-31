# Aplicação Exemplo

O objetivo desse exemplo é demonstrar o uso de técnicas para padronizar as
respostas de API em uma aplicação Laravel.

Problemas:

 - Monolito tem rotas Web e AJAX
 - Mesma aplicação é usada como backend para app mobile
 - Monolito web e app mobile compartilham algumas rotas, mas não todas
 - Base de código grande e complexa

Premissas:

 - Padronização não deve exigir mudanças estruturantes
 - Ponto único de controle para respostas de erro
 - Rotas Web e AJAX não devem sofrer alterações

Solução:

 - Definir classe de resposta padrão para API
 - Configurar renderable() para tratar exceções e retornar respostas padronizadas
 - Criar um middleware para injetar cabeçalho na request para identificar chamadas da API

Arquivos de interesse da solução:

 - `app/ApiResponse.php`
 - `app/Exceptions/Handler.php`

# Instalação

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

Acesse a aplicação em `http://localhost:8000`.

Use as credenciais `test@example.com` e `password` para logar.
