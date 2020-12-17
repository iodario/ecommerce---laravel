<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;
use Session;

class Direccion_otra extends Model
{
    protected $table = 'direccion_otra';
    public $timestamps = false;

    protected $fillable = [
        'iddireccion_otra','nombre','apellido','email', 'domicilio', 'ciudad', 'pais', 'cp', 'telefono', 'comentario','provincia'
    ];

    function cargarDesdeRequest($request) {
        $this->iddireccion = $request->input('id')!="0" ? $request->input('id') : $this->iddireccion;
        $this->nombre = $request->input('txtNombreAdd');
        $this->apellido = $request->input('txtApellidoAdd');
        $this->email= $request->input('txtEmailAdd');
        $this->domicilio = $request->input('txtDomicilioAdd');
        $this->ciudad = $request->input('lstCiudadAdd');
        $this->provincia = $request->input('lstProvinciaAdd');
        $this->pais = $request->input('lstPaisAdd');
        $this->cp = $request->input('txtCpAdd');
        $this->telefono = $request->input('txtTelefonoAdd');
        $this->comentario = $request->input('txtComentario');
        
    }
    public function insertar (){
        $sql = "INSERT direccion_otra (nombre,apellido,email,domicilio,ciudad,pais,cp,telefono,comentario,provincia)VALUE(?,?,?,?,?,?,?,?,?,?)";
        $lstRetorno = DB::insert($sql,[$this->nombre,
                                        $this->apellido,
                                        $this->email,
                                        $this->domicilio,
                                        $this->ciudad,
                                        $this->pais,
                                        $this->cp,
                                        $this->telefono,
                                        $this->comentario,
                                        $this->provincia ]);
        
        return $this->iddireccion = DB::getPdo()->lastInsertId();
    }
    public function obtenerPorIdDireccion($idDomicilioOtro){
        $sql="SELECT  A.iddireccion_otra, A.nombre,A.apellido,A.email,A.domicilio,c.nombre AS ciudad ,D.descpais AS pais ,A.cp,A.telefono,A.comentario,E.descprov AS provincia
        FROM direccion_otra A 
        INNER JOIN provincias E ON A.provincia = E.idprovincia
        INNER JOIN paises D ON A.pais = D.idpais
        INNER JOIN localidades c ON A.ciudad = c.idlocalidad
        WHERE A.iddireccion_otra  = '$idDomicilioOtro' ";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
        
}