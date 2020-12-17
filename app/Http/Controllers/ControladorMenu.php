<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Menu;
use App\Entidades\Sistema\MenuArea;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorMenu extends Controller
{
    public function index()
    {
        $titulo = "Menú";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('sistema.menu-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidadMenu = new Menu();
        $aMenu = $entidadMenu->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aMenu) > 0) {
            $cont = 0;
        }

        for ($i = $inicio; $i < count($aMenu) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/sistema/menu/' . $aMenu[$i]->idmenu . '">' . $aMenu[$i]->nombre . '</a>';
            $row[] = $aMenu[$i]->padre;
            $row[] = $aMenu[$i]->url;
            $row[] = $aMenu[$i]->activo;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aMenu), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aMenu), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function nuevo()
    {
        $titulo = "Nuevo Menú";

        $entidad = new Menu();
        $array_menu = $entidad->obtenerMenuPadre();

        return view('sistema.menu-nuevo', compact('titulo', 'array_menu'));

    }

    public function editar($id)
    {
        $titulo = "Modificar Menú";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $menu = new Menu();
                $menu->obtenerPorId($id);

                $entidad = new Menu();
                $array_menu = $entidad->obtenerMenuPadre($id);

                $menu_grupo = new MenuArea();
                $array_menu_grupo = $menu_grupo->obtenerPorMenu($id);

                return view('sistema.menu-nuevo', compact('menu', 'titulo', 'array_menu', 'array_menu_grupo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function eliminar(Request $request)
    {
        $id = $request->input('id');

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("MENUELIMINAR")) {

                $menu_grupo = new MenuArea();
                $menu_grupo->fk_idmenu = $id;
                $menu_grupo->eliminarPorMenu();

                $entidad = new Menu();
                $entidad->cargarDesdeRequest($request);
                $entidad->eliminar();

                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
            } else {
                $codigo = "ELIMINARPROFESIONAL";
                $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
        } else {
            return redirect('admin/login');
        }
    }

    public function guardar(Request $request)
    {
        try {
            //Define la entidad servicio
            $titulo = "Modificar menú";
            $entidad = new Menu();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
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
                $menu_grupo = new MenuArea();
                $menu_grupo->fk_idmenu = $entidad->idmenu;
                $menu_grupo->eliminarPorMenu();
                if ($request->input("chk_grupo") != null && count($request->input("chk_grupo")) > 0) {
                    foreach ($request->input("chk_grupo") as $grupo_id) {
                        $menu_grupo->fk_idarea = $grupo_id;
                        $menu_grupo->insertar();
                    }
                }
                $_POST["id"] = $entidad->idmenu;
                return view('sistema.menu-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idmenu;
        $menu = new Menu();
        $menu->obtenerPorId($id);

        $entidad = new Menu();
        $array_menu = $entidad->obtenerMenuPadre($id);

        $menu_grupo = new MenuArea();
        $array_menu_grupo = $menu_grupo->obtenerPorMenu($id);

        return view('sistema.menu-nuevo', compact('msg', 'menu', 'titulo', 'array_menu', 'array_menu_grupo')) . '?id=' . $menu->idmenu;

    }
}
