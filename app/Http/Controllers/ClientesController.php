<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClientesController extends Controller
{
    public function __construct()
    {
        $moip = \Moip::start();
    }
    
    public function index()
    {
        $id = self::lerlog("log_clientes.txt");
        
        $idCliente = [];
        /*
            Grava um ID de cliente em arquivo de Log caso nao exista
        */
        if($id != "")
        {
            $idCustomers  = explode(",", $id);
            $idCliente = $idCustomers[0];
        } else {
            try {
                $customer = $this->moip->customers()->setOwnId(uniqid())
                    ->setFullname('Fulano de Tal')
                    ->setEmail('fulano-01@email.com')
                    ->setBirthDate('1988-12-30')
                    ->setTaxDocument('22222222222')
                    ->setPhone(11, 66778899)
                    ->addAddress('BILLING',
                        'Rua de teste', 123,
                        'Bairro', 'Sao Paulo', 'SP',
                        '01234567', 8)
                    ->addAddress('SHIPPING',
                              'Rua de teste do SHIPPING', 123,
                              'Bairro do SHIPPING', 'Sao Paulo', 'SP',
                              '01234567', 8)
                    ->create();
                self::gravarLog($customer->getId(), "log_clientes.txt");
                $idCliente = $customer->getId();
            } catch (\Exception $e) {
                dd($e->__toString());
            }
        }

        // Cliente::all();
        return  ["idCliente"=>$idCliente];
    }

    public function createCustomer(Request $request)
    {
        $idCliente='';
        $form = $request->all();
        $clienteDados = [
            'fullname'          => (isset($form['fullname']))? $form['fullname'] : '',
            'email'             => (isset($form['email']))? $form['email'] : '',
            'data_nascimento'    => (isset($form['data_nascimento']))? $form['data_nascimento'] : '',
            'cpf'               => (isset($form['cpf']))? $form['cpf'] : '',
            'telefone'          => (isset($form['telefone']))? $form['telefone'] : '',
            'logradouro'        => (isset($form['logradouro']))? $form['logradouro'] : '',
            'numero'            => (isset($form['numero']))? $form['numero'] : '',
            'bairro'            => (isset($form['bairro']))? $form['bairro'] : '',
            'cidade'            => (isset($form['cidade']))? $form['cidade'] : '',
            'uf'                => (isset($form['uf']))? $form['uf'] : '',
            'cep'               => (isset($form['cep']))? $form['cep'] : '',
            /*
            'exp_month'         => (isset($form['exp_mounth']))? $form['exp_mounth'] : '',
            'exp_year'          => (isset($form['exp_year']))? $form['exp_year'] : '',
            'card_number'       => (isset($form['card_number']))? $form['card_number'] : '',
            'cvc'               => (isset($form['cvc']))? $form['cvc'] : '',
            'telefone_number'   => (isset($form['telefone_number']))? $form['telefone_number'] : '',
            'ddd'               => (isset($form['ddd']))? $form['ddd'] : ''
            */
        ];
        $total = 0;
        foreach ($clienteDados as $key => $value)
        {
            if($value === ''){
                $total += $total++;
            }  
           
        }
        if($total > 0){
            return ['Error'=> "Todos os campos são obrigatorios."];
            exit();
        }
           
       
        try {
                        
            $customer = $this->moip->customers()->setOwnId(uniqid())
                        ->setFullname($clienteDados['fullname'])
                        ->setEmail($clienteDados['email'])
                        ->setBirthDate($clienteDados['data_nascimento'])
                        ->setTaxDocument($clienteDados['cpf'])
                        ->setPhone(12,$clienteDados['telefone'])
                        ->addAddress('BILLING', 
                            $clienteDados['logradouro'], 
                            $clienteDados['numero'], 
                            $clienteDados['bairro'], 
                            $clienteDados['cidade'], 
                            $clienteDados['uf'], 
                            $clienteDados['cep'])
                        ->create();
            
            self::gravarLog($customer->getId(), "log_clientes.txt");
            $idCliente = $customer->getId();
        } catch (\Exception $e) {
            
            return ['Error'=> $e->__toString()];
            exit();
        }

        return $idCliente;
    }

    public function createOrderOne(Request $request, Cliente $cliente)
    {
        
        try {
            /*
            $order = $this->moip->orders()->setOwnId(uniqid())
                ->addItem("bicicleta 1",1, "sku1", 10000)
                ->addItem("bicicleta 2",1, "sku2", 11000)
                ->addItem("bicicleta 3",1, "sku3", 12000)
                ->addItem("bicicleta 4",1, "sku4", 13000)
                ->addItem("bicicleta 5",1, "sku5", 14000)
                ->addItem("bicicleta 6",1, "sku6", 15000)
                ->addItem("bicicleta 7",1, "sku7", 16000)
                ->addItem("bicicleta 8",1, "sku8", 17000)
                ->addItem("bicicleta 9",1, "sku9", 18000)
                ->addItem("bicicleta 10",1, "sku10", 19000)
                ->setShippingAmount(3000)->setAddition(1000)->setDiscount(5000)
                ->setCustomer($customer)
                ->create();
        
            dd($order);
            */
        } catch (\Exception $e) {
            dd($e->__toString());
        }
        return [];
    }
   

    public function gravarLog($texto, $arquivo)
    {
        //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
        $fp = fopen($arquivo, "a+");
     
        //Escreve no arquivo aberto.
        fwrite($fp, $texto.",");
         
        //Fecha o arquivo.
        fclose($fp);
    }
    
    public function lerlog($arquivo)
    {
        //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
        if (file_exists($arquivo) )
        $fp = fopen($arquivo, "r");
        $conteudo ='';

        if(filesize($arquivo) > 0)
        {
            //Lê o conteúdo do arquivo aberto.
            $conteudo = fread($fp, filesize($arquivo));
        }
        
        //Fecha o arquivo.
        fclose($fp);
         
        //retorna o conteúdo.
        return $conteudo;
    }

}
