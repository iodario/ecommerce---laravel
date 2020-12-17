<?php


namespace App\Http\Controllers;

use App\Entidades\Categoria;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Producto;
use Session;
use App\Entidades\Moneda;

require app_path().'/start/constants.php';

class ControladorWebLogin extends Controller
{
    public function index(Request $request){
        $titulo = "Login";
        $moneda = new Moneda;
        $array_moneda = $moneda->obtenerTodos();
        $categoria = new Categoria();
        $array_categoria = $categoria->obtenerTodos();
        return view('web.login', compact('titulo','array_moneda','array_categoria'));
    }

    public function login(Request $request){

        $moneda = new Moneda;
        $array_moneda = $moneda->obtenerTodos();
        return view('web.index', compact('moneda','array_moneda'));
    }

    public function logout(Request $request){
        
        $titulo = "Login";
        $request->session()->put('usuario_id', "");
        $request->session()->put('cliente_id', "");
        $request->session()->put('usuario_nombre', "");
        $moneda = new Moneda;
        $array_moneda = $moneda->obtenerTodos();
        
         return redirect('/login');
    }

    public function entrar(Request $request){
        $usuario = trim($request->input('txtUsuario'));
        $clave =  trim($request->input('txtClave'));
        $moneda = new Moneda;
        $array_moneda = $moneda->obtenerTodos();

        $entidadUsuario = new Usuario();
        $usuarioRetornado = $entidadUsuario->validarUsuario($usuario);
  
       
        if(count($usuarioRetornado) > 0){
           
            if($entidadUsuario->validarClave($clave, $usuarioRetornado[0]->clave)){
                
                $titulo = "Inicio";
                $request->session()->put('usuario_id', $usuarioRetornado[0]->idusuario);
                $request->session()->put('cliente_id', $usuarioRetornado[0]->idcliente);
                $request->session()->put('usuario_nombre', $usuarioRetornado[0]->nombre);
                

                return redirect('/');
            } else {
                $titulo = "Login";
                $msg["MSG"] = "Datos incorrectos, vuelva a intentar";
                $msg["ESTADO"] = MSG_ERROR;
                return view('web.login', compact('titulo', 'msg','array_moneda'));
            }
            
        } else {
            $titulo = "Login";
            $msg["MSG"] = "Datos incorrectos, vuelva a intentar";
            $msg["ESTADO"] = MSG_ERROR;
            return view('web.login', compact('titulo', 'msg','array_moneda'));
        }

        
        
    }
}
