<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Menu;
use App\Entidades\Sistema\MenuArea;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;
use App\Entidades\Vendedor;
use App\Entidades\Sucursal;

require app_path() . '/start/constants.php';

class ControladorVendedor extends Controller
{
    public function nuevo()
    {
        $titulo = "Nuevo vendedor";
        $sucursal = new Sucursal;
        $array_sucursal = $sucursal->obtenerTodos();        
        $usuario = new Usuario;
        $array_usuario = $usuario->obtenerTodos();        
        return view('vendedor.vendedor-nuevo', compact('titulo', 'array_usuario', 'array_sucursal'));
    }

    public function index()
    {
        $titulo = "Vendedores";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('vendedor.vendedor-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidadVendedor = new Vendedor();
        $aVendedor = $entidadVendedor->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aVendedor) > 0) {
            $cont = 0;
        }

        for ($i = $inicio; $i < count($aVendedor) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/vendedor/' . $aVendedor[$i]->idvendedor . '">' . $aVendedor[$i]->nombre. '</a>';
            $row[] = $aVendedor[$i]->usuario;
            $row[] = $aVendedor[$i]->sucursal;
            $row[] = $aVendedor[$i]->cuil;
            $cont++;
            $data[] = $row;

        }
        //print_r($aVendedor); exit;
        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aVendedor), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aVendedor), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function guardar(Request $request)
    {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Vendedor";
            $vendedor = new Vendedor();
            $vendedor->cargarDesdeRequest($request);

            //validaciones
            if ($vendedor->fk_idusuario == "" || $vendedor->fk_idsucursal == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST['id']>0) {
                    //Es actualizacion
                    $vendedor->guardar();
                    
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo

                    $vendedor->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                $_POST["id"] = $vendedor->idvendedor;
                return view('vendedor.vendedor-listar', compact('titulo', 'msg'));
            }

        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $sucursal = new Sucursal;
        $array_sucursal = $sucursal->obtenerTodos();
        $usuario = new Usuario;
        $array_usuario = $usuario->obtenerTodos();

        return view('vendedor.vendedor-nuevo', compact('msg', 'titulo', 'vendedor', 'array_usuario', 'array_sucursal'));


    }

    public function editar($id)
    {
        $titulo = "Modificar vendedor";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $vendedor = new Vendedor();
                $vendedor->obtenerPorId($id);

                $usuario = new Usuario();
                $array_usuario = $usuario->obtenerTodos();

                $sucursal = new Sucursal();
                $array_sucursal = $sucursal->obtenerTodos();

                return view('vendedor.vendedor-nuevo', compact('titulo','vendedor', 'array_sucursal','array_usuario'));
            }
        } else {
            return redirect('admin/login');
        }
    }


}