<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Localidad extends Model
{
    protected $table = 'localidades';
    public $timestamps = false;

    protected $fillable = [
        'idlocalidad', 'nombre', 'cod_postal'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idlocalidad = $request->input('id')!="0" ? $request->input('id') : $this->idmenu;
        $this->nombre = $request->input('txtNombre');
        $this->cod_postal = $request->input('cod_postal');       
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idlocalidad,
                  A.nombre,
                  A.cod_postal
                  
                FROM localidades A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idlocalidad) {
        $sql = "SELECT
                idlocalidad,
                nombre,
                cod_postal     
                FROM localidades WHERE idlocalidad = '$idlocalidad'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idlocalidad = $lstRetorno[0]->idlocalidad;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->cod_postal = $lstRetorno[0]->cod_postal;                     
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE localidades SET
            nombre='$this->nombre',
            cod_postal='$this->cod_postal'
           
            WHERE idlocalidad=?";
        $affected = DB::update($sql, [$this->idlocalidad]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM localidades WHERE 
            idlocalidad=?";
        $affected = DB::delete($sql, [$this->idlocalidad]);
    }

    public function insertar() {
        $sql = "INSERT INTO localidades (
                nombre,
                cod_postal          
           ) VALUES (?, ?);";
       $result = DB::insert($sql, [
            $this->nombre, 
            $this->cod_postal            
        ]);
       return $this->idlocalidad = DB::getPdo()->lastInsertId();
    }
    public function obtenerPorIdProvincia($idprovincia){
        $sql = "SELECT
                idlocalidad,
                nombre,
                cod_postal     
                FROM localidades WHERE fk_idprovincia = '$idprovincia'";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}

?>



    
    





