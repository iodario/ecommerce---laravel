<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Estados_Incidente extends Model
{
    protected $table = 'estados_incidentes';
    public $timestamps = false;

    protected $fillable = [
        'idestado', 'estado'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idestado = $request->input('id')!="0" ? $request->input('id') : $this->iddireccion;
        $this->estado = $request->input('txtEstado');
       
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idestado,
                  A.estado              
                FROM estados_incidentes A ORDER BY A.idestado";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idmenu) {
        $sql = "SELECT
                idestado,
                estado

                FROM estados_incidentes WHERE idestado = '$idestado'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idestado = $lstRetorno[0]->idestado;
            $this->estado = $lstRetorno[0]->estado;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE estados_incidentes SET
            estado='$this->estado',
        
        
            WHERE idestado=?";
        $affected = DB::update($sql, [$this->idestado]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM estados_incidentes WHERE 
            idestado=?";
        $affected = DB::delete($sql, [$this->ididreccion]);
    }

    public function insertar() {
        $sql = "INSERT INTO estados_incidentes (
                estado
             
            ) VALUES (?);";
       $result = DB::insert($sql, [
            $this->estado
        
        ]);
       return $this->idestado = DB::getPdo()->lastInsertId();
    }



}
