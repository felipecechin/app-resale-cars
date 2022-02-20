## Backend: tecnologias e versões

Foram utilizadas as seguintes tecnologias no backend:

- PHP 7.4.6 e Laravel 8.83.1
- PostgreSQL 14.2
- Composer 2.2.1

## Frontend: tecnologias e versões

Foram utilizadas as seguintes tecnologias no frontend:

- Vue 3.2.31 com Bootstrap 5.1.3
- Versão do Node utilizada: 14.11.0
- Versão do NPM: 6.14.8

## Ao clonar repositório

1. Criar banco de dados no PostgreSQL com o nome ```app_revenda_carros```
2. Entrar na pasta backend
3. Criar o arquivo de ambiente .env com base no arquivo .env.example e definir parâmetros de conexão ao banco de dados
4. Executar comando ```composer install``` para instalar dependências
5. Executar comando ```php artisan migrate``` para criar as tabelas no banco
6. Executar comando ```php artisan serve``` para inicializar backend
7. Entrar na pasta frontend
8. Executar comando ```npm install``` para instalar dependências
9. Executar comando ```npm run serve```
10. Acessar sistema pela url http://localhost:8080
