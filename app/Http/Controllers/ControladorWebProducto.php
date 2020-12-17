<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Carrito_Compra;
use App\Entidades\Producto;
use App\Entidades\Categoria;
use Session;
use App\Entidades\Moneda;

class ControladorWebProducto extends Controller
{
    public function index($id){
        $titulo = "Producto";
        $moneda = new Moneda;
        $array_moneda = $moneda->obtenerTodos();
        
   
        $producto=new Producto();
        $productoObtenido=$producto->obtenerPorId($id);
        $array_producto[]=$producto->obtenerNuevos();
        $categoria=new Categoria();
        $array_categoria=$categoria->obtenerTodos();

        $productoRelacionado = new Producto;
        $array_producto = $productoRelacionado->obtenerPorCategoria($producto->idproducto,$producto->fk_idcategoria);

        // $carrito = new Carrito_Compra();
        // $array_carrito = $carrito->obtenerTodosUsuario($id);

        return view('web.producto', compact('titulo', 'productoObtenido', 'array_categoria', 'array_moneda', 'array_producto'));
    }

    public function guardarCarrito(Request $request, $idProducto){
        
        $carrito = new Carrito_Compra();
        $carrito->cargarDesdeRequest($request);

        $carrito->fk_idproducto = $idProducto;
        $carrito->cantidad = 1;
        $carrito->fk_idcliente = 1; 
        $carrito->fecha = date('Y-m-d H:m:i');

        $carrito->insertar();

        return redirect('/');

    }
}