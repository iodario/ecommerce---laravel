<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Opinion extends Model
{
    protected $table = 'opiniones';
    public $timestamps = false;
    protected $fillable = [
        'idopinion', 'fk_idcliente', 'fk_idproducto', 'opinion', 'valoracion'
    ];

    protected $hidden = [

    ];    

    function cargarDesdeRequest($request) {
        $this->idopinion = $request->input('id')!="0" ? $request->input('id') : $this->idopinion;
        $this->fk_idcliente = $request->input('fk_idcliente');
        $this->fk_idproducto = $request->input('fk_idproducto');
        $this->opinion = $request->input('txtopinion'); 
        $this->valoracion = $request->input('optValoracion');
    }
    
    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idopinion,
                  A.fk_idcliente,
                  A.fk_idproducto,
                  A.opinion,
                  A.valoracion                
                FROM opiniones A ORDER BY A.idopinion";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idopinion) {
        $sql = "SELECT
                idopinion,
                fk_idcliente,
                fk_idproducto,
                opinion,
                valoracion                             
                FROM opiniones WHERE idopinion = '$idopinion'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idopinion = $lstRetorno[0]->idopinion;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
            $this->opinion = $lstRetorno[0]->opinion;
            $this->valoracion = $lstRetorno[0]->valoracion;                      
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE opiniones SET
            fk_idcliente='$this->fk_idcliente',
            fk_idproducto='$this->fk_idproducto',
            opinion=$this->opinion,
            valoracion='$this->valoracion'         
            WHERE idopinion=?";
        $affected = DB::update($sql, [$this->idopinion]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM opiniones WHERE 
            idopinion=?";
        $affected = DB::delete($sql, [$this->idopinion]);
    }

    public function insertar() {
        $sql = "INSERT INTO opiniones (
                fk_idcliente,
                fk_idproducto,
                opinion,
                valoracion             
                ) VALUES (?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->fk_idcliente, 
            $this->fk_idproducto, 
            $this->opinion, 
            $this->valoracion,             
           ]);
       return $this->idopinion = DB::getPdo()->lastInsertId();
    }

}



?>
