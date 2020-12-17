<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;
use Session;

class Direccion_envio extends Model
{
    protected $table = 'direccion_envio';
    public $timestamps = false;

    protected $fillable = [
        'iddireccion_envio','nombre','apellido','email', 'domicilio', 'ciudad', 'pais', 'cp', 'telefono', 'comentario','provincia'
    ];

    function cargarDesdeRequest($request) {
        $this->iddireccion_envio= $request->input('id')!="0" ? $request->input('id') : $this->iddireccion;
        $this->nombre = $request->input('txtNombre');
        $this->apellido = $request->input('txtApellido');
        $this->email= $request->input('txtEmail');
        $this->domicilio = $request->input('txtDomicilio');
        $this->ciudad = $request->input('lstCiudad');
        $this->provincia = $request->input('lstProvincia');
        $this->pais = $request->input('lstPais');
        $this->cp = $request->input('txtCp');
        $this->telefono = $request->input('txtTelefono');
        $this->comentario = $request->input('txtComentario');
        
    }
    public function insertar (){
        $sql = "INSERT direccion_envio (nombre,apellido,email,domicilio,ciudad,pais,cp,telefono,comentario,provincia)VALUE(?,?,?,?,?,?,?,?,?,?)";
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
        
        return $this->iddireccion_envio = DB::getPdo()->lastInsertId();
    }
    public function obtenerPorIdDireccion($idDireccionEnvio){
        $sql="SELECT  A.iddireccion_envio, A.nombre,A.apellido,A.email,A.domicilio,c.nombre AS ciudad ,D.descpais AS pais ,A.cp,A.telefono,A.comentario,E.descprov AS provincia
        FROM direccion_envio A 
        INNER JOIN provincias E ON A.provincia = E.idprovincia
        INNER JOIN paises D ON A.pais = D.idpais
        INNER JOIN localidades c ON A.ciudad = c.idlocalidad
        WHERE iddireccion_envio = '$idDireccionEnvio'";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }   
        
}