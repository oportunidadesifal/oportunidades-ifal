# oportunidades-ifal
- API oportunidades IFAL
- Projeto Oportunidades IFAL,  baseado no sistema O Oportunista. Par divulgação de oportunidades de prática profissional(estágios, monitoria, empregos e projetos) e engajamento na área(eventos).

## Arquitetura:
- Em linguagem PHP, com API REST usando framework slim e e front-end simples usando templates twig. Banco de dados mysql, Usando Phinx, para migrations do banco de dados. 

## Instalação do Projeto:
* Instalar PHP e Mysql, podendo usar o XAMPP(https://www.apachefriends.org/).

* Clone do repositorio (git clone repositório)

* Instalar o composer

* executar o apache e mysql no XAMPP.

* executar o migration do banco de dados (https://phinx.org)

> `php composer require robmorgan/phinx`

> `vendor/bin/phinx migrate`

* rodar o dump do banco de dados oportunista.sql que está no repositório

- executar no cmd ou shell na pasta api:
> $php composer update`

- executar o servidor web embutido na pasta api/public
>`$ cd public`

>`$ php -S localhost:8000`

* Fazer deploy no Heroku para rodar online(criar uma conta no heroku.com:)

  * Ver teste em : https://ifal-oportunidades.herokuapp.com

