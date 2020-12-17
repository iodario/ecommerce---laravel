<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class TransferenciaBancaria extends Model
{
    protected $table = 'tranferencias';
    public $timestamps = false;

    protected $fillable = [
        'idtransferencia', 'fk_idbanco', 'sucursal', 'alias', 'cuenta', 'cuit', 'razonsocial', 'cbu'
    ];

    protected $hidden = [

    ];
    function cargarDesdeRequest($request) {
        $this->idtransferencia = $request->input('id')!="0" ? $request->input('id') : $this->idmediopago;
        $this->fk_idbanco = $request->input('lstBanco');  
        $this->sucursal = $request->input('txtSucursal'); 
        $this->alias = $request->input('txtAlias'); 
        $this->cuenta = $request->input('txtCuenta'); 
        $this->cuit = $request->input('txtCuit'); 
        $this->razonsocial = $request->input('txtRazon'); 
        $this->cbu = $request->input('txtCbu'); 
    }
    public function obtenerTodos() {
        $sql = "SELECT
            A.idtransferencia,
            B.nombre AS banco,
            C.nombre AS sucursal,
            A.alias,
            A.cuenta,
            A.cuit,
            A.razonsocial,
            A.cbu
        FROM transferencias A INNER JOIN bancos B on
        A.fk_idbanco=B.idbanco
        INNER JOIN	sucursales C ON A.sucursal=C.idsucursal"; 
      
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
    public function obtenerPorId ($id){
        $sql="SELECT 
            idtransferencia,
            fk_idbanco,
            sucursal,
            alias,
            cuenta,
            cuit,
            razonsocial,
            cbu
            FROM transferencias WHERE idtransferencia='$id'";
        $lstRetorno = DB::select($sql);

    }
    public function guardar(){
        $sql="UPDATE transferencias SET 
        fk_idbanco='$this->fk_idbanco',
        sucursal='$this->sucursal',
        alias='$this->alias',
        cuenta='$this->cuenta',
        cuit='$this->cuit',
        razonsocial='$this->razonsocial',
        cbu='$this->cbu'
        WHERE idtransferencia=?";
        $affected = DB::update($sql,[$this->idtranferencia]);
        
    }
    public function eliminar(){
        $sql="DELETE FROM transferencias WHERE idtransferencia=?";
        $affected = DB::delete($sql,[$this->idtransferencia]);
    }
   
    
}
