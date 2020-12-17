<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Cliente;
use App\Entidades\Categoria;
use App\Entidades\Moneda;
use Exception;
use Session;

class ControladorWebMicuenta extends Controller
{
    public function index(Request $request){
        if (Usuario::autenticado()==true) {
            $titulo = "Mi cuenta";
            $moneda = new Moneda;
            $array_moneda = $moneda->obtenerTodos();
            $idUsuario = Session::get('usuario_id');
            $entidadUsuario = new Usuario();
            $array_usuario = $entidadUsuario->obtenerPorIdUsuario($idUsuario);
            $entidadCliente = new Cliente();
            $aCliente = $entidadCliente->obtenerFiltrado();
            $categoria = new Categoria();
            $array_categoria = $categoria->obtenerTodos();
            return view('web.micuenta', compact('titulo', 'array_moneda', 'array_usuario', 'aCliente', 'array_categoria'));
            }else {
                $titulo = "Login";
                $msg["MSG"] = "Inicie sesión para continuar";
                $msg["ESTADO"] = MSG_ERROR;
                $moneda = new Moneda;
                $array_moneda = $moneda->obtenerTodos();
                $categoria = new Categoria();
                $array_categoria = $categoria->obtenerTodos();
                return view('web.login', compact('titulo', 'msg', 'array_moneda', 'array_categoria'));
            }
    }
    public function guardar(Request $request)
    {
        try{
            $titulo = "Mi cuenta";
            $entidadUsuario = new Usuario();
            $entidadUsuario->cargarDesdeRequest($request);
            if ($entidadUsuario->nombre == "" || $entidadUsuario->apellido == "" || $entidadUsuario->mail == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = USUARIOFALTACAMPOS;
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidadUsuario->guardar();
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
            }
            $usuario = new Usuario();
            $usuario->obtenerPorUsuario($request->input('txtUsuario'));

            return view('web.micuenta', compact('titulo','msg','usuario')). '?id' . $request->input('txtUsuario');
            
        }catch (Exception $e){
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
    }
}