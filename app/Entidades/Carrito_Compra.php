<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Carrito_Compra extends Model
{
    protected $table = 'carrito_compras';
    public $timestamps = false;

    protected $fillable = [
        'idcarrito', 'cantidad' ,'fk_idproducto', 'fk_idcliente', 'fecha'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idcarrito = $request->input('id')!="0" ? $request->input('id') : $this->idcarrito;
        $this->fk_idproducto = $request->input('lstProducto');
        $this->fk_idcliente = $request->input('lstCliente');
        $this->cantidad = $request->input('txtCantidad');
        $this->fecha = "";
    }

    public function obtenerTodos() {
        $sql = "SELECT 
        A.idcarrito,
        A.cantidad,
        B.nombre AS producto,
        A.fk_idcliente
        FROM carrito_compras A INNER JOIN productos B ON A.fk_idproducto=B.idproducto";
        $sql .= " ORDER BY A.idcarrito";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorCliente($idcliente){
        $sql = "SELECT
                    A.idcarrito,
                    A.cantidad,
                    A.fk_idproducto,
                    B.nombre AS producto,
                    B.precio AS precio,
                    B.foto AS imagen,
                    A.fecha
                FROM carrito_compras A
                INNER JOIN productos B ON A.fk_idproducto = B.idproducto
                WHERE fk_idcliente= '$idcliente'  ORDER BY A.fecha ASC ";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

     public function obtenerPorId($idcarrito) {
        $sql = "SELECT
                idcarrito,
                cantidad,
                fk_idproducto,
                fk_idcliente,
                fecha
                FROM carrito_compras WHERE idcarrito = $idcarrito";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idcarrito = $lstRetorno[0]->idcarrito;
            $this->cantidad = $lstRetorno[0]->cantidad;
            $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            $this->fecha = $lstRetorno[0]->fecha;
            return $this;
        }
        return null;
    }

       public function guardar() {
        $sql = "UPDATE carrito_compras SET
            cantidad=$this->cantidad,
            fk_idproducto=$this->fk_idproducto,
            fk_idcliente=$this->fk_idcliente
            WHERE idcarrito=?";
        $affected = DB::update($sql, [$this->idcarrito]);
    }


      public  function eliminar() {
        $sql = "DELETE FROM carrito_compras WHERE 
            idcarrito=?";
        $affected = DB::delete($sql, [$this->idcarrito]);
    }
    public  function eliminarPorIdCarrito($idCarrito) {
        $sql = "DELETE FROM carrito_compras WHERE 
            idcarrito='$idCarrito' ";
        $affected = DB::delete($sql);
    }
    
    
    public function eliminarPorCliente($idCliente){
        $sql = "DELETE FROM carrito_compras WHERE 
        fk_idcliente=$idCliente";
      $affected = DB::delete($sql);
    }
    

 public function insertar() {
        $sql = "INSERT INTO carrito_compras (
                cantidad,
                fk_idproducto,
                fk_idcliente,
                fecha
            ) VALUES (?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->cantidad,
            $this->fk_idproducto, 
            $this->fk_idcliente,
            $this->fecha = date("Y/m/d H:i:s")
        ]);
       return $this->idcarrito = DB::getPdo()->lastInsertId();
    }
    

}
