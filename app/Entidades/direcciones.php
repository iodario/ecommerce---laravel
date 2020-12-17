<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Direcciones extends Model
{
    protected $table = 'sistema_menues';
    public $timestamps = false;

    protected $fillable = [
        'iddireccion', 'domicilio', 'numero', 'fk_idlocalidad', 'codigo_postal', 'fk_idtipodireccion', 'fk_idcliente'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->iddireccion = $request->input('id')!="0" ? $request->input('id') : $this->iddireccion;
        $this->domicilio = $request->input('txtDomicilio');
        $this->numero = $request->input('txtNumero');
        $this->fk_idlocalidad = $request->input('lstLocalidad');
        $this->codigopostal = $request->input('codigopostal');
        $this->fk_idtipodireccion = $request->input('lstTipodireccion');
        $this->fk_idcliente = $request->input('lstcliente');
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.iddireccion,
                  A.domicilio,
                  A.numero,
                  A.fk_idlocalidad,
                  A.codigo_postal,
                  A.fk_idtipodireccion,
                  A.fk_idcliente

                FROM direcciones A ORDER BY A.domiclio";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idmenu) {
        $sql = "SELECT
                iddireccion,
                domicilio,
                fk_idlocalidad,
                codigo_postal,
                fk_idtipodireccion,
                fk_idcliente

                FROM direcciones WHERE iddireccion = '$iddireccion'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->iddireccion = $lstRetorno[0]->iddireccion;
            $this->domicilio = $lstRetorno[0]->domicilio;
            $this->fk_idlocalidad = $lstRetorno[0]->fk_idlocalidad;
            $this->codigo_postal = $lstRetorno[0]->codigo_postal;
            $this->fk_istipodireccion = $lstRetorno[0]->fk_istipodireccion;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE direcciones SET
            domicilio='$this->domicilio',
            numero='$this->numero',
            fk_idlocalidad='$this->fk_idlocalidad',
            codigo_postal=$this->codigo_postal,
            fk_idtipodireccion='$this->fk_idtipodireccion',
            fk_idcliente='$this->fk_idcliente'
            WHERE iddireccion=?";
        $affected = DB::update($sql, [$this->iddireccion]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM direcciones WHERE 
            ididreccion=?";
        $affected = DB::delete($sql, [$this->ididreccion]);
    }

    public function insertar() {
        $sql = "INSERT INTO direcciones (
                domicilio,
                numero,
                fk_idlocalidad,
                codigo_postal,
                fk_idtipodireccion,
                fk_idcliente
            ) VALUES (?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->domicilio,
            $this->numero, 
            $this->fk_idlocalidad, 
            $this->codigo_postal, 
            $this->fk_idtipodireccion,
            $this->fk_idcliente
        ]);
       return $this->ididreccion = DB::getPdo()->lastInsertId();
    }

}
