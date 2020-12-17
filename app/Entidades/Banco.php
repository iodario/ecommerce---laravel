<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Banco extends Model
{
    protected $table = 'bancos';
    public $timestamps = false;
    
    protected $fillable = [
        'idbanco', 'nombre', 'codigo'
    ];

    public function cargarDesdeRequest($request){
        $this->idbanco = $request->input('id')!= "0" ? $request->input('id') : $this->idbanco;
        $this->nombre = $request->input('txtNombre');
        $this->codigo = $request->input('codigo');
    }

    public function obtenerTodos(){
        $sql = "SELECT
                    A.idbanco,
                    A.nombre,
                    A.codigo
                FROM bancos A ORDER by A.idbanco";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idbanco){
        $sql = "SELECT
                    idbanco,
                    nombre,
                    codigo
                FROM bancos WHERE idbanco = '$idbanco'";
        $listRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->idbanco = $lstRetorno[0]->idbanco;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->codigo = $lstRetorno[0]->codigo;
            return $this;
        }
        return null;
    }

    public function guardar(){
        $sql = "UPDATE bancos SET
                        nombre = '$this->nombre',
                        codigo = $this->codigo
                WHERE idbanco = ?";
        $affected = DB::update($sql, [$this->idbanco]);
    }

    public function insertar(){
        $sql = "INSERT INTO bancos (
                            nombre,
                            codigo)
                VALUES (?, ?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->codigo
        ]);
        return $this->idbanco = DB::getPdo()->lastInsertId();
    }

    public function eliminar(){
        $sql = "DELETE FROM bancos WHERE idbanco = ?";
        $affected = DB::delete($sql, [$this->idbanco]);
    }
}

?>