<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Categoria;
 
require app_path().'/start/constants.php';
use Session;
 
class ControladorCategoria extends Controller{
    public function index(){
        $titulo="Listado de Categorías";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("CATEGORIACONSULTA")) {
                $codigo = "CATEGORIACONSULTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $titulo = "Listado de Categoria";
                return view('categoria.listado-categorias', compact('titulo'));
            }
        } else {
           return redirect('admin/login');
        }

        return view('categoria.listado-categorias',compact('titulo'));
    }
   public function nuevo(){
    $titulo="Nueva Categoria";
    if(Usuario::autenticado() == true){
        if (!Patente::autorizarOperacion("CATEGORIAALTA")) {
            $codigo = "CATEGORIAALTA";
            $mensaje = "No tiene pemisos para la operaci&oacute;n.";
            $entidad = new Categoria();
            $array_categorias = $entidad->obtenerCategoriasPadre();
            return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));            
        } else {
            $titulo = "Listado de Categorias";
            return view('categoria.listado-categorias', compact('titulo'));
        }
    } else {
       return redirect('admin/login');
    }  
      
   }

   public function guardar(Request $request)
    {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Categoria";
            $entidad = new Categoria();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST['id']>0) {
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
                $_POST["id"] = $entidad->idcategoria;
                return view('categoria.listado-categorias', compact('titulo', 'msg'));
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
            if (Patente::autorizarOperacion("MENUELIMINAR")) {

                $entidad = new Categoria();
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
    public function editar($id)
    {
        $titulo = "Modificar Categoria";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $categoria = new Categoria();
                $categoria->obtenerPorId($id);

                $entidad = new Categoria();
                $array_categorias = $entidad->obtenerCategoriasPadre($id);


                return view('categoria.categoria-nuevo', compact('categoria', 'titulo','array_categorias'));
            }
        } else {
            return redirect('admin/login');
        }
    }
    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidadCategoria= new Categoria();
        $aCategoria = $entidadCategoria->obtenerFiltrado();

        
        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aCategoria) > 0) {
            $cont = 0;
        }
        for ($i = $inicio; $i < count($aCategoria) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/categoria/' . $aCategoria[$i]->idcategoria . '">' . $aCategoria[$i]->categoria. '</a>';
            $row[] = $aCategoria[$i]->padre;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aCategoria), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aCategoria), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
   
}
