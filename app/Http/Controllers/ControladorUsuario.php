<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\UsuarioArea;
use App\Entidades\Sistema\Usuario_familia;
use App\Entidades\Sistema\Area;
use App\Entidades\Legajo\Personal;
require app_path().'/start/constants.php';
use Session;

class ControladorUsuario extends Controller
{
    public function index(){
        $titulo = "Listado de usuarios";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("USUARIOCONSULTA")) {
                $codigo = "USUARIOCONSULTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $titulo = "Listado de usuarios";
                return view('sistema.listar', compact('titulo'));
            }
        } else {
           return redirect('admin/login');
        }
    }

    public function nuevo(){
        $titulo = "Nuevo usuario";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("USUARIOALTA")) {
                $codigo = "USUARIOALTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                /* CAMBIOS PARA EL DESPLEGABLE */
                $area = new Area();
                $array_area =  $area->obtenerTodos();

                $grupo = new Area();
                $array_grupo = $grupo->obtenerTodos();

                return view('sistema.nuevo-usuario', compact('array_area', 'array_grupo'));
            }
        } else {
           return redirect('admin/login');
        }        
    }

    public function editar($us){
        $titulo = "Modificar usuario";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("USUARIOMODIFICAR")) {
                $codigo = "USUARIOMODIFICAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $usuario = new Usuario();
                $usuario->obtenerPorUsuario($us);

                $area = new Area();
                $array_area =  $area->obtenerTodos();

                $grupo = new Area();
                $array_grupo = $grupo->obtenerTodos();

                return view('sistema.nuevo-usuario', compact('usuario','array_area', 'array_grupo'));
            }
        } else {
           return redirect('admin/login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadUsuario = new Usuario();
        $usuarios = $entidadUsuario->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($usuarios) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($usuarios) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/admin/usuarios/' . $usuarios[$i]->usuario . '">' . $usuarios[$i]->usuario . '</a>';
                $row[] = $usuarios[$i]->nombre;
                $row[] = $usuarios[$i]->apellido;
                $row[] = $usuarios[$i]->created_at != ""? date_format(date_create($usuarios[$i]->created_at), 'Y-m-d H:i') : "";
                $row[] = $usuarios[$i]->ultimo_ingreso != "" ?date_format(date_create($usuarios[$i]->ultimo_ingreso), 'Y-m-d H:i') : "";
                $row[] = $usuarios[$i]->root == 1 ? "Si" : "No";
                $row[] = $usuarios[$i]->activo == 1 ? "Si" : "No";
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($usuarios), //cantidad total de registros sin paginar
            "recordsFiltered" => count($usuarios),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Usuario";
            $entidadUsuario = new Usuario();
            $entidadUsuario->cargarDesdeRequest($request);

            //validaciones
            if ($entidadUsuario->usuario == "" || $entidadUsuario->mail == "" || $entidadUsuario->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = USUARIOFALTACAMPOS;
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidadUsuario->guardar();

                    //Actualiza en datos personales
                    //$legajo = new Personal();
                    //$legajo->guardarDesdeUsuario($entidadUsuario);

                } else {
                    //Inserta en datos personales
                    //$legajo = new Personal();
                    //$legajo->insertarDesdeUsuario($entidadUsuario);

                    //Es nuevo
                    //$entidadUsuario->fk_idlegajo = $legajo->idlegajo;
                    $entidadUsuario->insertar();
                    $_POST["id"] = $entidadUsuario->idusuario;
                }

                if (Patente::autorizarOperacion("USUARIOAGREGARPERMISO")) {

                    //Guarda las patentes de la familia
                    $familiaUsuario = new Usuario_familia();

                    //Elimina todos las familias del usuario
                    $aFamiliaAsignados = $familiaUsuario->eliminarPorUsuario($entidadUsuario->idusuario);

                    //Obtiene las familias a asignar al usuario
                    $aFamiliaSinAsignar = array();
                    foreach ($_POST as $nombre => $valor) {
                        if (substr($nombre,0,12) == "chk_Familia_") {
                        	$idCompuesto = explode("_", substr($nombre,12,strlen($nombre)));
                            $idFamilia = $idCompuesto[0];
                            $idArea = $idCompuesto[1];
                            $familiaUsuario->fk_idfamilia = $idFamilia;
                            $familiaUsuario->fk_idarea = $idArea;
                            $familiaUsuario->fk_idusuario = $entidadUsuario->idusuario;
                        	$familiaUsuario->insertar();
                        }
                    }
                }
                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
                return view('sistema.listar', compact('titulo', 'msg'));
            }
            $usuario = new Usuario();
            $usuario->obtenerPorUsuario($request->input('txtUsuario'));
            //return view('sistema.nuevo-usuario', compact('msg', 'usuario')) . '?id' . $request->input('txtUsuario');

            $area = new Area();
            $array_area =  $area->obtenerTodos();

            $grupo = new Area();
            $array_grupo = $grupo->obtenerTodos();

            return view('sistema.nuevo-usuario', compact('array_area','msg','usuario', 'array_grupo')). '?id' . $request->input('txtUsuario');
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }                
    }

    public function buscarUsuario(Request $request){
        $nombre_usuario = $request->input('usuario');
        $usuario = new Usuario();
        $usuario->obtenerPorUsuario($nombre_usuario);
        if($usuario->id != ""){
            $msg["ESTADO"] = MSG_SUCCESS;
            $msg["nombre"] = $usuario->nombre;
            $msg["apellido"] = $usuario->apellido;
            $msg["email"] = $usuario->email;
        } else {
            $msg["ESTADO"] = MSG_ERROR;
        }
        echo json_encode($msg);
    }
    
}
