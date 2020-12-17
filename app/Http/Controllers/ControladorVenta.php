<?php

namespace App\Http\Controllers;

use App\Entidades\Venta;
use App\Entidades\Producto;
use App\Entidades\Cliente;
use App\Entidades\Medio_Pago;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;

require app_path() . '/start/constants.php';

class ControladorVenta extends Controller
{

 public function index()
    {
        $titulo = "Venta";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('venta.venta-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    // public function nuevo(){
    //     $titulo = "Nueva venta";

    //     $venta = new Venta();
    //     $array_venta = $venta->obtenerTodos();

    //     $cliente = new Cliente();
    //     $array_cliente = $cliente->obtenerTodos();

    //     $producto = new Producto();
    //     $array_producto = $producto->obtenerTodos();

    //     $mediopago = new Medio_Pago();
    //     $array_mediopago = $mediopago->obtenerTodos();

    //     return view('venta.venta-nuevo', compact('titulo', 'array_venta', 'array_cliente', 'array_producto' ,'array_mediopago'));
    // }

    // public function editar($id){
    //     $titulo = "Modificar venta";

    //     $venta = new Venta();
    //     $array_venta = $venta->obtenerTodos();

    //     $cliente = new Cliente();
    //     $array_cliente = $cliente->obtenerTodos();

    //     $producto = new Producto();
    //     $array_producto = $producto->obtenerTodos();

    //     $mediopago = new Medio_Pago();
    //     $array_mediopago = $mediopago->obtenerTodos();

    //     return view('venta.venta-nuevo', compact('titulo', 'array_venta', 'array_cliente', 'array_producto', 'array_mediopago'));
    // }

    // public function guardar(Request $request){
    //     try{
    //         $titulo = "Venta";
            
    //         $venta = new Venta();
    //         $venta->cargarDesdeRequest($request);

    //         if($venta->cantidad == null || $venta->preciounitario == null || $venta->total == null | $venta->fecha == "" || $venta->fk_idmediopago == "" || $venta->fk_idcliente == "" || $venta->fk_idproducto == ""){
    //             $msg["ESTADO"] = MSG_ERROR;
    //             $msg["MSG"] = "Complete todos los datos";
    //         } else {
    //             if($_POST['id'] > 0){
    //                 $venta->guardar();

    //                 $msg["ESTADO"] = MSG_SUCCESS;
    //                 $msg["MSG"] = OKINSERT;
    //             } else {
    //                 $vendedor->insertar();

    //                 $msg["ESTADO"] = MSG_SUCCESS;
    //                 $msg["MSG"] = OKINSERT;
    //             }
    //             $_POST["id"] = $venta->idventa;
    //             return view('venta.venta-listar', compact('titulo', 'msg'));
    //         }
    //     } catch (Exception $e){

    //     }
    // }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidad = new Venta();
        $aVenta = $entidad->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if(count($aVenta) > 0){
            $cont = 0;
        }

        for($i = $inicio; $i < count($aVenta) && $cont < $registros_por_pagina; $i++){
            $row = array();
            $fecha = date_create($aVenta[$i]->fecha);
            $row[] = date_format($fecha, "Y/m/d H:i:s");
            $row[] = $aVenta[$i]->producto;
            $row[] = $aVenta[$i]->cantidad;
            $row[] = number_format($aVenta[$i]->preciounitario, "2", ",", ".");
            $row[] = number_format($aVenta[$i]->total, "2", ",", ".");
            $row[] = '<a href="/admin/usuarios/' . $aVenta[$i]->cliente .'" target="_blank">' . $aVenta[$i]->cliente . " " . $aVenta[$i]->apellido .'</a>';
            $row[] = $aVenta[$i]->medio_pago;
            $cont++;
            $data[] = $row;

        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aVenta),
            "recordsFiltered" => count($aVenta),
            "data" => $data
        );
        return json_encode($json_data);
    }
}

?>