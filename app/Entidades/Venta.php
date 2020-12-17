<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Venta extends Model
{
    protected $table = "ventas";
    public $timestamp = false;

    function cargarDesdeRequest($request) {
        $this->idventa = $request->input('id')!="0" ? $request->input('id') : $this->idventa;
        $this->cantidad = $request->input('txtCantidad');
        $this->preciounitario = $request->input('txtPreciounitario');
        $this->total= $request->input('txtTotal');
        $this->fecha = $request->input('txtFecha');
        $this->fk_idmediopago = $request->input('chk_idmediodepago');
        $this->fk_idcliente = $request->input('txtCliente');
        $this->fk_idproducto = $request->input('txtProducto');
    
        
    }

    protected $fillable = [
        'idventa', 
        'cantidad', 
        'preciounitario', 
        'total', 
        'fecha', 
        'fk_idmediopago', 
        'fk_idcliente', 
        'fk_idproducto',
        'fk_idDomicilio',
        'fk_idDireccionEnvio'
    ];
    public function nuevaVenta($cantidad,$precioUni,$total,$fecha,$medioDePago,$idCliente,$idproducto,$idDomicilio,$idDireccionEnvio)
    {
        $sql="INSERT ventas 
        (cantidad,
        preciounitario,
        total,
        fecha,
        fk_idmediopago,
        fk_idcliente,
        fk_idproducto,
        fk_iddireccion_otra,
        fk_iddireccion_envio) 
        VALUES ($cantidad,$precioUni,$total,'$fecha',$medioDePago,$idCliente,$idproducto,$idDomicilio,$idDireccionEnvio)";
        $lstRetorno = DB::insert($sql);
        return $lst = DB::getPdo()->lastInsertId();
    }
    public function obtenerTodos(){
        $sql = "SELECT
                    A.idventa,
                    A.cantidad,
                    A.preciounitario,
                    A.total,
                    A.fecha,
                    A.fk_idmediopago,
                    A.fk_idcliente,
                    A.fk_idproducto
                FROM ventas A ORDER BY A.idventa;";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idventa){
        $sql = "SELECT
                    A.cantidad,
                    A.preciounitario,
                    A.total,
                    A.fecha,
                    A.fk_idmediopago,
                    A.fk_idcliente,
                    A.fk_idproducto
                FROM ventas A WHERE idventa = $idventa;";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->idventa = $lstRetorno[0]->idventa;
            $this->cantidad = $lstRetorno[0]->cantidad;
            $this->preciounitario = $lstRetorno[0]->preciounitario;
            $this->total = $lstRetorno[0]->total;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->fk_mediopago = $lstRetorno[0]->fk_mediopago;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
            return $this;
        }
        return null;
    }

    public function obtenerFiltrado(){
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.fecha',
            1 => 'B.producto',
            2 => 'A.cantidad',
            3 => 'A.preciounitario',
            4 => 'A.total',
            5 => 'F.cliente',
            6 => 'D.medio_pago'
        );
        $sql = "SELECT DISTINCT
        A.idventa,
        A.fecha,
        B.nombre AS producto,
        A.cantidad,
        A.preciounitario,
        A.total,
        F.nombre AS cliente,
        F.apellido,
        D.nombre AS medio_pago,
        A.preciounitario AS preciounitario_cliente
            FROM ventas A
            INNER JOIN productos B ON A.fk_idproducto = B.idproducto
            INNER JOIN medios_pago D ON A.fk_idmediopago = D.idmediopago
            INNER JOIN clientes E ON   E.idcliente = A.fk_idcliente
            INNER JOIN sistema_usuarios F ON  F.idusuario = E.fk_idusuario
            WHERE 1=1";

        if(!empty($request['search']['value'])){
            $sql.= " AND (A.fecha = '" . $request['search']['value'] ."'";
            $sql.= " OR B.producto LIKE '%" . $request['search']['value'] . "%' ";
            $sql.= " OR A.cantidad = " . $request['search']['value'];
            $sql.= " OR A.preciounitario = " . $request['search']['value'];
            $sql.= " OR A.total = " . $request['search']['value'];
            $sql.= " OR F.cliente = " . $request['search']['value'];
            $sql.= " OR D.medio_pago LIKE '%" . $request['search']['value'] . "%')";
        }

        $sql.= " ORDER BY " . $columns[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];
    
        $lstRetorno = DB::select($sql);
       
        return $lstRetorno;
    }

    public function obtenerPorCliente($idCliente){
        $sql = "SELECT
                    A.cantidad,
                    A.preciounitario,
                    A.total,
                    A.fecha,
                    A.fk_idmediopago,
                    A.fk_idcliente,
                    A.fk_idproducto
                FROM ventas A WHERE A.fk_idcliente = $idCliente;";
        $lstVenta = DB::select($sql);
        return $lstVenta;
    }
    public function obtenerVentaPorCliente($idCliente,$fecha){

        $sql = "SELECT
        A.idventa,
        A.cantidad,
        A.preciounitario,
        A.total,
        A.fecha,
        A.fk_idmediopago,
        A.fk_idcliente,
        A.fk_iddireccion_otra,
        A.fk_iddireccion_envio,
        A.env_email,
        B.nombre AS producto,
        B.descripcion,
        C.nombre AS mediodepago,
        B.foto
        FROM ventas A INNER JOIN productos B ON A.fk_idproducto = B.idproducto 
        INNER JOIN	medios_pago C  on A.fk_idmediopago = C.idmediopago
         WHERE A.fk_idcliente = '$idCliente' AND A.fecha = '$fecha'";
        $lstVenta = DB::select($sql);
        return $lstVenta;
    }

    public function obtenerVentaPorEmailNoEnv($fecha){

        $sql = "SELECT
        A.idventa,
        A.cantidad,
        A.preciounitario,
        A.total,
        A.fecha,
        A.fk_idmediopago,
        A.fk_idcliente,
        A.fk_iddireccion_otra,
        A.fk_iddireccion_envio,
        A.env_email,
        B.nombre AS producto,
        B.descripcion,
        C.nombre AS mediodepago,
        B.foto
        FROM ventas A INNER JOIN productos B ON A.fk_idproducto = B.idproducto 
        INNER JOIN	medios_pago C  on A.fk_idmediopago = C.idmediopago
         WHERE A.env_email =0 AND A.fecha = '$fecha'";
        $lstVenta = DB::select($sql);
        return $lstVenta;
    }


}
