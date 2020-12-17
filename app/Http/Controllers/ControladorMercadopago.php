<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\MercadoPago;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Medio_pago;

use Exception;

require app_path().'/start/constants.php';
use Session;
 
class ControladorMercadopago extends Controller{ 
   public function index(){
        $titulo="Metodo Mercado Pago";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $mercadopago= new MercadoPago();
                $mercadopago->obtener();
                return view('mercadopago.mercadopago', compact('mercadopago','titulo'));
            }
        } else {
            return redirect('admin/login');
        }
        return view('mercadopago.mercadopago', compact('titulo'));
    }

     public function guardar(Request $request){    
        try {        
        $titulo = "Modificar Medio de Pago"; 
        $mercadopago = new MercadoPago()
        ;                                           
        $mercadopago->token_acceso = $request->input("txtTokenAcceso");
        $mercadopago->clave_publica = $request->input("txtClavePublica");
                            
        $mercadopago->guardar();
        $msg["ESTADO"] = MSG_SUCCESS;
        $msg["MSG"] = OKINSERT;                   
        
        return view('mercadopago.mercadopago', compact('titulo', 'msg','mercadopago'));
    
                 } catch (Exception $e) {
        $msg["ESTADO"] = MSG_ERROR;
        $msg["MSG"] = ERRORINSERT;
    }           
      }
}
 

