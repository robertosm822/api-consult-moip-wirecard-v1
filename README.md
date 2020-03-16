# API - Consult - Moip - Wirecard - v1
Laravel 5.5 query API for Wirecard Payment Gateway (MOIP).

## Requisitos de servidores para Laravel 5.5:
    
    - PHP >= 7.0.0
    - OpenSSL PHP Extension
    - PDO PHP Extension
    - Mbstring PHP Extension
    - Tokenizer PHP Extension
    - XML PHP Extension

## Renomear arquivos: 
 - 'package.json.template' para 'package.json'
 - 'composer.json.template' para 'composer.json'
 - '.env.example' para '.env'

## Instalar as dependencias usando o COMPOSER:
 
    - composer install

## Crie uma conta SANDBOX no Wirecard: 

    - https://bem-vindo-sandbox.wirecard.com.br/


## Recursos a Serem Integrados:
    - Clientes - https://dev.wirecard.com.br/v2.0/reference#2-clientes-mp


## Referências de recursos usados:
 - https://laravel.com/docs/5.5/installation
 - https://github.com/fruitcake/laravel-cors

## Incluir no arquivo `.env` os serguintes valores da API:

    ``
    MOIP_KEY=yourkeyfortheservice
    MOIP_TOKEN=yourtokefortheservice
    MOIP_HOMOLOGATED=keyshomologatedtrueorfalse``

## Inicializar (opcional) o server:
  - php artisan serve

## Rotas dos seviços criados:

  - localhost:8000/api/v1/create-customer [POST]

   ``Espera os seguintes campos para envio via POSTMAN ou Formulário:

    fullname: STRING
    email: STRING
    data_nascimento: STRING_DATA_FORMAT[ANO-MES-DIA]
    cpf: STRING 11 [SOMENTE NUMEROS]
    telefone: STRING [XX XXXXXXXXX]
    logradouro: STRING
    numero: NUMERIC
    bairro: STRING
    cidade: STRING
    uf: STRING 2
    cep: STRING [8] SOMENTE NUMEROS``
    
  - localhost:8000/api/v1/create-order: