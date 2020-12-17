<?php

namespace App\Entidades\Sistema;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Area extends Model
{
    protected $table = 'sistema_areas';
    public $timestamps = false;

    protected $fillable = [
    	'ncarea', 'descarea', 'activo'
    ];

    public function cargarDesdeRequest($request) {
        $this->idarea = $request->input('id')!= "0" ? $request->input('id') : $this->idarea;
        $this->ncarea =$request->input('txtNombreCorto');
        $this->descarea =$request->input('txtNombre');
        $this->activo = $request->input('lstEstado');
    }

    public function obtenerPorId($idarea) {
       $sql ="SELECT
            idarea,
            ncarea,
            descarea,
            activo
            FROM sistema_areas WHERE idarea = '$idarea'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idarea =$lstRetorno[0]->idarea;
            $this->ncarea =$lstRetorno[0]->ncarea;
            $this->descarea =$lstRetorno[0]->descarea;
            $this->activo =$lstRetorno[0]->activo;
            return $lstRetorno[0];
        }
        return null;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                A.idarea, 
                A.ncarea,
                A.descarea
                FROM sistema_areas A
                WHERE A.activo = 1 ORDER BY A.descarea DESC";
        
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerAreasDelUsuario($usuarioID) {
        $sql = "SELECT DISTINCT 
                A.idarea, 
                A.ncarea, 
                A.descarea
                FROM sistema_areas A
                INNER JOIN sistema_usuario_familia B ON A.idarea = B.fk_idarea AND B.fk_idusuario = $usuarioID
                WHERE A.activo = 1 ORDER BY A.descarea DESC";
        
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function insertar() {
        $sql = "INSERT INTO sistema_areas (
        ncarea,
        descarea,
        activo
        ) VALUES (?, ?, ?);";
       $result = DB::insert($sql, [$this->ncarea, $this->descarea, $this->activo]);
       $this->idarea = DB::getPdo()->lastInsertId();
    }

    public function guardar() {
        $sql = "UPDATE sistema_areas SET
            ncarea='$this->ncarea',
            descarea='$this->descarea',
            activo='$this->activo'
            WHERE idarea=?;";
        $affected = DB::update($sql, [$this->idarea]);
    }

    public function obtenerGrilla() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.ncarea',
            1 => 'A.ncarea',
            2 => 'A.ncarea');
        $sql = "SELECT 
                    idarea,
                    ncarea,
                    descarea,
                    activo
                FROM sistema_areas A WHERE 1=1";

        if (!empty($request['search']['value'])) {      
            $sql.=" AND ( A.descarea LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


}
