<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Familia;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Patente_familia;
use App\Entidades\Sistema\Area;
require app_path().'/start/constants.php';


class ControladorPermiso extends Controller
{
    public function index(){
        $titulo = "Listado de permisos";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("PERMISOSCONSULTA")) {
                $codigo = "PERMISOSCONSULTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('sistema.permiso-listar', compact('titulo'));
            }
        } else {
           return redirect('admin/login');
        }   
    }

    public function nuevo(){
        $titulo = "Nuevo permisos";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("PERMISOSALTA")) {
                $codigo = "PERMISOSALTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('sistema.permiso-nuevo');
            }
        } else {
           return redirect('admin/login');
        }           
    }

    public function editar($id){
        $titulo = "Editar permiso";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("PERMISOSMODIFICACION")) {
                $codigo = "PERMISOSMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $permiso = new Familia();
                $permiso->obtenerPorId($id);
                return view('sistema.permiso-nuevo', compact('permiso'));
            }
        } else {
           return redirect('admin/login');
        } 

    }

	public function cargarGrilla() {
        $requestData = $_REQUEST;
        $entidad = new Familia();

        $permiso = $entidad->obtenerGrilla();
        
        $data = array();

        if (count($permiso) > 0)
            $cont=0;
            for ($i=0; $i < count($permiso); $i++) {
                $row = array();
                $row[] = '<a href="/admin/permiso/' . $permiso[$i]->idfamilia . '">' . $permiso[$i]->nombre . '</a>';
                $row[] = $permiso[$i]->descripcion;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "recordsTotal" => count($permiso),
            "recordsFiltered" => count($permiso),
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function cargarGrillaPatentesPorFamilia() {
        $request = $_REQUEST;
        $familiaID = ($_REQUEST["fam"]);

        $entidad = new Patente();

        $patentes = $entidad->obtenerTodosPorFamilia($familiaID);

        $data = array();

        if (count($patentes) > 0)
            $cont=0;
            for ($i=0; $i < count($patentes); $i++) {
                $row = array();
                $row[] = $patentes[$i]->idpatente;
                $row[] = '<input id="chk_PatenteFamilia_' . $patentes[$i]->idpatente . '" name="chk_PatenteFamilia_' . $patentes[$i]->idpatente . '" value="' . $patentes[$i]->idpatente . '" type="checkbox" />';
                $row[] = $patentes[$i]->descripcion;
                $row[] = $patentes[$i]->tipo;
                $row[] = $patentes[$i]->modulo;
                $row[] = $patentes[$i]->submodulo;
                $row[] = $patentes[$i]->nombre;

                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "recordsTotal" => count($patentes),
            "recordsFiltered" => count($patentes),
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function cargarGrillaPatentesDisponibles() {
        $request = $_REQUEST;
        $familiaID = ($_REQUEST["fam"]);

        $entidad = new Patente();

        $patentes = $entidad->obtenerFiltradoDisponibles();

        $data = array();
        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($patentes) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($patentes) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = $patentes[$i]->idpatente;
                $row[] = '<input id="chk_PatenteAdd_' . $patentes[$i]->idpatente . '" type="checkbox" />';
                $row[] = $patentes[$i]->descripcion;
                $row[] = $patentes[$i]->tipo;
                $row[] = $patentes[$i]->modulo;
                $row[] = $patentes[$i]->submodulo;
                $row[] = $patentes[$i]->nombre;

                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($patentes),
            "recordsFiltered" => count($patentes),
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function cargarGrillaFamiliaDisponibles() {
        $request = $_REQUEST;
        $familiaID = ($_REQUEST["fam"]);

        $entidadFamilia = new Familia();

        $aFamilia = $entidadFamilia->obtenerGrilla();

        $data = array();
        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aFamilia) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aFamilia) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = $aFamilia[$i]->idfamilia;
                $row[] = "<input id='chk_FamiliaAdd_" . $aFamilia[$i]->idfamilia . "' type='checkbox' />";
                $row[] = $aFamilia[$i]->nombre;
                $row[] = $aFamilia[$i]->descripcion;
     
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aFamilia),
            "recordsFiltered" => count($aFamilia),
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function cargarGrillaFamiliasDelUsuario() {
        $request = $_REQUEST;
        $usuarioID = ($_REQUEST["us"]);

        $entidadFamilia = new Familia();
        $aFamilia = $entidadFamilia->obtenerTodosPorUsuario($usuarioID);

        $grupo = new Area();
        $array_grupo = $grupo->obtenerTodos();

        $data = array();

        if (count($aFamilia) > 0)
            $cont=0;
            for ($i=0; $i < count($aFamilia); $i++) {
                $row = array();
                $row[] = $aFamilia[$i]->idfamilia;
                $row[] = $aFamilia[$i]->nombre;
                if(count($array_grupo)>0){
                    foreach($array_grupo as $grupo){
                        if($entidadFamilia->validarFamiliaPorUsuarioArea($aFamilia[$i]->idfamilia, $usuarioID, $grupo->idarea)){
        	               	$row[] = "<input checked id='chk_Familia_" . $aFamilia[$i]->idfamilia . "_" . $grupo->idarea . "' name='chk_Familia_" . $aFamilia[$i]->idfamilia . "_". $grupo->idarea  . "' type='checkbox' class='form-control' />";
                        } else {
        	                $row[] = "<input id='chk_Familia_" . $aFamilia[$i]->idfamilia . "_" . $grupo->idarea . "' name='chk_Familia_" . $aFamilia[$i]->idfamilia . "_". $grupo->idarea  . "' type='checkbox' class='form-control' />";
                        }
                    }
                }
     
     
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "recordsTotal" => count($array_grupo),
            "recordsFiltered" => count($array_grupo),
            "data" => $data
        );
        return json_encode($json_data);  
    }

    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $entidad = new Familia();
            $entidad->cargarDesdeRequest($request);
            $titulo= "Permisos";

            //validaciones
            if ($entidad->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = PERMISOFALTANOMBRE;
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar();
                } else {
                    //Es nuevo     
                    $entidad->insertar();
                    $_POST["id"] = $entidad->idfamilia;
                }

                //Guarda las patentes de la familia
                $patenteFamilia = new Patente_familia();
                $patenteFamilia->eliminarPorFamilia($entidad->idfamilia);
                foreach ($_POST as $nombre => $valor) {
                    if (substr($nombre, 0, strlen("chk_PatenteFamilia_") - strlen($nombre)) == "chk_PatenteFamilia_") {
                        $patenteFamilia->fk_idfamilia = $entidad->idfamilia;
                        $patenteFamilia->fk_idpatente = $valor;
                        $patenteFamilia->insertar();
                    }
                }

                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
                return view('sistema.permiso-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $permiso = new Familia();
        $permiso->obtenerPorId($entidad->idfamilia);
        return view('sistema.permiso-nuevo', compact('msg', 'permiso')) . '?id' . $permiso->idfamilia;
    }
}
