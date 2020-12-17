<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Marca;

require app_path() . '/start/constants.php';

use Session;

class ControladorMarca extends Controller
{
    public function index()
    {
        $titulo = "Listado de Marcas";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MARCACONSULTA")) {
                $codigo = "MARCACONSULTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $titulo = "Listado de Marcas";
                return view('marca.marca-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }

    }

    public function nuevo()
    {
        $titulo = "Nueva Marca";

        $marca = new Marca();

        return view('marca.marca-nuevo', compact('titulo'));
    }

    public function guardar(Request $request)
    {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Marca";
            $marca = new Marca();
            $marca->cargarDesdeRequest($request);

            //validaciones
            if ($marca->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST['id'] > 0) {
                    //Es actualizacion
                    $marca->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo

                    $marca->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                $_POST["id"] = $marca->idmarca;
                return view('marca.marca-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
    }
    public function eliminar(Request $request)
    {
        $id = $request->input('id');

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("MARCAELIMINAR")) {

                $marca = new Marca();
                $marca->cargarDesdeRequest($request);
                $marca->eliminar();

                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente

            } else {
                $codigo = "MARCAELIMINAR";
                $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
            return redirect('/admin/marcas');
        } else {
            return redirect('admin/login');
        }
    }
    public function editar($id)
    {
        $titulo = "Modificar Marca";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MARCAMODIFICACION")) {
                $codigo = "MARCAMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $marca = new Marca();
                $marca->obtenerPorId($id);

                //$entidad = new Marca();

                return view('marca.marca-nuevo', compact('titulo', 'marca'));
            }
        } else {
            return redirect('admin/login');
        }
    }
    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $marca = new Marca();
        $aMarca = $marca->obtenerFiltrado();


        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aMarca) > 0) {
            $cont = 0;
        }
        for ($i = $inicio; $i < count($aMarca) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/marca/' . $aMarca[$i]->idmarca . '">' . $aMarca[$i]->nombre . '</a>';
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aMarca), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aMarca), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
}
