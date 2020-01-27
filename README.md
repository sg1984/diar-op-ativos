## Ativos Operacionais

Projeto com o objetivo de apresentar os conhecimentos adquiridos durante o mestrado.

### Para rodar o projeto

#### Aplicações necessárias

* [PHP 7.2](https://www.php.net/downloads.php)
* [Composer](https://getcomposer.org/)
* [NPM](https://nodejs.org/en/download/)
* [MySQL](https://dev.mysql.com/downloads/mysql/) ou o banco de dados da sua preferência.

Após alterar as configurações do banco de dados no arquivo `diar-op-ativos/config/database.php` e criar um bando de dados no seu servidor, rode os seguintes comandos no seu terminal de comandos:

* `composer install`
* `npm install`
* `php artisan migrate --seed`
* `php artisan serve`

Após este último comando, o sistema deve estar pronto para ser acessado no link que aparecer no seu terminal.

## Licença

Este projeto de código aberto não tem fins lucrativos e é lincenciado sob a [licença MIT](https://opensource.org/licenses/MIT).
