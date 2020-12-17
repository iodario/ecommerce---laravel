<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    public $timestamps = false;

    protected $fillable = [
        'idcategoria', 'nombre', 'fk_idpadre',
    ];

    public function cargarDesdeRequest($request)
    {
        $this->idcategoria = $request->input('id') != "0" ? $request->input('id') : $this->idcategoria;
        $this->nombre = $request->input('txtNombre');
        $this->fk_idpadre = $request->input('lstPadre');
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                    A.idcategoria,
                    A.nombre,
                    A.fk_idpadre
                FROM categorias A ORDER by A.idcategoria";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idcategoria)
    {
        $sql = "SELECT
                    idcategoria,
                    nombre,
                    fk_idpadre
                FROM categorias WHERE idcategoria = '$idcategoria'";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcategoria = $lstRetorno[0]->idcategoria;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->fk_idpadre = $lstRetorno[0]->fk_idpadre;
            return $this;
        }
        return null;
    }

    public function guardar()
    {
        $sql = "UPDATE categorias SET
                        nombre = '$this->nombre',
                        fk_idpadre = $this->fk_idpadre
                WHERE idcategoria = ?";
        $affected = DB::update($sql, [$this->idcategoria]);
    }

    public function insertar() {
        $sql = "INSERT INTO categorias(
                nombre,
                fk_idpadre
            ) VALUES (?, ?);";
       $result = DB::insert($sql, [
            $this->nombre, 
            $this->fk_idpadre
            
        ]);
       return $this->idcategoria = DB::getPdo()->lastInsertId();
    }

    public function eliminar()
    {
        $sql = "DELETE FROM categorias WHERE idcategoria = ?";
        $affected = DB::delete($sql, [$this->idcategoria]);
    }

    public function obtenerCategoriasPadre()
    {
        $sql = "SELECT DISTINCT
                  A.idcategoria,
                  A.nombre
                FROM categorias A
                WHERE A.fk_idpadre = 0 ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.idcategoria',
           1 => 'A.nombre',
           2 =>'B.nombre '
            );
        $sql = "SELECT DISTINCT
                A.idcategoria,
                A.nombre AS categoria,
                B.nombre as padre
                FROM categorias A
                LEFT JOIN categorias B ON  
                A.fk_idpadre = B.idcategoria 
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.nombre LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

}
