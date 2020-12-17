<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Banco;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
 
require app_path().'/start/constants.php';
use Session;
 
class ControladorBanco extends Controller{

    public function index(){
        $titulo="Banco";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('transferenciabancaria.transferenciabancaria', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

   public function nuevo(){

       $titulo = "Nuevo Banco";
       $entidad = new Banco();
       $array_bancos = $entidad->obtenerTodos();
    
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
               return view('transferenciabancaria.transferenciabancaria', compact('titulo', 'array_bancos'));  
            }
        } else {
            return redirect('admin/login');
        }


        
   }

}
