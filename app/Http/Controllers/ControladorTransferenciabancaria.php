<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Medio_pago;
use App\Entidades\Banco;
use App\Entidades\TransferenciaBancaria;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
 
require app_path().'/start/constants.php';
use Session;
 
class ControladorTransferenciabancaria extends Controller{

   public function nuevo(){

       $titulo = "Nueva tranferencia bancaria";
       $entidad = new Banco();
       $array_bancos = $entidad->obtenerTodos();
       $transferencia=new TransferenciaBancaria();
       $array_transferencia=$transferencia->obtenerTodos();
       $pasarTransferencia=$array_transferencia[0];
  
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('transferenciabancaria.transferenciabancaria', compact('titulo', 'array_bancos', 'pasarTransferencia', 'array_sucursal')); 
            }
        } else {
            return redirect('admin/login');
        }
    
         
   }

   public function guardar(){
    
        try {
            //Define la entidad servicio
            $titulo = "Modificar producto";
            $entidad = new TransferenciaBancaria();
            $entidad->cargarDesdeRequest($request);
            $idproducto=$_REQUEST['id'];
          

            //validaciones
            if ($entidad->idtransferencia == "") {
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

                    $msg["ESTADO"] = MSG_ERROR;
                    $msg["MSG"] = "Error";
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
                $_POST["id"] = $entidad->idtransferencia;
                return view('transferenciabancaria.transferenciabancaria', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idtransferencia;
        $transferencia = new TransferenciaBancaria();
        $transferencia->obtenerPorId($id);

        return view('transferenciabancaria.transferenciabancaria', compact('msg', 'transferencia', 'titulo')) . '?id=' . $transferencia->idtransferencia;

    
   }

}
