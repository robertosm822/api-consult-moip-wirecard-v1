<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClientesController extends Controller
{
    public function __construct()
    {
        $_moip = \Moip::start();
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
                $customer = $this->_moip->customers()->setOwnId(uniqid())
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
                        
            $customer = $this->_moip->customers()->setOwnId(uniqid())
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

    public function createOrderOne(Request $request)
    {
        /*
            Enviar IDcustomer
            Enviar product_name [nome do produto]
            Enviar qtd_prod [quantidade de produtos]
            Enviar cod_prod [codigo unico do produto]
            Enviar valor_prod [valor do produto do tipo inteiro sem decimal]
        */
        $form = $request->all();
        $dataCarrinho = [
            'id_consumer'   => (isset($form['id_consumer']))? $form['id_consumer']      : '',
            'product_name'  => (isset($form['product_name']))? $form['product_name']    : '',
            'qtd_prod'      => (isset($form['qtd_prod']))? $form['qtd_prod']            : '',
            'cod_prod'      => (isset($form['cod_prod']))? $form['cod_prod']            : '',
            'valor_prod'    => (isset($form['valor_prod']))? $form['valor_prod']        : '',
        ];
        $total = 0;
        foreach ($dataCarrinho as $key => $value)
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
            
            $idList = self::lerlog("log_clientes.txt");
            if($idList != "")
            {
                $moip = \Moip::start();
                $idCustomers  = explode(",", $idList);
                $idCliente = $idCustomers[1];
                $customer = $moip->customers()->get($idCliente);
                
                $order = $moip->orders()->setOwnId(uniqid())
                    ->addItem('Notebook Lenovo', 2, 'SKH1', 350000)
                    ->setShippingAmount(4500)
                    ->setDiscont(3000)
                    ->setCustomer($customer)
                    ->create();
                //gravar log de ordens geradas
                self::gravarLog($order->getId(), "log_ordens.txt");
                
                return $order->getId();
                exit();
            }
            return [];
            
        } catch (\Exception $e) {
            return ['Error'=> $e->__toString()];
        }
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
