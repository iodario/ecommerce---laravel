<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Entidades\Producto;
use App\Entidades\Sucursal;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Categoria;
use App\Entidades\Marca;

require app_path() . '/start/constants.php';
use Session;

 
class ControladorProducto extends Controller{
   public function nuevo(){
    
       $titulo = "Nuevo producto";
       $producto = new Producto();
       $categoria = new Categoria();
       $aCategoria = $categoria->obtenerTodos();
       $sucursal = new Sucursal();
       $array_sucursal = $sucursal->obtenerTodos();
       $marca=new Marca();
       $array_marca=$marca->obtenerTodos();
      
      return view('producto.producto-nuevo', compact('titulo', 'array_sucursal','aCategoria', 'producto', 'array_marca'));   
    }

   public function index(){
        $titulo = "Productos";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
              
                return view('producto.producto-listado', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }
    
    

     public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidadProducto = new Producto();
        $aProducto = $entidadProducto->obtenerFiltrado();
      
      
        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aProducto) > 0) {
            $cont = 0;
        }

        for ($i = $inicio; $i < count($aProducto) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/producto/' . $aProducto[$i]->idproducto . '">' . $aProducto[$i]->nombre . '</a>';
            $row[] = $aProducto[$i]->descripcion;
            $row[] = $aProducto[$i]->foto;
            $row[] = $aProducto[$i]->video;
            $row[] = $aProducto[$i]->stock;
            $row[] = '$'.number_format ( $aProducto[$i]->precio , 2, ",", ".") ;
            $row[] = '$'.number_format ( $aProducto[$i]->precio_con_descuento , 2, ",", ".");
            $row[] = $aProducto[$i]->etiqueta;
            $row[] = $aProducto[$i]->sucursal;
            $row[]=$aProducto[$i]->categoria;
            $row[]=$aProducto[$i]->marca;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aProducto), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aProducto), //cantidad total de registros en la paginacion
            "data" => $data
        );
    
        return json_encode($json_data);
    }

    public function editar($id)
    {

        $titulo = "Modificar Producto";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $producto = new Producto();
                $producto->obtenerPorId($id);
                
                $sucursal = new Sucursal();
                $array_sucursal = $sucursal->obtenerTodos();
                $categoria=new Categoria();
                $aCategoria = $categoria->obtenerTodos();
                $marca = new Marca();
                $array_marca=$marca->obtenerTodos();
                return view('producto.producto-nuevo', compact('producto', 'titulo', 'array_sucursal','aCategoria', 'array_marca'));
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
               $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
                $entidad = new Producto();
                $entidad->cargarDesdeRequest($request);
              
                $entidad->eliminar();

                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
            } else {
                $codigo = "ELIMINARPRO";
                $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
        } else {
            return redirect('admin/login');
        }
    }

    public function guardar(Request $request)
    {
        $idproducto = $request['id'];
        try {
            //Define la entidad servicio
            $titulo = "Modificar producto";
            $entidad = new Producto();
            $entidad->cargarDesdeRequest($request);
            $idproducto= $_REQUEST['id'];
            $nombreImagen="";
            
          
            if($_FILES["archivo"]["error"]===UPLOAD_ERR_OK){
                $nombreAleatorio = date("Ymdhmsi");
                $archivo_tmp = $_FILES["archivo"]["tmp_name"];
                $nombreArchivo = $_FILES["archivo"]["name"];
                $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
                $nombreImagen = $nombreAleatorio . "." . $extension;
                move_uploaded_file($archivo_tmp, env('APP_PATH') . "/public/images/$nombreImagen");      
            }

            
            //validaciones
            if ($entidad->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            }
            else
            {
                if ($_POST["id"] > 0) 
                {
                    $productoAnt =new Producto();
                    $productoAnt->obtenerPorId($entidad->idproducto);

                    if(isset($_FILES["archivo"]) && $_FILES["archivo"]["name"] != "")
                    {
                        $archivoAnterior = $_FILES["archivo"]["name"];
                        if($archivoAnterior !="")
                        {
                            @unlink(env('APP_PATH') . "public/images/$archivoAnterior");
                        }else{$entidad->imagen = $productoAnt->imagen;}
                     
                        $archivoAnterior = $productoAnt->foto;
                        if($archivoAnterior !="")
                        {
                            @unlink(env('APP_PATH') . "/public/images/$archivoAnterior");
                        }
                        $nombreArchivo = $_FILES["archivo"]["name"];
                        $nombre = $nombre = date("Ymdhmsi") . "_" . $nombreArchivo;
                        $entidad->foto = $nombre;


                    }else{$entidad->foto = $productoAnt->foto;}
                                      
                    //Es actualizacion
                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                 
                    
                    $entidad->foto = "/images/$nombreImagen";
                    $entidad->insertar();


                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                /*$menu_grupo = new MenuArea();
                $menu_grupo->fk_idmenu = $entidad->idmenu;
                $menu_grupo->eliminarPorMenu();
                if ($request->input("chk_grupo") != null && count($request->input("chk_grupo")) > 0) {
                    foreach ($request->input("chk_grupo") as $grupo_id) {
                        $menu_grupo->fk_idarea = $grupo_id;
                        $menu_grupo->insertar();
                    }
                }*/
                $_POST["id"] = $entidad->idproducto;
                return view('producto.producto-listado', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idproducto;
        $producto = new Producto();
        $producto->obtenerPorId($id);

        return view('producto.producto-nuevo', compact('msg', 'producto', 'titulo', 'array_producto')) . '?id=' . $producto->idproducto;

    }

 
}


