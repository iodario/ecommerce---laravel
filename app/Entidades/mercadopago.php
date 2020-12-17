<?php

namespace App\Entidades;
use Illuminate\Database\Eloquent\Model;
use Session;
use DB;


class MercadoPago extends Model

{
    protected $table = 'mercadopago';
    public $timestamp = false;

    protected $fillable = [
        'clave_publica', 'token_acceso'
    ];

    public function obtener(){
        $sql = "SELECT
            A.clave_publica,
            A.token_acceso
            FROM mercadopago A ORDER BY clave_publica";
        $lstRetorno = DB :: select($sql);
        
        if(count($lstRetorno)>0){
            $this->clave_publica = $lstRetorno[0]->clave_publica;
            $this->token_acceso = $lstRetorno[0]->token_acceso;
            return $this;
        }  
        return null;      
    }

    public function guardar(){
        $sql ="UPDATE mercadopago SET
                    clave_publica = '$this->clave_publica',
                    token_acceso = '$this->token_acceso'";
            $affected=DB::update($sql);         
                         

    }

}