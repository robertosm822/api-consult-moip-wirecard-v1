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

### Rotas dos seviços criados:

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
    
    ```
    Enviar IDcustomer (gerado no primeiro link ou no aquivo gerado de log_ordens.txt)
    Enviar product_name [nome do produto]    
    Enviar qtd_prod [quantidade de produtos]    
    Enviar cod_prod [codigo unico do produto]    
    Enviar valor_prod [valor do produto do tipo inteiro sem decimal]```

    
    Campos esperados:

    * id_consumer:CUS-2GLT9JWW74MU
    * product_name: TV 42 Polegas Sansumg
    * qtd_prod: 1
    * cod_prod: SAN42
    * valor_prod: 158000
  
  - localhost:8000/api/v1/get-order-by-id/ID_ORDER_CREATED

    Enviar ID de Ordem Criada [GET]