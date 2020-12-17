<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Medio_Pago extends Model
{
    protected $table = 'medios_pago';
    public $timestamps = false;
    protected $clavepublica;
    protected $tokenacceso;

    protected $fillable = [
        'idmediopago', 'nombre'
    ];

    protected $hidden = [

    ];
    function cargarDesdeRequest($request) {
        $this->idmediopago = $request->input('id')!="0" ? $request->input('id') : $this->idmediopago;
        $this->nombre = $request->input('txtNombre');        
    }
    public function obtenerTodos() {
        $sql = "SELECT
                  A.idmediopago,
                  A.nombre
                FROM medios_pago A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
    public function obtenerPorId ($idmediopago){
        $sql="SELECT 
            idmediopago,
            nombre
            FROM medios_pago WHERE idmediopago=?";
        $lstRetorno = DB::select($sql,[$this->idmediopago]);

    }
    public function guardar(){
        $sql="UPDATE medios_pago SET 
        nombre='$this->nombre'
        WHERE idmediopago=?";
        $affected = DB::update($sql,[$this->idmediopago]);
        
    }
    public function eliminar(){
        $sql="DELETE FROM medios_pago WHERE idmediopago=?";
        $affected = DB::delete($sql,[$this->idmediopago]);
    }
    public function insertar(){
        $sql="INSERT INTO medios_pago(
            nombre)
            VALUES(?);";
        $result=DB::insert($sql,[$this->nombre]);

    }
    
}
