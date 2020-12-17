<?php

namespace App\Http\Controllers;

use App\Entidades\Localidad;
use App\Entidades\Provincia;
use App\Entidades\Sucursal;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;
//Colocar en el resto de controllers

require app_path() . '/start/constants.php';

class ControladorSucursal extends Controller
{

    public function index(){
        $titulo="Sucursales";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("SUCURSALCONSULTA")) {
                $codigo = "SUCURSALCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('sucursal.sucursal-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }


    public function nuevo()
    {
        $titulo = "Nueva sucursal";

        $localidad = new Localidad();
        $array_localidad = $localidad->obtenerTodos();

        $provincia = new Provincia();
        $array_provincia = $provincia->obtenerTodos();

        return view('sucursal.sucursal-nuevo', compact('titulo', 'array_localidad', 'array_provincia'));
    }

    public function editar($id) //TODO: Preguntar si hace falta obtener todos para localidad y provincia

    {
        $titulo = "Modificar Sucursal";

        $sucursal = new Sucursal();
        $sucursal->obtenerPorId($id);

        $localidad = new Localidad();
        $array_localidad = $localidad->obtenerTodos();

        $provincia = new Provincia();
        $array_provincia = $provincia->obtenerTodos();

        return view('sucursal.sucursal-nuevo', compact('titulo', 'sucursal', 'array_localidad', 'array_provincia'));
    }

    public function guardar(Request $request)
    {

        try {
            $titulo = "Sucursales";
            $entidadSucursal = new Sucursal();
            $entidadSucursal->cargarDesdeRequest($request);

            if ($entidadSucursal->nombre == "" || $entidadSucursal->direccion == "" || $entidadSucursal->fk_idlocalidad == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
                
            } else {
                if ($_POST["id"] > 0) {
                    $entidadSucursal->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    $entidadSucursal->insertar();                    

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                $_POST["id"] = $entidadSucursal->idsucursal;
                return view('sucursal.sucursal-listar', compact('titulo', 'msg'));
            }

        } catch (Exception $e) {

        }
    }

    public function eliminar(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("SUCURSALELIMINAR")) {
                $entidad = new Menu();
                $entidad->cargarDesdeRequest($request);
                $entidad->eliminar();

                $aResultado["err"] = EXIT_SUCCESS;
            } else {
                $codigo = "ELIMINARPROFESIONAL";
                $aResultado["err"] = "No tiene permisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
        } else {
            return redirect('admin/login');
        }
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Sucursal();
        $aSucursal = $entidad->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aSucursal) > 0) {
            $cont = 0;
        }

        for ($i = $inicio; $i < count($aSucursal) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/sucursal/' . $aSucursal[$i]->idsucursal . '">' . $aSucursal[$i]->nombre . '</a>';
            $row[] = $aSucursal[$i]->direccion;
            $row[] = $aSucursal[$i]->localidad;
            $row[] = $aSucursal[$i]->provincia;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aSucursal),
            "recordsFiltered" => count($aSucursal),
            "data" => $data
        );
        return json_encode($json_data);
    }
}
