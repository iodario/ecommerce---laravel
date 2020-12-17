<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Incidente extends Model
{
    protected $table = 'incidentes';
    public $timestamps = false;
    protected $fillable = [
        'idincidente', 'nombre', 'fk_idventa', 'descripcion', 'fecha', 'fk_idestado'
    ];

    protected $hidden = [

    ];    

    function cargarDesdeRequest($request) {
        $this->idincidente = $request->input('id')!="0" ? $request->input('id') : $this->idincidente;
        $this->nombre = $request->input('txtNombre');
        $this->fk_idventa = $request->input('fk_idventa');
        $this->descripcion = $request->input('txtdescripcion'); 
        $this->fecha = $request->input('txtFecha');
        $this->fk_idestado = $request->input('fk_idestado');        
    }
    
    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idincidente,
                  A.nombre,
                  A.fk_idventa,
                  A.descripcion,
                  A.fecha,
                  A.fk_idestado 
                FROM incidentes A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idincidente) {
        $sql = "SELECT
                idincidente,
                nombre,
                fk_idventa,
                descripcion,
                fecha,
                fk_idestado                
                FROM incidentes WHERE idincidente = '$idincidente'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idincidente = $lstRetorno[0]->idincidente;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->fk_idventa = $lstRetorno[0]->fk_idventa;
            $this->descripcion = $lstRetorno[0]->descripcion;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->fk_idestado = $lstRetorno[0]->fk_idestado;            
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE incidentes SET
            nombre='$this->nombre',
            fk_idventa='$this->fk_idventa',
            descripcion=$this->descripcion,
            fecha='$this->fecha',           
            fk_idestado='$this->fk_idestado'
            WHERE idincidente=?";
        $affected = DB::update($sql, [$this->idincidente]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM incidentes WHERE 
            idincidente=?";
        $affected = DB::delete($sql, [$this->idincidente]);
    }

    public function insertar() {
        $sql = "INSERT INTO incidentes (
                nombre,
                fk_idventa,
                descripcion,
                fecha,               
                fk_idestado
            ) VALUES (?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->nombre, 
            $this->fk_idventa, 
            $this->descripcion, 
            $this->fecha,             
            $this->fk_idestado
        ]);
       return $this->idincidente = DB::getPdo()->lastInsertId();
    }

}



?>
