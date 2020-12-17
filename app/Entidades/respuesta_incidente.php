<?php

namespace App\Entidades;

use Illiminate\Database\Elonquent\Model;
use DB;
use Session;

class Respuesta_Incidente extends Model
{
    Protected $table = 'respuestas_incidentes';
    public $timestamps = false;

    protected $fillable = [
        'idrespuesta', 'respuesta', 'fk_idincidencia', 'fk_idusuario', 'fecha'
    ];
    protected $hidden =[];

    function cargarDesdeRequest($request){
        $this->idrespuesta = $request->input('id')!="0" ? $request->input('id') : $this->idrespuesta;
        $this->respuesta = $request->input('txtRespuesta');
        $this->fk_idincidencia = $request->input('lstIncidencia');
        $this->fk_idusuario= $request->input('lstUsuario');
        $this->fecha = $request->input('txtFecha');



    }
    public function obtenerTodos(){
        $sql = "SELECT
                 A.idrespuesta,
                 A.respuesta,
                 A.fk_idincidencia,
                 A.fk_usuario,
                 A.fecha
                FROM respuestas_incidentes A ORDER By A.respuesta,A.fk_idincidencia, A.fk_idusuario, A.fecha";
                $lstRetorno = DB::select($sql);
                return $lstRetorno;
    }


    public function obtenerPorId($idrespuesta){
        $sql = "SELECT
                 idrespuesta,
                 respuesta,
                 fk_idincidencia,
                 fk_usuario,
                 fecha
                 FROM respuestas_incidentes WHERE idrespuesta = '$idrespuesta'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idrespuesta = $lstRetorno[0]->idrespuesta;
            $this->respuesta = $lstRetorno[0]->respuesta;
            $this->fk_idincidencias = $lstRetorno[0]->fk_idincidencias;
            $this->fk_idusuario = $lstRetorno[0]->fk_idusuario;
            $this->fecha = $lstRetorno[0]->fecha;
            return $this;
        }
        return null;
    }
    public function guardar(){
        $sql = "UPDATE respuestas_incidentes SET
            respuesta = '$this->respuesta',
            fk_idincidenias = '$this->fk_incindencias',
            fk_usuario = '$this->fk_usuario',
            fecha = '$this->fecha'
            WHERE idrespuesta='?";
            $affected = DB::update($sql, [$this->idrespuesta]);

    }

    public function insertar(){
        $sql = "INSERT INTO repuestas_incidentes (
            respuesta,
            fk_idincidencias,
            fk_idusuario,
            fecha
            ) VALUES(?, ?, ?, ?);";
        $result = DB::insertar($sql, [
            $this->respuesta,
            $this->fk_idincidencia,
            $this->fk_idusuario,
            $this->fecha
        ]);
        
    }

    public function eliminar(){
        $sql = "DELETE FROM respuestas_incidentes WHERE
            idrespuesta=?";
        $affected = DB::delete($sql, [$this->idrespuesta]);
    }
}






?>