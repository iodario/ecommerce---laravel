<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Area;
use App\Entidades\Sistema\Menu;
require app_path().'/start/constants.php';
use Session;

class ControladorGrupo extends Controller
{
    public function index(){
        $titulo = "Listado de grupos";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("GRUPOCONSULTA")) {
                $codigo = "GRUPOCONSULTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                 return view('sistema.grupo-listar', compact('titulo'));
            }
        } else {
           return redirect('admin/login');
        }   
    }

    public function nuevo(){
        $titulo = "Nuevo grupo";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("GRUPOALTA")) {
                $codigo = "GRUPOALTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                 return view('sistema.grupo-nuevo');
            }
        } else {
           return redirect('admin/login');
        }   
    }

    public function editar($id){
        $titulo = "Modificar grupo";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("GRUPOMODIFICACION")) {
                $codigo = "GRUPOMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $grupo = new Area();
                $grupo->obtenerPorId($id);
                return view('sistema.grupo-nuevo', compact('grupo'));
            }
        } else {
           return redirect('admin/login');
        }
    }

    public function cargarGrilla() {
        $requestData = $_REQUEST;
        $entidad = new Area();

        $grupos = $entidad->obtenerGrilla();
        
        $data = array();

        if (count($grupos) > 0)
            $cont=0;
            for ($i=0; $i < count($grupos); $i++) {
                $row = array();
                $row[] = '<a href="/admin/grupo/' . $grupos[$i]->idarea . '">' . $grupos[$i]->descarea . '</a>';
                $row[] = $grupos[$i]->ncarea;
                $row[] = $grupos[$i]->activo == ACTIVO ? "Si" : "No";
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "recordsTotal" => count($grupos),
            "recordsFiltered" => count($grupos),
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function cargarGrillaGruposDelUsuario() { // otra cosa
        $request = $_REQUEST;
        $usuarioID = ($_REQUEST["us"]);

        $entidad = new Area();

        $grupos = $entidad->obtenerGruposDelUsuario($usuarioID);

        $data = array();

        if (count($grupos) > 0)
            $cont=0;
            for ($i=0; $i < count($grupos); $i++) {
                $row = array();
                $row[] = $grupos[$i]->idarea;
                $row[] = "<input id='chk_Grupo_" . $grupos[$i]->idarea . "' name='chk_Grupo_" . $grupos[$i]->idarea . "' type='checkbox' />";
                $row[] = $grupos[$i]->nombre;
                $row[] = "<input type='radio' value='" . $grupos[$i]->idarea . "' name='optGrupoDefault' id='optGrupo_" . $grupos[$i]->idarea . "'" . ($grupos[$i]->predeterminado == ACTIVO ? 'checked' : '') . " />";
     
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "recordsTotal" => count($grupos),
            "recordsFiltered" => count($grupos),
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function cargarGrillaGruposDisponibles() { // otra cosa
        $request = $_REQUEST;

        $entidadGrupo = new Area();

        $grupos = $entidadGrupo->obtenerGrilla();

        $data = array();
        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($grupos) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($grupos) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = $grupos[$i]->idarea;
                $row[] = "<input id='chk_GrupoAdd_" . $grupos[$i]->idarea . "' type='checkbox' />";
                $row[] = $grupos[$i]->nombre;
     
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($grupos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($grupos),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function setearGrupo(Request $request) {
        Session::forget('grupo_id');
        Session::forget('array_menu');
        $idGrupo = $request->input('id');
        
        //Seteo grupo por defecto
        $request->session()->put('grupo_id', $idGrupo);

        //Carga nuevo menu del grupo
        $menu = new Menu();
        $aMenu = $menu->obtenerMenuDelGrupo($idGrupo);
        if (count($aMenu) > 0) {
            $request->session()->put('array_menu',$aMenu);
        }

        $aResultado["err"] = EXIT_SUCCESS;
        echo json_encode($aResultado);
    }

    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $entidad = new Area();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->descarea == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = GRUPOFALTANOMBRE;
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidad->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                $_POST["id"] = $entidad->idarea;
                return view('sistema.grupo-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        $grupo = new Area();
        $grupo->obtenerPorId($entidad->idarea);
        return view('sistema.grupo-nuevo', compact('msg', 'grupo')) . '?id' . $grupo->idarea;
    }

}
