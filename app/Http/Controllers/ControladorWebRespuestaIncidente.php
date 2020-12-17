<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Cliente;
use App\Entidades\Sistema\Producto;
use App\Entidades\Venta;
use App\Entidades\Incidente;
use App\Entidades\Sistema\Patente;
use App\Entidades\Estados_Incidente;
use App\Entidades\Respuesta_Incidente;
use App\Entidades\Moneda;
use Session;

class ControladorWebRespuestaIncidente extends Controller
{
    
    public function index()
    {
        $titulo = "Seguimiento de incidentes";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("RESPUESTAINCIDENTECONSULTA")) {
                $codigo = "INGRESE USUARIO Y VUELVA A INTENTAR";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                $moneda = new Moneda;
                $array_moneda = $moneda->obtenerTodos();
                return view('web.login', compact('titulo', 'codigo', 'mensaje','array_moneda'));
            } else {
                $moneda = new Moneda;
                $array_moneda = $moneda->obtenerTodos();
                return view('web.respuestaincidente', compact('titulo','array_moneda'));
            }
        } else {
            return redirect('/login');
        }
    }

}


?>