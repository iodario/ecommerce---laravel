<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class Sucursal extends Model
{
    protected $table = 'sucursales';
    public $timestamps = false;

    protected $fillable = [
        'idsucursal',
        'nombre',
        'direccion',
        'fk_idlocalidad'
    ];

    function cargarDesdeRequest($request) {
        $this->idsucursal = $request->input('id')!="0" ? $request->input('id') : $this->idsucursal;
        $this->nombre = $request->input('txtNombre');
        $this->direccion = $request->input('txtDireccion');
        $this->fk_idlocalidad = $request->input('lstLocalidad');
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idsucursal,
                  A.nombre,
                  A.direccion,
                  A.fk_idlocalidad
                FROM sucursales A ORDER BY idsucursal";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idsucursal) {
        $sql = "SELECT
                idsucursal,
                nombre,
                direccion,
                fk_idlocalidad
                FROM sucursales WHERE idsucursal = $idsucursal";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idsucursal = $lstRetorno[0]->idsucursal;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->direccion = $lstRetorno[0]->direccion;
            $this->fk_idlocalidad = $lstRetorno[0]->fk_idlocalidad;
            return $this;
        }
        return null;
    }

    public function obtenerFiltrado(){
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.nombre',
            1 => 'A.direccion',
            2 => 'B.nombre',
            3 => 'C.descprov'
        );
        $sql = "SELECT DISTINCT 
                    A.idsucursal,
                    A.nombre,
                    A.direccion,
                    B.nombre AS localidad,
                    C.descprov AS provincia
                FROM sucursales A
                INNER JOIN localidades B ON A.fk_idlocalidad = B.idlocalidad
                INNER JOIN provincias C ON B.fk_idprovincia = C.idprovincia
                WHERE 1=1";

        if(!empty($request['search']['value'])){
            $sql.= " AND (A.direccion LIKE '%" . $request['search']['value'] . "%' ";
            $sql.= " OR B.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.= " OR C.descprov LIKE '%" . $request['search']['value'] . "%')";
        }
        $sql.= " ORDER BY " . $columns[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function guardar() {
        $sql = "UPDATE sucursales SET
            nombre='$this->nombre',
            direccion='$this->direccion',
            fk_idlocalidad=$this->fk_idlocalidad
            WHERE idsucursal=?";
        $affected = DB::update($sql, [$this->idsucursal]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM sucursales WHERE 
            idsucursal=?";
        $affected = DB::delete($sql, [$this->idsucursal]);
    }

    public function insertar() {
        $sql = "INSERT INTO sucursales (
                    nombre,
                    direccion,
                    fk_idlocalidad
                    ) VALUES (?, ?, ?);";
        $result = DB::insert($sql, [
                        $this->nombre, 
                        $this->direccion, 
                        $this->fk_idlocalidad
                        ]);
        return $this->idsucursal = DB::getPdo()->lastInsertId();
    }


}

?>