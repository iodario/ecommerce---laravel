<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Producto;
use App\Entidades\Categoria;
use App\Entidades\Carrito_Compra;
use Session;
use App\Entidades\Moneda;

class ControladorWebHome extends Controller
{
    
    public function index(Request $request){

        $titulo = "Inicio";
        $producto = new Producto();
        $array_producto = $producto->obtenerNuevos();
        $moneda = new Moneda;
        $array_moneda = $moneda->obtenerTodos(); 
                
        // $carrito = new Carrito_Compra;
        // $array_compra = $carrito->obtenerTodosUsuario($id);
        $categoria = new Categoria();
        $array_categoria = $categoria->obtenerTodos();
        $precio = array();
        for($i=0;$i<count($array_producto);$i++){
            $array_producto[$i]->precio = '$'.number_format($array_producto[$i]->precio,2,',','.');
            $array_producto[$i]->precio_con_descuento= '$'.number_format($array_producto[$i]->precio_con_descuento,2,',','.');
        };
        
    
        return view('web.index', compact('titulo','array_producto', 'array_moneda','array_categoria'));
    }

    //HACER CON AJAX
    public function guardarCarrito(Request $request, $idProducto){
        
        $carrito = new Carrito_Compra();
        $carrito->cargarDesdeRequest($request);

        $carrito->fk_idproducto = $idProducto;
        $carrito->cantidad = 1;
        $carrito->fk_idcliente = Session::get('cliente_id'); 
        $carrito->fecha = date('Y-m-d H:m:i');

        $carrito->insertar();

        return redirect('/');

    }

    public function listarCarrito($idCliente){
        $carrito = new Carrito_Compra();
        $carrito->obtenerPorCliente();
    }
}
?>