<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Incidente;
use App\Entidades\Estados_incidente;
use App\Entidades\respuesta_incidente;
use App\Entidades\Cliente;
use Session;
use App\Entidades\Moneda;
use App\Entidades\Categoria;

class ControladorWebContacto extends Controller
{
   

    public function index()
    {
        $titulo = "Contacto";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CONTACTOCONSULTA")) {
                $moneda = new Moneda;
                $array_moneda = $moneda->obtenerTodos();  
                $codigo = "CONTACTOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                
                return view('web.login', compact('titulo', 'codigo', 'mensaje','array_moneda'));
            } else {
                $moneda = new Moneda;
                $array_moneda = $moneda->obtenerTodos();    
                return view('web.contacto', compact('titulo','array_moneda'));
            }
        } else {
            return redirect('/login');
        }
    }

}