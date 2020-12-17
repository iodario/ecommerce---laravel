<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Incidente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Cliente;
use App\Entidades\Venta;
use App\Entidades\Estados_Incidente;


require app_path() . '/start/constants.php';

class ControladorIncidente extends Controller
{

    public function index()
    {
        $titulo = "Listado de Incidentes";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("INCIDENTECONSULTA")) {
                $codigo = "INCIDENTECONSULTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $titulo = "Listado de Incidentes";
                return view('incidente.incidente-listado', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }

        // return view('incidente.incidente-listado', compact('titulo'));
    }

    public function nuevo()
    {
        $titulo = "Nuevo Incidente";
        $estadoincidente = new Estados_incidente();
        $array_estados = $estadoincidente->obtenerTodos();
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("INCIDENTEALTA")) {
                $codigo = "INCIDENTEALTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $titulo = "Listado de Incidentes";
                return view('incidente.incidente-listado', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }

        // return view('incidente.incidente-listado', compact('titulo'));
    }


    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidadIncidente = new Incidente();
        $aIncidente = $entidadIncidente->obtenerFiltrado();


        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aIncidente) > 0) {
            $cont = 0;
        }

        for ($i = $inicio; $i < count($aIncidente) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/incidente/' . $aIncidente[$i]->idincidente . '">' . '</a>';
            $row[] = $aIncidente[$i]->telefono;
            $row[] = $aIncidente[$i]->fecha_nac;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aIncidente), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aIncidente), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function editar($id)
    {
        $titulo = "Modificar Incidente";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("INCIDENTEMODIFICACION")) {
                $codigo = "INCIDENTEMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $incidente = new Incidente();
                $incidente->obtenerPorId($id);

                $entidad = new Usuario();
                $array_usuario = $entidad->obtenerTodos($id);



                return view('incidente.incidente-nuevo', compact('incidente', 'array_usuario'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function guardar(Request $request)
    {
        try {
            //Define la entidad
            $titulo = "Modificar incidente";
            $Incidente = new incidente();
            $Incidente->cargarDesdeRequest($request);

            //validaciones
            if ($Incidente->telefono == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST['id'] > 0) {
                    //Es actualizacion
                    $Incidente->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo

                    $Incidente->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                $_POST["id"] = $Incidente->idcliente;
                return view('Incidente.Incidente-listado', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $usuario = new Usuario();
        $array_usuario = $usuario->obtenerTodos();

        return view('incidente.incidente-nuevo', compact('titulo', 'msg', 'incidente', 'array_usuario'));
    }

    public function eliminar(Request $request)
    {
        $id = $request->input('id');

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("INCIDENTEELIMINAR")) {

                $entidad = new Incidente();
                $entidad->cargarDesdeRequest($request);
                $entidad->eliminar();

                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente

            } else {
                $codigo = "INCIDENTEELIMINAR";
                $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
            return redirect('/admin/incidentes');
        } else {
            return redirect('admin/login');
        }
    }
}
