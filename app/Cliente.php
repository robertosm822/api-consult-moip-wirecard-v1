<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    /*
        // recurso esperado pela API WIRECARD
    */
    protected $fillable = [ 'nome', 'email', 'telefone', 'data_nascimento', 'endereco', 'complemento', 'bairro', 'cep'];
}
