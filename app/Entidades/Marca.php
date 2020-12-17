<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marcas';
    public $timestamps = false;

    protected $fillable = [
        'idmarca', 'nombre',
    ];

    public function cargarDesdeRequest($request)
    {
        $this->idmarca = $request->input('id') != "0" ? $request->input('id') : $this->idmarca;
        $this->nombre = $request->input('txtNombre');
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                    A.idmarca,
                    A.nombre
                FROM marcas A ORDER by A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idmarca)
    {
        $sql = "SELECT
                    idmarca,
                    nombre
                FROM marcas WHERE idmarca = '$idmarca'";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idmarca = $lstRetorno[0]->idmarca;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;
    }

    public function guardar()
    {
        $sql = "UPDATE marcas SET
                    nombre = '$this->nombre'
                WHERE idmarca = ?";
        $affected = DB::update($sql, [$this->idmarca]);
    }

    public function insertar() {
        $sql = "INSERT INTO marcas(
                nombre
            ) VALUES (?);";
       $result = DB::insert($sql, [
            $this->nombre
            
        ]);
       return $this->idmarca = DB::getPdo()->lastInsertId();
    }

    public function eliminar()
    {
        $sql = "DELETE FROM marcas WHERE idmarca = ?";
        $affected = DB::delete($sql, [$this->idmarca]);
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.idmarca',
           1 => 'A.nombre',
            );
        $sql = "SELECT DISTINCT
                A.idmarca,
                A.nombre
                FROM marcas A
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

}