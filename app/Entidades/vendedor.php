<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Vendedor extends Model
{
    protected $table = 'vendedores';
    public $timestamps = false;

    protected $fillable = [
        'idvendedor', 'fk_idusuario', 'fk_idsucursal', 'cuil'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idvendedor = $request->input('id')!="0" ? $request->input('id') : $this->idvendedor;
        $this->fk_idusuario = $request->input('lstUsuario');
        $this->fk_idsucursal = $request->input('lstSucursal');
        $this->cuil = $request->input('txtCuil');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'B.nombre',
           1 => 'B.usuario',
           2 => 'C.nombre',
           3 => 'A.cuil',
            );
        $sql = "SELECT DISTINCT
                    A.idvendedor,
                    B.nombre,
                    B.usuario,
                    C.nombre AS sucursal,
                    A.cuil
                FROM vendedores A
                LEFT JOIN sistema_usuarios B ON A.fk_idusuario = B.idusuario
                LEFT JOIN sucursales C ON A.fk_idsucursal = C.idsucursal
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( B.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.usuario LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR C.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.cuil LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idvendedor,
                  A.fk_idusuario,
                  A.fk_idsucursal,
                  A.cuil
                FROM vendedores A ORDER BY A.idvendedor";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    

    public function obtenerPorId($idvendedor) {
        $sql = "SELECT
                idvendedor,
                fk_idusuario,
                fk_idsucursal,
                cuil
                FROM vendedores WHERE idvendedor = '$idvendedor'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idvendedor = $lstRetorno[0]->idvendedor;
            $this->fk_idusuario = $lstRetorno[0]->fk_idusuario;
            $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
            $this->cuil = $lstRetorno[0]->cuil;
            return $this;
        }
        return null;
    }

   

    public  function eliminar() {
        $sql = "DELETE FROM vendedores WHERE 
            idvendedor=?";
        $affected = DB::delete($sql, [$this->idvendedor]);
    }

    public function insertar() {
        $sql = "INSERT INTO vendedores (
                fk_idusuario,
                fk_idsucursal,
                cuil
            ) VALUES (?, ?, ?);";
       $result = DB::insert($sql, [
            $this->fk_idusuario, 
            $this->fk_idsucursal, 
            $this->cuil
        ]);
       return $this->idvendedor = DB::getPdo()->lastInsertId();
    }

    public function guardar() {
        $sql = "UPDATE vendedores SET
            fk_idusuario='$this->fk_idusuario',
            fk_idsucursal='$this->fk_idsucursal',
            cuil=$this->cuil
            WHERE idvendedor=?";
        $affected = DB::update($sql, [$this->idvendedor]);
    }

   

}
