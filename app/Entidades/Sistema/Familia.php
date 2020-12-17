<?php

namespace App\Entidades\Sistema;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Familia extends Model
{
    protected $table = 'sistema_familias';
    public $timestamps = false;

    protected $fillable = [
    	'nombre', 'descripcion'
    ];

 function cargarDesdeRequest($request) {
        $this->idfamilia = $request->input('id')!= "0" ? $request->input('id') : $this->idfamilia;
        $this->nombre =$request->input('txtNombre');
        $this->descripcion =$request->input('txtDescripcion');
    }

    public function insertar() {
        $sql = "INSERT INTO sistema_familias (
                nombre,
                descripcion
                ) VALUES (?, ?);";
        $result = DB::insert($sql, [$this->nombre, $this->descripcion]);
        return $this->idfamilia = DB::getPdo()->lastInsertId();
    }

    public function guardar() {
        $sql = "UPDATE sistema_familias SET
            nombre='$this->nombre',
            descripcion='$this->descripcion'
            WHERE idfamilia=?;";
        $affected = DB::update($sql, [$this->idfamilia]);
    }

    public function obtenerTodos($grupoID = null) {
        $dacy = new Dacy();
        $sql = "SELECT 
            idfamilia,
            nombre,
            descripcion
            FROM sistema_familias WHERE TRUE ";
        $sql .= " ORDER BY nombre";
        $lstRetorno = $dacy->exeQueryEntity($sql, "sistema_familias");

        return $lstRetorno;
    }

    public function obtenerGrilla() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'nombre',
            1 => 'nombre',
            2 => 'nombre',
            3 => 'descripcion');
        $sql = "SELECT
                idfamilia,
                nombre,
                descripcion
                FROM sistema_familias  WHERE 1=1 ";

        if (!empty($request['search']['value'])) {         
            $sql.=" AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR descripcion LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerTodosPorUsuario($usuarioID) {
        $sql = "SELECT DISTINCT
                A.idfamilia,
                A.nombre,
                A.descripcion
                FROM sistema_familias A 
                INNER JOIN sistema_usuario_familia B ON B.fk_idfamilia = A.idfamilia
                WHERE B.fk_idusuario = $usuarioID ";
        $sql .= " ORDER BY nombre";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function validarFamiliaPorUsuarioArea($familiaID, $usuarioID, $areaID){
        $sql = "SELECT DISTINCT
                A.fk_idfamilia
                FROM sistema_usuario_familia A
                WHERE A.fk_idfamilia = $familiaID AND A.fk_idusuario = $usuarioID AND A.fk_idarea = $areaID";
        $lstRetorno = DB::select($sql);
        return count($lstRetorno)>0;
    }

    public function obtenerTodosPorUsuarioPorModulo($usuarioID, $modulo) {
        $dacy = new Dacy();
        $sql = "SELECT
                DISTINCT A.idfamilia,
                A.nombre,
                A.descripcion,
                D.modulo
                FROM sistema_familias A 
                INNER JOIN sistema_usuario_familia B ON B.fk_idfamilia = A.idfamilia
                INNER JOIN sistema_patente_familia C ON C.fk_idfamilia = A.idfamilia
                INNER JOIN sistema_patentes D ON D.idpatente = C.fk_idpatente
                WHERE B.fk_idusuario = $usuarioID AND D.modulo = '$modulo'";
        $sql .= " ORDER BY nombre";
        $lstRetorno = $dacy->exeQueryEntity($sql, "sistema_familias");

        return $lstRetorno;
    }

    public function obtenerPorId($idfamilia) {
       $sql ="SELECT
            idfamilia,
            nombre,
            descripcion
            FROM sistema_familias WHERE idfamilia = '$idfamilia'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idfamilia =$lstRetorno[0]->idfamilia;
            $this->nombre =$lstRetorno[0]->nombre;
            $this->descripcion =$lstRetorno[0]->descripcion;
            return $lstRetorno[0];
        }
        return null;
    }

}
