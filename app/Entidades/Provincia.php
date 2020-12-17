<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Provincia extends Model
{
    protected $table = 'provincias';
    public $timestamps = false;

    protected $fillable = [
        'idprovincia', 'descprov', 'ncprov', 'fk_idpais'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idprovincia = $request->input('id')!="0" ? $request->input('id') : $this->idprovincia;
        $this->descprov = $request->input('txtDescprov');
        $this->ncprov = $request->input('txtNcprov');
        $this->fk_idpais = $request->input('lstPais');
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idprovincia,
                  A.descprov,
                  A.ncprov,
                  A.fk_idpais
                FROM provincias A ORDER BY A.descprov";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($idprovincia) {
        $sql = "SELECT
                descprov,
                ncprov,
                fk_idpais
                FROM provincias WHERE idprovincia = '$idprovincia'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idprovincia = $lstRetorno[0]->idprovincia;
            $this->descprov = $lstRetorno[0]->descprov;
            $this->ncprov = $lstRetorno[0]->ncprov;
            $this->fk_idpais = $lstRetorno[0]->fk_idpais;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE provincias SET
            descprov='$this->descprov',
            ncprov='$this->ncprov',
            fk_idpais=$this->idpais
            WHERE idprovincia=?";
        $affected = DB::update($sql, [$this->idprovincia]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM provincias WHERE 
            idprovincia=?";
        $affected = DB::delete($sql, [$this->idprovincia]);
    }

    public function insertar() {
        $sql = "INSERT INTO provincias (
                descprov,
                ncprov,
                fk_idpais
            ) VALUES (?, ?, ?);";
       $result = DB::insert($sql, [
            $this->descprov,
            $this->ncprov,
            $this->fk_idpais
        ]);
       return $this->idprovincia = DB::getPdo()->lastInsertId();
    }

    public function obtenerPorIdPais($idpais){
        
        $sql = "SELECT
        idprovincia,
        descprov,
        ncprov,
        fk_idpais
        FROM provincias WHERE fk_idpais = $idpais";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }   
}
