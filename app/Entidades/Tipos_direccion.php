<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Tipos_Direccion extends Model
{
    protected $table = 'tipos_direcciones';
    public $timestamps = false;

    protected $fillable = [
        'idtipodireccion', 'nombre'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idtipodireccion = $request->input('id')!="0" ? $request->input('id') : $this->idtipodireccion;
        $this->nombre = $request->input('txtNombre');
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idtipodireccion,
                  A.nombre
                FROM tipos_direcciones A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($idtipodireccion) {
        $sql = "SELECT
                idtipodireccion,
                nombre
                FROM tipos_direcciones WHERE idtipodireccion = '$idtipodireccion'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idtipodireccion = $lstRetorno[0]->idtipodireccion;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE tipos_direcciones SET
            nombre='$this->nombre'
            WHERE idtipodireccion=?";
        $affected = DB::update($sql, [$this->idtipodireccion]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM tipos_direcciones WHERE 
            idtipodireccion=?";
        $affected = DB::delete($sql, [$this->idtipodireccion]);
    }

    public function insertar() {
        $sql = "INSERT INTO tipos_direcciones (
                nombre
            ) VALUES (?);";
       $result = DB::insert($sql, [
            $this->nombre
        ]);
       return $this->idtipodireccion = DB::getPdo()->lastInsertId();
    }


}
