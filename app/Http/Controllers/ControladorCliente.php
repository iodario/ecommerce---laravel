<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Patente;
use App\Entidades\Moneda;

require app_path() . '/start/constants.php';

use Session;

class ControladorCliente extends Controller
{
    public function nuevo()
    {
        $titulo = "Nuevo cliente";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CLIENTEALTA")) {
                $titulo = "Nuevo cliente";
                $entidad = new Usuario();
                $array_usuario = $entidad->obtenerTodos();
                $moneda = new Moneda();
                $array_moneda = $moneda->obtenerTodos();
                return view('cliente.cliente-nuevo', compact('titulo', 'array_usuario', 'array_moneda'));
            } else {
                return view('cliente.cliente-listado', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function index()
    {
        $titulo = "Listado de Clientes";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CLIENTECONSULTA")) {
                $codigo = "CLIENTECONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('cliente.cliente-listado', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }


    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidadCliente = new Cliente();
        $aCliente = $entidadCliente->obtenerFiltrado();


        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aCliente) > 0) {
            $cont = 0;
        }

        for ($i = $inicio; $i < count($aCliente) && $cont < $registros_por_pagina; $i++) {
            $row = array();

            $row[] = '<a href="/admin/cliente/' . $aCliente[$i]->idcliente . '">' . $aCliente[$i]->nombre . " " . $aCliente[$i]->apellido . '</a>';
            $row[] = $aCliente[$i]->mail;
            $row[] = $aCliente[$i]->telefono;
            $row[] = $aCliente[$i]->usuario;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aCliente), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aCliente), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function editar($id)
    {
        $titulo = "Modificar Cliente";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CLIENTEEDITAR")) {
                $codigo = "CLIENTEEDITAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $cliente = new Cliente();
                $cliente->obtenerPorId($id);

                $entidad = new Usuario();
                $array_usuario = $entidad->obtenerTodos($id);



                return view('cliente.cliente-nuevo', compact('cliente', 'array_usuario'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function guardar(Request $request)
    {
        try {
            //Define la entidad
            $titulo = "Modificar Cliente";
            $cliente = new Cliente();
            $cliente->cargarDesdeRequest($request);

            //validaciones
            if ($cliente->telefono == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST['id'] > 0) {
                    //Es actualizacion
                    $cliente->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo

                    $cliente->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                $_POST["id"] = $cliente->idcliente;
                return view('cliente.cliente-listado', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $usuario = new Usuario();
        $array_usuario = $usuario->obtenerTodos();

        return view('cliente.cliente-nuevo', compact('titulo', 'msg', 'cliente', 'array_usuario'));
    }

    public function eliminar(Request $request)
    {
        $id = $request->input('id');

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("CLIENTEELIMINAR")) {

                $entidad = new Cliente();
                $entidad->cargarDesdeRequest($request);
                $entidad->eliminar();

                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente

            } else {
                $codigo = "ELIMINARPROFESIONAL";
                $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
            return redirect('/admin/categorias');
        } else {
            return redirect('admin/login');
        }
    }
}
